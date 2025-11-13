<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonlixService
{
    protected $appId;
    protected $apiUrl;

    public function __construct()
    {
        $this->appId = env('MONLIX_APP_ID');
        $this->apiUrl = 'https://api.monlix.com/api';
    }

    /**
     * Get available offers from Monlix API
     *
     * @param string $userId
     * @param string|null $userIp
     * @param string|null $userAgent
     * @return array
     */
    public function getOffers($userId, $userIp = null, $userAgent = null): array
    {
        if (!$this->appId) {
            return [];
        }

        try {
            // Build params based on Monlix API docs
            $params = [
                'appid' => $this->appId,
                'userid' => $userId,
            ];

            // Add server-side params if provided
            if ($userIp) {
                $params['userip'] = $userIp;
            }
            if ($userAgent) {
                $params['ua'] = $userAgent;
            }

            $response = Http::timeout(10)->get($this->apiUrl . '/campaigns', $params);

            if ($response->successful()) {
                $campaigns = $response->json();
                
                // Transform Monlix format to match ogadsOffers format
                return $this->transformMonlixOffers($campaigns, $userId);
            }

            Log::error('Monlix API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return [];
            
        } catch (\Exception $e) {
            Log::error('Monlix Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }

    /**
     * Transform Monlix campaigns to match ogads format
     *
     * @param array $campaigns
     * @param string $userId
     * @return array
     */
    protected function transformMonlixOffers($campaigns, $userId): array
    {
        if (!is_array($campaigns) || empty($campaigns)) {
            return [];
        }

        return array_map(function($campaign) use ($userId) {
            // Replace {{userid}} placeholder in URL
            $url = str_replace('{{userid}}', $userId, $campaign['url'] ?? '');
            
            // Calculate display payout (highest goal payout or base payout)
            $displayPayout = $campaign['payout'] ?? 0;
            if (!empty($campaign['goals']) && is_array($campaign['goals'])) {
                $maxGoalPayout = max(array_column($campaign['goals'], 'payout'));
                $displayPayout = max($displayPayout, $maxGoalPayout);
            }

            // Transform to ogads-like format
            return [
                'offerid' => $campaign['id'] ?? 0,
                'name_short' => $campaign['name'] ?? 'Monlix Offer',
                'description' => $campaign['description'] ?? '',
                'adcopy' => $campaign['description'] ?? '',
                'picture' => $campaign['image'] ?? '',
                'payout' => $displayPayout,
                'link' => $url,
                'countries' => $campaign['countries'] ?? [],
                'oss' => $campaign['oss'] ?? 'all',
                'categories' => $campaign['categories'] ?? [],
                'partner' => 'monlix', // Identify as Monlix offer
            ];
        }, $campaigns);
    }

    /**
     * Get offer click URL (already included in campaigns response)
     * This method kept for backward compatibility
     *
     * @param string $userId
     * @param string $offerId
     * @return string|null
     */
    public function getOfferUrl($userId, $offerId): ?string
    {
        // URL is already in the campaigns response
        // Format: https://api.monlix.com/api/cmp/redirect/{appid}/{campaignId}/{userid}
        return $this->apiUrl . '/cmp/redirect/' . $this->appId . '/' . $offerId . '/' . $userId;
    }

    /**
     * Verify postback signature
     * Monlix uses SHA256 hash for security
     *
     * @param array $data
     * @param string $signature
     * @return bool
     */
    public function verifyPostback($data, $signature): bool
    {
        $secret = env('MONLIX_SECRET_KEY');
        
        if (!$secret) {
            Log::warning('Monlix: SECRET_KEY not configured');
            return false;
        }
        
        // Build signature string from postback data
        // Format: campaignId:userId:payout:secret
        $signatureString = ($data['campaign_id'] ?? $data['offer_id'] ?? '') . ':' 
                         . ($data['user_id'] ?? '') . ':' 
                         . ($data['payout'] ?? '') . ':' 
                         . $secret;
        
        $calculatedSignature = hash('sha256', $signatureString);

        return hash_equals($calculatedSignature, $signature);
    }
}

