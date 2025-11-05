<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\DailyLoginBonusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyBonusController extends Controller
{
    protected $bonusService;

    public function __construct(DailyLoginBonusService $bonusService)
    {
        $this->bonusService = $bonusService;
    }

    /**
     * Claim daily login bonus
     */
    public function claim(Request $request)
    {
        $user = Auth::user();

        if (!$this->bonusService->canClaimToday($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Bonus already claimed today',
            ], 400);
        }

        $result = $this->bonusService->checkAndAwardBonus($user);

        if ($result['awarded']) {
            return response()->json([
                'success' => true,
                'amount' => $result['amount'],
                'streak' => $result['current_streak'],
                'message' => 'Daily bonus claimed successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 400);
    }

    /**
     * Get user's login calendar
     */
    public function calendar(Request $request)
    {
        $user = Auth::user();
        $days = $request->input('days', 30);
        
        $calendar = $this->bonusService->getLoginHistory($user, $days);

        return response()->json([
            'success' => true,
            'calendar' => $calendar,
            'streak' => $this->bonusService->getCurrentStreak($user),
            'total_earned' => $this->bonusService->getTotalBonuses($user),
        ]);
    }
}

