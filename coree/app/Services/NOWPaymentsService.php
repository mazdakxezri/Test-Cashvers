<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NOWPaymentsService
{
    protected $apiKey;
    protected $apiUrl;
    protected $ipnSecret;

    public function __construct()
    {
        $this->apiKey = env('NOWPAYMENTS_API_KEY');
        $this->apiUrl = 'https://api.nowpayments.io/v1';
        $this->ipnSecret = env('NOWPAYMENTS_IPN_SECRET');
    }

    /**
     * Get available currencies
     */
    public function getAvailableCurrencies()
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get($this->apiUrl . '/currencies');

            if ($response->successful()) {
                return $response->json()['currencies'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            Log::error('NOWPayments: Failed to get currencies - ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get minimum payment amount for a currency
     */
    public function getMinimumAmount($currency)
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get($this->apiUrl . '/min-amount', [
                'currency_from' => $currency,
                'currency_to' => $currency,
            ]);

            if ($response->successful()) {
                return $response->json()['min_amount'] ?? 0;
            }

            return 0;
        } catch (\Exception $e) {
            Log::error('NOWPayments: Failed to get minimum amount - ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Create payment
     *
     * @param float $amount Payment amount in USD
     * @param string $currency Crypto currency (BTC, ETH, USDT, etc)
     * @param int $userId User ID
     * @param string $type 'deposit' or 'withdrawal'
     * @return array|null
     */
    public function createPayment($amount, $currency, $userId, $type = 'deposit')
    {
        try {
            $payload = [
                'price_amount' => $amount,
                'price_currency' => 'usd',
                'pay_currency' => strtolower($currency),
                'ipn_callback_url' => route('nowpayments.callback'),
                'order_id' => $userId . '_' . time() . '_' . $type,
                'order_description' => 'CashVers ' . ucfirst($type),
            ];

            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/payment', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('NOWPayments: Payment creation failed - ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('NOWPayments: Payment creation exception - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get payment status
     *
     * @param string $paymentId
     * @return array|null
     */
    public function getPaymentStatus($paymentId)
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get($this->apiUrl . '/payment/' . $paymentId);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('NOWPayments: Failed to get payment status - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify IPN callback signature
     *
     * @param array $data
     * @param string $signature
     * @return bool
     */
    public function verifyIPNSignature($data, $signature)
    {
        $sortedData = $data;
        ksort($sortedData);
        $jsonData = json_encode($sortedData, JSON_UNESCAPED_SLASHES);
        $calculatedSignature = hash_hmac('sha512', $jsonData, $this->ipnSecret);

        return hash_equals($calculatedSignature, $signature);
    }

    /**
     * Create payout (withdrawal)
     *
     * @param string $address Crypto wallet address
     * @param float $amount Amount in crypto
     * @param string $currency Crypto currency
     * @return array|null
     */
    public function createPayout($address, $amount, $currency)
    {
        try {
            $payload = [
                'withdrawals' => [
                    [
                        'address' => $address,
                        'currency' => strtolower($currency),
                        'amount' => $amount,
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl . '/payout', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('NOWPayments: Payout creation failed - ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('NOWPayments: Payout creation exception - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Estimate price in crypto for USD amount
     *
     * @param float $usdAmount
     * @param string $currency
     * @return float|null
     */
    public function estimatePrice($usdAmount, $currency)
    {
        try {
            $response = Http::withHeaders([
                'x-api-key' => $this->apiKey,
            ])->get($this->apiUrl . '/estimate', [
                'amount' => $usdAmount,
                'currency_from' => 'usd',
                'currency_to' => strtolower($currency),
            ]);

            if ($response->successful()) {
                return $response->json()['estimated_amount'] ?? null;
            }

            return null;
        } catch (\Exception $e) {
            Log::error('NOWPayments: Price estimation failed - ' . $e->getMessage());
            return null;
        }
    }
}

