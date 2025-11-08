<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\BitLabsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BitLabsController extends Controller
{
    protected $bitLabsService;

    public function __construct(BitLabsService $bitLabsService)
    {
        $this->bitLabsService = $bitLabsService;
    }

    /**
     * Show BitLabs surveys page
     */
    public function index()
    {
        $activeTemplate = getActiveTemplate();
        
        // Use client-side fetching with custom card UI
        return view($activeTemplate . '.bitlabs.cards');
    }

    /**
     * Get survey click URL and redirect
     */
    public function clickSurvey(Request $request)
    {
        $request->validate([
            'survey_id' => 'required|string',
        ]);

        $userId = Auth::user()->uid;
        $surveyUrl = $this->bitLabsService->getSurveyUrl($userId, $request->survey_id);

        if ($surveyUrl) {
            return redirect($surveyUrl);
        }

        return back()->with('error', 'Failed to get survey URL. Please try again.');
    }

    /**
     * Handle BitLabs callback/webhook
     */
    public function callback(Request $request)
    {
        // Verify signature
        $signature = $request->header('X-Bitlabs-Signature');
        
        if (!$this->bitLabsService->verifyCallback($request->all(), $signature)) {
            Log::error('BitLabs: Invalid callback signature');
            return response('Invalid signature', 403);
        }

        $data = $request->all();
        
        // Find user by UID
        $user = \App\Models\User::where('uid', $data['uid'] ?? null)->first();

        if (!$user) {
            Log::error('BitLabs: User not found for UID: ' . ($data['uid'] ?? 'N/A'));
            return response('User not found', 404);
        }

        // Calculate reward (apply your commission/rate)
        $reward = $data['payout'] ?? 0;
        $reward = $reward * 0.80; // 80% to user, 20% platform commission

        // Credit user account
        $user->increment('balance', $reward);

        // Log the completion
        Log::info('BitLabs: Survey completed for user ' . $user->uid . ' - $' . $reward);

        // Create track record (optional - for history)
        \App\Models\Track::create([
            'uid' => $user->uid,
            'offer_id' => $data['survey_id'] ?? 'bitlabs_survey',
            'offer_name' => 'BitLabs Survey',
            'amount' => $reward,
            'status' => 'completed',
            'network_name' => 'BitLabs',
            'ip_address' => $request->ip(),
        ]);

        return response('OK', 200);
    }
}

