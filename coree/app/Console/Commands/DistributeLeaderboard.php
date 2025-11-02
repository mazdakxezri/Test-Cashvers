<?php

namespace App\Console\Commands;



use Illuminate\Console\Command;
use App\Models\LeaderboardSettings;
use App\Services\LeaderboardService;
use Carbon\Carbon;

class DistributeLeaderboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:distribute-leaderboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute rewards to leaderboard users';

    protected $leaderboardService;

    public function __construct(LeaderboardService $leaderboardService)
    {
        parent::__construct();
        $this->leaderboardService = $leaderboardService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = LeaderboardSettings::first();

        if (!$settings || !$settings->status) {
            $this->info('Leaderboard settings are not active.');
            return;
        }

        $period = $this->leaderboardService->getPeriod($settings->duration);

        // Check if it's the right time to run
        if (!$this->shouldRun($settings->duration)) {
            $this->info('Leaderboard distribution is not scheduled for today.');
            return;
        }

        // Get active users with their total rewards from the track based on the period
        $users = $this->leaderboardService->getActiveUsersWithRewards($period, $settings->number_of_users);

        // Decode top ranks prizes from JSON
        $topRanksPrizes = json_decode($settings->top_ranks_prizes, true);

        // Distribute prizes
        $prizes = $this->leaderboardService->calculatePrizes(
            $users,
            $topRanksPrizes,
            $settings->total_prize,
            $settings->distribution_method
        );

        foreach ($users as $index => $user) {
            $rank = $index + 1;
            $prize = $prizes[$user->uid] ?? 0;

            // Distribute the prize to the user
            $this->leaderboardService->distributeReward($user, $prize, $rank);
        }

        $this->info('Rewards distributed successfully.');
    }


    private function shouldRun($duration)
    {
        $now = Carbon::now();

        switch ($duration) {
            case 'monthly':
                return $now->isLastOfMonth();
            case 'weekly':
                return $now->isToday() && $now->isWeekday();
            case 'daily':
                return true;
            default:
                return false;
        }
    }

}
