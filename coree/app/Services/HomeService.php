<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Network;
use App\Services\OfferService;
use App\Services\VPNDetectionService;
use App\Services\MonlixService;
use App\Models\WithdrawalHistory;
use App\Models\Track;

class HomeService
{
    protected $offerService;
    protected $vpnService;
    protected $monlixService;

    // Type-hinting both services for better clarity
    public function __construct(OfferService $offerService, VPNDetectionService $vpnService, MonlixService $monlixService)
    {
        $this->offerService = $offerService;
        $this->vpnService = $vpnService;
        $this->monlixService = $monlixService;
    }


    public function getHomeData(Request $request): array
    {
        $extra = [
            'offer_networks' => [],
            'survey_networks' => [],
        ];

        $data = $this->buildBaseOfferData($request, 30, $extra);

        if (!$data['isVPNDetected']) {
            $user = Auth::user();
            $userUid = $user ? $user->uid : null;
            $data['offer_networks'] = $this->getNetworksByType('offer', $userUid);
            $data['survey_networks'] = $this->getNetworksByType('survey', $userUid);
        }

        return $data;
    }

    public function getAllOffers(Request $request): array
    {
        return $this->buildBaseOfferData($request);
    }

    private function buildBaseOfferData(Request $request, ?int $offerLimit = null, array $extraData = []): array
    {
        $activeTemplate = getActiveTemplate();
        $user = Auth::user();
        $userUid = $user ? $user->uid : null;
        $device = detectDevicePlatform();
        $homeSlider = $this->getWithdrawAndCompletedOffers();
        $isVPNDetected = $this->vpnService->isVPN($request->ip());

        $data = array_merge([
            'activeTemplate' => $activeTemplate,
            'isVPNDetected' => $isVPNDetected,
            'device' => $device,
            'homeSlider' => $homeSlider['combinedData'],
            'allOffers' => [],
            'ogadsOffers' => [],
        ], $extraData);

        if (!$isVPNDetected) {
            $userCountry = getCountryCode($request->ip());
            $data['allOffers'] = $this->offerService->getOffers($userCountry, $userUid, $offerLimit);
            $data['ogadsOffers'] = $this->offerService->fetchOgadsOffers($request);
            
            // Add Monlix offers if API is configured
            if ($userUid && env('MONLIX_APP_ID')) {
                $monlixOffers = $this->monlixService->getOffers(
                    $userUid,
                    $request->ip(),
                    $request->header('User-Agent')
                );
                
                // Merge Monlix offers with ogadsOffers for display (handle Collection)
                if (is_array($data['ogadsOffers'])) {
                    $data['ogadsOffers'] = array_merge($data['ogadsOffers'], $monlixOffers);
                } else {
                    $data['ogadsOffers'] = collect($data['ogadsOffers'])->merge($monlixOffers)->all();
                }
            }
        }

        return $data;
    }



    // Method to get networks by type, use type hinting
    private function getNetworksByType(string $type, ?string $userUid): \Illuminate\Support\Collection
    {
        return Network::select('network_name', 'network_image', 'network_description', 'network_rating', 'offerwall_url', 'level_id')
            ->with('level:id,level')
            ->where('network_status', 1)
            ->where('network_type', $type)
            ->orderBy('network_order')
            ->get()
            ->map(function ($network) use ($userUid) {
                // Only replace UID if it's not null
                if ($userUid) {
                    $network->offerwall_url = $this->replaceUidInUrl($network->offerwall_url, $userUid);
                }
                return $network;
            });
    }

    // Replaces UID in URL, type-hinting return value
    private function replaceUidInUrl(string $url, ?string $userUid): string
    {
        return $userUid ? str_replace('[uid]', $userUid, $url) : $url;
    }

    private function getWithdrawAndCompletedOffers()
    {
        $withdrawals = WithdrawalHistory::with('category:id,name,bg_color')
            ->select('id', 'amount', 'withdrawal_categories_id', 'created_at')
            ->where('status', 'completed')
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->map(function ($withdrawal) {
                return [
                    'id' => 'withdrawal_' . $withdrawal->id,
                    'type' => 'withdrawal',
                    'amount' => $withdrawal->amount,
                    'category_name' => $withdrawal->category->name,
                    'bg_color' => $withdrawal->category->bg_color,
                ];
            });

        $completedOffers = Track::select('id', 'offer_name', 'reward', 'partners', 'created_at')
            ->where('status', 1)
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->map(function ($offer) {
                return [
                    'id' => 'offer_' . $offer->id,
                    'type' => 'offer',
                    'offer_name' => $offer->offer_name,
                    'reward' => $offer->reward,
                    'partners' => $offer->partners,
                    'bg_color' => 'linear-gradient(135deg, #0084BC 0%, #001C8B 100%)',
                ];
            });

        $combinedData = collect($withdrawals)->merge($completedOffers)->sortByDesc('created_at')->values();

        return compact('combinedData');
    }
}
