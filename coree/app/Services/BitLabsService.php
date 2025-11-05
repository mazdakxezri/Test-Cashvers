<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BitLabsService
{
    protected $apiToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiToken = env('BITLABS_API_TOKEN');
        $this->apiUrl = 'https://api.bitlabs.ai/v1';
    }

    /**
     * Get available surveys for user
     *
     * @param string $userId
     * @return array
     */
    public function getSurveys($userId): array
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Token' => $this->apiToken,
            ])->get($this->apiUrl . '/surveys', [
                'uid' => $userId,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['surveys'] ?? [];
            }

            Log::error('BitLabs: Failed to get surveys - ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('BitLabs: Exception getting surveys - ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get survey click URL
     *
     * @param string $userId
     * @param string $surveyId
     * @return string|null
     */
    public function getSurveyUrl($userId, $surveyId): ?string
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Token' => $this->apiToken,
            ])->get($this->apiUrl . '/surveys/click', [
                'uid' => $userId,
                'sid' => $surveyId,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['click_url'] ?? null;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('BitLabs: Exception getting survey URL - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify callback signature
     *
     * @param array $data
     * @param string $signature
     * @return bool
     */
    public function verifyCallback($data, $signature): bool
    {
        $secret = env('BITLABS_WEBHOOK_SECRET');
        
        $payload = json_encode($data);
        $calculatedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($calculatedSignature, $signature);
    }

    /**
     * Get user statistics
     *
     * @param string $userId
     * @return array
     */
    public function getUserStats($userId): array
    {
        try {
            $response = Http::withHeaders([
                'X-Api-Token' => $this->apiToken,
            ])->get($this->apiUrl . '/users/' . $userId);

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            Log::error('BitLabs: Exception getting user stats - ' . $e->getMessage());
            return [];
        }
    }
}

