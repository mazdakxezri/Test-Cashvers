<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class VPNDetectionService
{
    protected $apiKey;
    protected $baseUri;

    public function __construct()
    {
        $this->apiKey = proxyCheckApiKey();
        $this->baseUri = 'https://proxycheck.io/v2/';
    }

    /**
     * Detect if the given IP is using a VPN or Proxy.
     *
     * @param string $ip
     * @return bool
     */
    public function isVPN(string $ip): bool
    {
        if (!isVpnDetectionEnabled()) {
            return false;
        }

        // Check if API key is available
        if (!is_null($this->apiKey)) {
            $query = [
                'key' => $this->apiKey,
                'vpn' => 3,
                'risk' => 1,
            ];

            $response = Http::get($this->baseUri . $ip, $query)->json()[$ip] ?? null;

            return $response && (
                ($response['vpn'] ?? 'no') === 'yes' ||
                ($response['proxy'] ?? 'no') === 'yes' ||
                ($response['risk'] ?? 0) > 33
            );
        }

        return false;
    }

}
