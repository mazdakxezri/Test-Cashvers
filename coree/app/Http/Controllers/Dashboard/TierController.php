<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\LevelService;
use Illuminate\Support\Facades\Auth;

class TierController extends Controller
{
    /**
     * Display tier system details page
     */
    public function index()
    {
        $user = Auth::user();
        $currentTier = LevelService::getTierForLevel($user->level);
        $progress = LevelService::getProgressToNextLevel($user);
        $allTiers = LevelService::TIERS;
        
        return view(getActiveTemplate() . '.tiers', compact('currentTier', 'progress', 'allTiers'));
    }
}

