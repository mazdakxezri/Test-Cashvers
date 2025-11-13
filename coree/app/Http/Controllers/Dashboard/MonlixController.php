<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\MonlixService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MonlixController extends Controller
{
    protected $monlixService;

    public function __construct(MonlixService $monlixService)
    {
        $this->monlixService = $monlixService;
    }

    /**
     * Show Monlix offers page
     */
    public function index(Request $request)
    {
        $userId = Auth::user()->uid;
        $offers = $this->monlixService->getOffers(
            $userId,
            $request->ip(),
            $request->header('User-Agent')
        );

        return view('templates.garnet.monlix.index', compact('offers'));
    }

    /**
     * Get offer click URL and redirect
     */
    public function clickOffer(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|string',
        ]);

        $userId = Auth::user()->uid;
        $offerUrl = $this->monlixService->getOfferUrl($userId, $request->offer_id);

        if ($offerUrl) {
            return redirect($offerUrl);
        }

        return back()->with('error', 'Failed to get offer URL. Please try again.');
    }

    /**
     * Handle Monlix postback/callback
     */
    public function callback(Request $request)
    {
        // Verify signature
        $signature = $request->input('signature') ?? $request->header('X-Monlix-Signature');
        
        if (!$this->monlixService->verifyPostback($request->all(), $signature)) {
            Log::error('Monlix: Invalid postback signature');
            return response('Invalid signature', 403);
        }

        $data = $request->all();
        
        // Find user by UID
        $user = \App\Models\User::where('uid', $data['user_id'] ?? null)->first();

        if (!$user) {
            Log::error('Monlix: User not found for UID: ' . ($data['user_id'] ?? 'N/A'));
            return response('User not found', 404);
        }

        // Calculate reward based on payout
        $payout = floatval($data['payout'] ?? 0);
        
        // Get Monlix rate from settings (default 75% to user)
        $monlixRate = \App\Models\Setting::where('name', 'monlix_rate')->value('value') ?? 0.75;
        $reward = $payout * $monlixRate;

        // Credit user account
        $user->increment('balance', $reward);

        // Log the completion
        Log::info('Monlix: Offer completed', [
            'user_uid' => $user->uid,
            'campaign_id' => $data['campaign_id'] ?? $data['offer_id'] ?? 'N/A',
            'payout' => $payout,
            'user_reward' => $reward
        ]);

        // Create track record
        \App\Models\Track::create([
            'uid' => $user->uid,
            'offer_id' => $data['campaign_id'] ?? $data['offer_id'] ?? 'monlix_offer',
            'offer_name' => $data['campaign_name'] ?? $data['offer_name'] ?? 'Monlix Offer',
            'amount' => $payout,
            'reward' => $reward,
            'status' => 1, // Completed
            'partners' => 'monlix',
            'ip_address' => $request->ip(),
        ]);

        return response('OK', 200);
    }
}

