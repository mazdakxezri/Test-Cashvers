<?php

namespace App\Services;

use App\Models\User;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class LeaderboardService
{
    public function getActiveUsersWithRewards($period, $limit)
    {
        // Subquery to get total rewards per user
        $totalRewards = Track::select(
            'uid',
            DB::raw('SUM(reward) as total_reward')
        )
            ->where('status', 1)
            ->whereBetween('created_at', $period)
            ->groupBy('uid');

        // Main query to join users with the total rewards
        return User::where('users.status', 'active')
            ->leftJoinSub($totalRewards, 'total_rewards', function ($join) {
                $join->on('users.uid', '=', 'total_rewards.uid');
            })
            ->select(
                'users.id',
                'users.uid',
                'users.name',
                'users.avatar',
                'users.ip',
                'users.country_code',
                'total_rewards.total_reward'
            )
            ->orderBy('total_rewards.total_reward', 'desc')
            ->take($limit)
            ->get();
    }

    public function getPeriod($duration)
    {
        switch ($duration) {
            case 'daily':
                return [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()];
            case 'weekly':
                return [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
            case 'monthly':
                return [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
            default:
                return [null, null];
        }
    }

    public function calculatePrizes($users, $topPrizes, $totalPrizePool, $distributionMethod)
    {
        $potentialPrizes = [];
        $topRankCount = count($topPrizes);
        $totalTopPrizes = array_sum($topPrizes);
        $remainingPrizePool = max(0, $totalPrizePool - $totalTopPrizes);

        // Allocate top prizes
        foreach ($users as $index => $user) {
            $potentialPrizes[$user->uid] = $index < $topRankCount ? $topPrizes[$index] : 0;
        }

        // Distribute the remaining prize pool to non-top-rank users
        $nonTopRankUsers = $users->slice($topRankCount);
        if ($remainingPrizePool > 0 && $nonTopRankUsers->count() > 0) {
            switch ($distributionMethod) {
                case 'linear':
                    $this->distributeLinear($nonTopRankUsers, $potentialPrizes, $remainingPrizePool);
                    break;

                case 'exponential':
                    $this->distributeExponential($nonTopRankUsers, $potentialPrizes, $remainingPrizePool);
                    break;

                default:
                    $this->distributeLinear($nonTopRankUsers, $potentialPrizes, $remainingPrizePool);
                    break;
            }
        }

        return $potentialPrizes;
    }


    // Method for linear distribution
    private function distributeLinear($nonTopRankUsers, &$potentialPrizes, $remainingPrizePool)
    {
        if ($remainingPrizePool > 0 && count($nonTopRankUsers) > 0) {
            $equalShare = $remainingPrizePool / count($nonTopRankUsers);

            foreach ($nonTopRankUsers as $user) {
                $potentialPrizes[$user->uid] += $equalShare;
            }
        }
    }

    // Method for exponential distribution
    private function distributeExponential($nonTopRankUsers, &$potentialPrizes, $remainingPrizePool)
    {
        if ($remainingPrizePool > 0) {
            $userCount = count($nonTopRankUsers);

            // Calculate total weight (sum of all relative weights)
            $totalWeight = 0;
            $weights = [];

            // Calculate relative weights for each user
            foreach ($nonTopRankUsers as $index => $user) {
                $weight = max(0, 1 - ($index * 0.2));
                $weights[$user->uid] = $weight;
                $totalWeight += $weight;
            }

            // Distribute the remainingPrizePool based on the weights
            foreach ($nonTopRankUsers as $user) {
                $weightPercentage = $weights[$user->uid] / $totalWeight;
                $potentialPrizes[$user->uid] += $remainingPrizePool * $weightPercentage;
            }
        }
    }


    public function distributeReward($user, $amount, $rank)
    {
        $user->increment('balance', $amount);

        Track::create([
            'uid' => $user->uid,
            'reward' => $amount,
            'status' => 4,
            'offer_name' => "Leaderboard Rank N:{$rank}",
            'payout' => 0,
            'ip' => $user->ip,
            'country' => $user->country_code,
            'partners' => 'Leaderboard',
            'transaction_id' => 'LTX_' . time() . '_' . rand(1000, 9999),
        ]);
    }


}
