<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\AchievementService;
use App\Models\UserAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    protected $achievementService;

    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    /**
     * Show achievements page
     */
    public function index()
    {
        $user = Auth::user();
        $activeTemplate = getActiveTemplate();
        
        $stats = $this->achievementService->getUserStats($user);
        $achievementsByCategory = $this->achievementService->getUserAchievementsByCategory($user);

        return view($activeTemplate . '.achievements.index', compact(
            'stats',
            'achievementsByCategory'
        ));
    }

    /**
     * Claim achievement reward
     */
    public function claim(Request $request)
    {
        $request->validate([
            'user_achievement_id' => 'required|exists:user_achievements,id',
        ]);

        $userAchievement = UserAchievement::with('achievement')
            ->where('id', $request->user_achievement_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($this->achievementService->claimReward($userAchievement)) {
            return back()->with('success', 'Achievement reward claimed! +$' . number_format($userAchievement->achievement->reward_amount, 2));
        }

        return back()->with('error', 'Failed to claim reward or already claimed');
    }
}

