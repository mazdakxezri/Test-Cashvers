<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaderboardSettings;
use App\Services\LeaderboardService;
use App\Models\Track;
use Carbon\Carbon;
use App\Services\HomeService;


class DashboardController extends Controller
{
    protected $homeService;
    protected $leaderboardService;

    public function __construct(HomeService $homeService, LeaderboardService $leaderboardService)
    {
        $this->homeService = $homeService;
        $this->leaderboardService = $leaderboardService;
    }

    //Home Controller
    public function index(Request $request)
    {
        $data = $this->homeService->getHomeData($request);

        return view($data['activeTemplate'] . '.home-clean', [
            'isVPNDetected' => $data['isVPNDetected'],
            'homeSlider' => $data['homeSlider'],
            'offer_networks' => $data['offer_networks'],
            'survey_networks' => $data['survey_networks'],
            'device' => $data['device'],
            'allOffers' => $data['allOffers'],
            'ogadsOffers' => $data['ogadsOffers'],
        ]);
    }

    public function getWithdrawAndCompletedOffers()
    {
        return response()->json([
            'combinedData' => $this->homeService->getHomeData(request())['homeSlider']
        ]);
    }


    //Leaderboard Controller

    public function leaderboard()
    {
        $activeTemplate = getActiveTemplate();

        $settings = LeaderboardSettings::first();

        if (!$settings || !$settings->status) {
            abort(403, 'Leaderboard is currently disabled.');
        }

        $topPrizes = json_decode($settings->top_ranks_prizes, true);
        $totalTopPrizes = array_sum($topPrizes);

        $totalPrizePool = $settings->total_prize;

        // Define the period based on the duration set in the leaderboard settings
        $duration = $settings->duration;
        $period = $this->leaderboardService->getPeriod($duration );
        $periodEnd = $this->leaderboardService->getPeriod($duration )[1];
        $timeLeft = sprintf("%d:%s", Carbon::now()->diffInDays($periodEnd), Carbon::now()->diff($periodEnd)->format('%H:%I:%S'));

        // Calculate today's earnings
        $earnedToday = Track::where('uid', Auth::user()->uid)
            ->whereDate('created_at', Carbon::today())
            ->where('status', 1)
            ->sum('reward');


        $users = $this->leaderboardService->getActiveUsersWithRewards($period, $settings->number_of_users);

        $distributionMethod = $settings->distribution_method;

        // Calculate potential prizes for each user
        $potentialPrizes = $this->leaderboardService->calculatePrizes($users, $topPrizes, $totalPrizePool, $distributionMethod);
        
        return view($activeTemplate . '.leaderboard', compact('users', 'potentialPrizes', 'earnedToday', 'totalPrizePool', 'timeLeft', 'duration'));
    }


    public function getAllOffers(Request $request)
    {

        $data = $this->homeService->getAllOffers($request);

        return view($data['activeTemplate'] . '.offers', [
            'isVPNDetected' => $data['isVPNDetected'],
            'allOffers' => $data['allOffers'],
            'ogadsOffers' => $data['ogadsOffers'],
        ]);

    }


}
