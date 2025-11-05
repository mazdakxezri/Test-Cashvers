<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonlixService
{
    protected $apiKey;
    protected $publisherId;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('MONLIX_API_KEY');
        $this->publisherId = env('MONLIX_PUBLISHER_ID');
        $this->apiUrl = 'https://api.monlix.com/v1';
    }

    /**
     * Get available offers
     *
     * @param string $userId
     * @param array $filters
     * @return array
     */
    public function getOffers($userId, array $filters = []): array
    {
        try {
            $params = array_merge([
                'api_key' => $this->apiKey,
                'publisher_id' => $this->publisherId,
                'user_id' => $userId,
            ], $filters);

            $response = Http::get($this->apiUrl . '/offers', $params);

            if ($response->successful()) {
                $data = $response->json();
                return $data['offers'] ?? [];
            }

            Log::error('Monlix: Failed to get offers - ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('Monlix: Exception getting offers - ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get offer click URL
     *
     * @param string $userId
     * @param string $offerId
     * @return string|null
     */
    public function getOfferUrl($userId, $offerId): ?string
    {
        try {
            $params = [
                'api_key' => $this->apiKey,
                'publisher_id' => $this->publisherId,
                'user_id' => $userId,
                'offer_id' => $offerId,
            ];

            $response = Http::get($this->apiUrl . '/click', $params);

            if ($response->successful()) {
                $data = $response->json();
                return $data['click_url'] ?? null;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Monlix: Exception getting offer URL - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify postback signature
     *
     * @param array $data
     * @param string $signature
     * @return bool
     */
    public function verifyPostback($data, $signature): bool
    {
        $secret = env('MONLIX_SECRET_KEY');
        
        // Monlix uses specific params for signature
        $signatureString = $data['offer_id'] . ':' . $data['user_id'] . ':' . $data['payout'] . ':' . $secret;
        $calculatedSignature = hash('sha256', $signatureString);

        return hash_equals($calculatedSignature, $signature);
    }

    /**
     * Get publisher statistics
     *
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function getStatistics($startDate, $endDate): array
    {
        try {
            $response = Http::get($this->apiUrl . '/statistics', [
                'api_key' => $this->apiKey,
                'publisher_id' => $this->publisherId,
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Monlix: Exception getting statistics - ' . $e->getMessage());
            return [];
        }
    }
}

