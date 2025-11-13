<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Setting;
use App\Models\Offer;
use App\Models\Track;

class OfferService
{
    protected $partners = ['ogads', 'adgatemedia', 'torox', 'hangmyads'];

    protected $settings;

    public function getOffers($userCountry, ?string $userUid, $numoffers = null)
    {
        $notEnabledPartners = array_filter($this->partners, fn($partner) => !$this->isPartnerEnabled($partner));
        $user = Auth::user();
        $completedOfferIds = $user ? $this->getCompletedOfferIds($user) : [];
        $deviceType = detectDevicePlatform();

        $offersQuery = Offer::whereRaw('FIND_IN_SET(?, countries)', [$userCountry])
            ->when($deviceType, function ($q) use ($deviceType) {
                $q->where(function ($query) use ($deviceType) {
                    $query->where('device', $deviceType)
                          ->orWhere('device', 'all');
                });
            })
            ->where('status', 1)
            ->orderByDesc('payout');


        // If $numoffers is set (e.g., homepage), just return limited offers
        if ($numoffers) {
            $offers = $offersQuery->limit($numoffers)->get();
            if ($userUid) {
                $offers = $this->filterAndTransform($offers, $userUid, $completedOfferIds);
            }
            return $this->transformOffers($offers, $completedOfferIds);
        }

        // Use pagination
        $perPage = (int) request()->query('limit', 30);
        $page = LengthAwarePaginator::resolveCurrentPage();
        $total = $offersQuery->count();

        $offers = $offersQuery->forPage($page, $perPage)->get();

        if ($userUid) {
            $offers = $this->filterAndTransform($offers, $userUid, $completedOfferIds);
        }

        $offers = $this->transformOffers($offers, $completedOfferIds);

        // Wrap in paginator
        return new LengthAwarePaginator(
            $offers,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }

    private function filterAndTransform($offers, $userUid, $completedOfferIds)
    {
        $offers = $offers->transform(function ($offer) use ($userUid) {
            if ($offer->link) {
                $offer->link = $this->replaceUidInUrl($offer->link, $userUid);
            }
            return $offer;
        });

        $completedOffersLookup = Track::where('uid', $userUid)
            ->select('offer_id', 'partners')
            ->get()
            ->keyBy(fn($completed) => "{$completed->partners}-{$completed->offer_id}");

        return $offers->filter(function ($offer) use ($completedOffersLookup) {
            return !$completedOffersLookup->has("{$offer->partner}-{$offer->offer_id}");
        });
    }

    protected function isPartnerEnabled($partner)
    {
        return match ($partner) {
            'adgatemedia' => isAdgateApiEnabled(),
            'torox' => isToroxApiEnabled(),
            'hangmyads' => isHangmyadsApiEnabled(),
            default => false,
        };
    }


    protected function transformOffers($offers, $completedOfferIds)
    {
        return $offers->reject(fn($offer) => in_array($offer->id, $completedOfferIds))
            ->map(function ($offer) {
                $events = is_string($offer->event) ? json_decode($offer->event, true) : $offer->event;
                $events = is_array($events) ? $events : [];
                $offer->event = array_map(fn($event) => [
                    'name' => $event['name'] ?? null,
                    'payout' => $event['payout'] ?? null,
                ], $events);
                return $offer;
            })->values();
    }


    public function fetchOgadsOffers(Request $request)
    {

        if (isOgadsApiEnabled()) {
            $user = Auth::user();
            $completedOfferIds = [];

            // Only fetch completed offers if user is authenticated
            if ($user) {
                $completedOfferIds = $this->getCompletedOfferIds($user);
            }

            $settings = Setting::whereIn('name', ['ogads_api_key', 'ogads_rate'])->pluck('value', 'name');
            $apiKey = $settings['ogads_api_key'] ?? null;
            $ogRate = $settings['ogads_rate'] ?? 1;

            if (!$apiKey) {
                throw new \Exception('Ogads API key not found in settings.');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->get('https://unlockcontent.net/api/v2', [
                        'ip' => $request->ip(),
                        'user_agent' => $request->header('User-Agent'),
                        'ctype' => 3,
                    ]);

            if ($response->failed()) {
                throw new \Exception('Failed to fetch Ogads offers: ' . $response->status());
            }

            $offers = $response->json('offers', []);

            // Filter out OfferToro and other unwanted offers
            return collect($offers)
                ->filter(function($offer) use ($user, $completedOfferIds) {
                    // Get all fields to check (convert to string to be safe)
                    $picture = strtolower((string)($offer['picture'] ?? ''));
                    $link = strtolower((string)($offer['link'] ?? ''));
                    $name = strtolower((string)($offer['name_short'] ?? $offer['name'] ?? ''));
                    
                    // Blocked domains/keywords - comprehensive list
                    $blockedKeywords = [
                        'offertoro', 
                        'hungeroffer', 
                        'notik.me',
                        'notik',
                        'static.offertoro',
                    ];
                    
                    foreach ($blockedKeywords as $keyword) {
                        if (str_contains($picture, $keyword) || 
                            str_contains($link, $keyword) ||
                            str_contains($name, $keyword)) {
                            return false;
                        }
                    }
                    
                    // Filter out completed offers
                    if ($user && in_array($offer['offerid'], $completedOfferIds)) {
                        return false;
                    }
                    
                    return true;
                })
                ->map(fn($offer) => ['payout' => $offer['payout'] * $ogRate] + $offer)
                ->values();
        }

        return collect([]);
    }



    protected function getCompletedOfferIds($user)
    {
        return Track::where('uid', $user->uid)
            ->whereIn('partners', $this->partners)
            ->pluck('offer_id')
            ->toArray();
    }

    private function replaceUidInUrl(string $url, ?string $userUid): string
    {
        return $userUid ? str_replace('[uid]', $userUid, $url) : $url;
    }


}
