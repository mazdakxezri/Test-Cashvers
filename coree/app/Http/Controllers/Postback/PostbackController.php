<?php

namespace App\Http\Controllers\Postback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Track;
use App\Models\ReferralLog;
use App\Models\Offer;
use App\Models\Network;

abstract class PostbackController extends Controller
{
    protected function processRequest(Request $request, $networkName, $paramSecret = null, $customReward = null ,$isApi = false)
    {

        if ($paramSecret && $paramSecret !== "Yk9@7v@Dw5vJ") {
            return response('Not allowed', 200);
        }

        // Retrieve payout and other parameters
        $payout = floatval($request->input('payout') ?? 0);
        $offerName = $request->input('of_name') ?? $request->input('offer_name') ?? 'N/A';
        $offerId = $request->input('of_id') ?? 0;
        $uid = $request->input('uid') ?? $request->input('subId') ?? $request->input('user_id');
        $ip = $request->input('ip') ?? $request->input('userIp') ?? '0.0.0.0';
        $country = $request->input('country');
        $transactionId = $request->input('tx_id') ?? $request->input('transId') ?? $request->input('token') ?? 'N/A';

        // Get network details
        $network = Network::where('network_name', $networkName)->first();

        // Calculate reward amount based on network configuration
        $reward = $this->calculateReward($network, $payout, $customReward, $request, $offerId, $networkName);

        $status = $this->determineStatus($request->input('status'), $payout, $reward);

        // Find the user by UID
        $user = User::where('uid', $uid)->firstOrFail();

        // Check if transaction already exists
        if (
            $transactionId !== 'N/A' &&
            Track::where([
                ['partners', $networkName],
                ['transaction_id', $transactionId],
                ['uid', $uid],
                ['status', $status]
            ])->exists()
        ) {
            return response('Transaction ID already exists for this user', 400);
        }

        // Check if user has required level for this network
        if (!$isApi && $network->level_id && $user->level < $network->level->level) {
            return response("User doesn't have the required level", 400);
        }

        // Process referral logic
        $this->processReferral($user, $reward);

        // Update user balance based on status
        if ($status == 1) {
            $user->increment('balance', $reward);
            $user->refresh();
            $user->upgradeLevel();
        } elseif ($status == 2) {
            $user->decrement('balance', $reward);
        }

        // Determine country code if not provided
        $country = $country ?? ($ip !== '0.0.0.0' ? getCountryCode($ip) : 'N/A');

        // Create tracking record
        Track::create([
            'offer_id' => $offerId,
            'offer_name' => $offerName,
            'transaction_id' => $transactionId,
            'reward' => abs($reward),
            'payout' => abs($payout),
            'ip' => $ip,
            'country' => $country,
            'status' => $status,
            'uid' => $uid,
            'partners' => $networkName,
        ]);

        return response('OK', 200);
    }

    protected function determineStatus($status, $payout, $reward)
    {
        $approvedValues = [1, 'approved', 'completed', 'COMPLETE', 'COMPLETED', 'credited'];
        $rejectedValues = [2, 0, 'rejected', 'RECONCILIATION'];

        if ($status === null || $status === '') {
            return ($payout < 0 || $reward < 0) ? 2 : 1;
        }

        return in_array($status, $approvedValues, true) ? 1 :
            (in_array($status, $rejectedValues, true) ? 2 : 1);
    }


    protected function processReferral($user, $reward)
    {
        $perc = ReferralCommission();
        $bonusAmount = $reward * ($perc / 100);
        if ($user->invited_by && $perc > 0 && $perc <= 100) {
            $invitedByUser = User::find($user->invited_by);
            $invitedByUser->increment('balance', $bonusAmount);
            ReferralLog::create([
                'referrer_id' => $user->invited_by,
                'user_id' => $user->id,
                'earnings' => $bonusAmount,
            ]);
        }
    }

    protected function calculateReward($network, $payout, $customReward, Request $request, $offerId, $networkName)
    {
        if ($network && is_null($network->param_amount)) {
            return abs($payout * $network->param_custom_rate);
        }

        return abs($customReward ?? floatval(
            $request->input('reward')
            ?? $request->input('value')
            ?? Offer::where('offer_id', $offerId)
                ->where('partner', $networkName)
                ->value('payout')
            ?? 0
        ));
    }
}