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
     * Transform Monlix campaigns to match ogads format with filtering
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

        $userDevice = detectDevicePlatform(); // Get current user's device
        $userCountry = request()->header('CF-IPCountry') ?? getCountryCode(request()->ip()); // Get user's country

        $filtered = array_filter($campaigns, function($campaign) use ($userDevice, $userCountry) {
            // Filter by device/OS
            $campaignOsRaw = $campaign['oss'] ?? 'all';
            // Handle if oss is an array (e.g., ["android", "ios"])
            $campaignOs = is_array($campaignOsRaw) ? ($campaignOsRaw[0] ?? 'all') : strtolower($campaignOsRaw);
            
            if ($campaignOs !== 'all') {
                // Map our device types to Monlix OS types
                $deviceMap = [
                    'mobile' => ['android', 'ios'],
                    'desktop' => ['all', 'desktop'],
                    'android' => ['android'],
                    'ios' => ['ios'],
                ];
                
                $allowedOs = $deviceMap[$userDevice] ?? ['all'];
                if (!in_array($campaignOs, $allowedOs) && $campaignOs !== 'all') {
                    return false;
                }
            }

            // Filter by country
            $campaignCountries = $campaign['countries'] ?? [];
            if (!empty($campaignCountries) && is_array($campaignCountries)) {
                // Check if user's country is in allowed countries
                if (!in_array($userCountry, $campaignCountries)) {
                    return false;
                }
            }

            return true;
        });

        return array_map(function($campaign) use ($userId) {
            // Replace {{userid}} placeholder in URL
            $url = str_replace('{{userid}}', $userId, $campaign['url'] ?? '');
            
            // Calculate display payout (highest goal payout or base payout)
            $displayPayout = $campaign['payout'] ?? 0;
            $events = [];
            
            if (!empty($campaign['goals']) && is_array($campaign['goals'])) {
                // Build events array for modal display
                foreach ($campaign['goals'] as $goal) {
                    $goalPayout = $goal['payout'] ?? 0;
                    if (is_array($goalPayout) && isset($goalPayout[0]['payout'])) {
                        $goalPayout = $goalPayout[0]['payout'];
                    }
                    $events[] = [
                        'name' => $goal['name'] ?? 'Goal',
                        'payout' => floatval($goalPayout),
                    ];
                }
                
                // Use highest payout for display
                $payouts = array_column($events, 'payout');
                $displayPayout = !empty($payouts) ? max($payouts) : $displayPayout;
            }

            // Transform to ogads-like format
            return [
                'offerid' => $campaign['id'] ?? 0,
                'name_short' => $campaign['name'] ?? 'Monlix Offer',
                'description' => $campaign['description'] ?? '',
                'adcopy' => $campaign['description'] ?? '',
                'picture' => $campaign['image'] ?? '',
                'payout' => floatval($displayPayout),
                'link' => $url,
                'countries' => $campaign['countries'] ?? [],
                'oss' => $campaign['oss'] ?? 'all',
                'device' => $this->mapOsToDevice($campaign['oss'] ?? 'all'),
                'categories' => $campaign['categories'] ?? [],
                'partner' => 'monlix',
                'event' => $events, // Include events for modal
            ];
        }, $filtered);
    }

    /**
     * Map Monlix OS to our device types
     */
    protected function mapOsToDevice($os): string
    {
        return match(strtolower($os)) {
            'android' => 'android',
            'ios' => 'ios',
            default => 'all',
        };
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

