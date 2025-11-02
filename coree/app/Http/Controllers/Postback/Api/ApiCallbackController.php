<?php

namespace App\Http\Controllers\Postback\Api;

use App\Http\Controllers\Postback\PostbackController;
use Illuminate\Http\Request;
use App\Models\Setting;

class ApiCallbackController extends PostbackController
{
    public function index(Request $request, $network_name, $secret_key)
    {
        // Define allowed networks and their secret keys
        $networks = [
            'ogads' => 'qK8pR5vZ2yX9',
            'adgatemedia' => 'mN3&cW6zQ1lV8',
            'torox' => 'oIneMzO9v0hUmV',
            'hangmyads' => 'hM7xR2kP9nY5',
        ];

        if (empty($networks[$network_name]) || $networks[$network_name] !== $secret_key) {
            return response(
                empty($networks[$network_name]) ? 'Invalid network name.' : 'Invalid secret key for the network.',
                empty($networks[$network_name]) ? 400 : 403
            );
        }

        // Map network names to rate keys
        $rateKeys = [
            'ogads' => 'ogads_rate',
            'adgatemedia' => 'adgate_rate',
            'torox' => 'torox_rate',
            'hangmyads' => 'hangmyads_rate',
        ];

        $rateKey = $rateKeys[$network_name] ?? null;

        if (!$rateKey) {
            return response('Rate key not configured for this network.', 500);
        }

        $rate = Setting::getValue($rateKey);

        $payout = floatval($request->input('payout') ?? 0);
        $reward = $payout * $rate;

        return $this->processRequest($request, $network_name, null, $reward, true);
    }

}