<?php

namespace App\Services;

use App\Models\User;
use App\Models\Achievement;
use App\Models\UserAchievement;
use App\Models\Track;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AchievementService
{
    /**
     * Check and update user's achievement progress
     */
    public function checkAchievements(User $user, string $triggerType, int $incrementBy = 1): array
    {
        $unlockedAchievements = [];

        // Get all active achievements that match this trigger type
        $achievements = Achievement::active()
            ->whereJsonContains('requirements->type', $triggerType)
            ->get();

        foreach ($achievements as $achievement) {
            $userAchievement = UserAchievement::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'achievement_id' => $achievement->id,
                ],
                [
                    'progress' => 0,
                    'is_unlocked' => false,
                ]
            );

            // Skip if already unlocked
            if ($userAchievement->is_unlocked) {
                continue;
            }

            // Update progress
            $userAchievement->progress += $incrementBy;

            // Check if requirement is met
            $required = $achievement->requirements['count'] ?? 1;
            if ($userAchievement->progress >= $required) {
                $userAchievement->is_unlocked = true;
                $userAchievement->unlocked_at = now();
                $unlockedAchievements[] = $achievement;

                Log::info("Achievement unlocked: {$achievement->name} for user {$user->id}");
            }

            $userAchievement->save();
        }

        return $unlockedAchievements;
    }

    /**
     * Claim achievement reward
     */
    public function claimReward(UserAchievement $userAchievement): bool
    {
        if (!$userAchievement->is_unlocked || $userAchievement->is_claimed) {
            return false;
        }

        DB::beginTransaction();
        try {
            $achievement = $userAchievement->achievement;
            $user = $userAchievement->user;

            // Add reward to user balance
            if ($achievement->reward_amount > 0) {
                $user->increment('total', $achievement->reward_amount);

                // Create track record
                Track::create([
                    'uid' => $user->uid,
                    'offer_id' => 'achievement_' . $achievement->id,
                    'offer_name' => 'Achievement: ' . $achievement->name,
                    'amount' => $achievement->reward_amount,
                    'payout' => $achievement->reward_amount,
                    'reward' => $achievement->reward_amount,
                    'status' => 1,
                    'partners' => 'system',
                    'network_name' => 'Achievements',
                    'ip' => request()->ip(),
                    'country' => $user->country_code ?? 'Unknown',
                ]);
            }

            // Add achievement points
            $user->increment('achievement_points', $achievement->points);

            // Mark as claimed
            $userAchievement->is_claimed = true;
            $userAchievement->claimed_at = now();
            $userAchievement->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to claim achievement reward: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user's achievement statistics
     */
    public function getUserStats(User $user): array
    {
        $totalAchievements = Achievement::active()->count();
        $userAchievements = UserAchievement::where('user_id', $user->id)->get();
        
        $unlockedCount = $userAchievements->where('is_unlocked', true)->count();
        $totalPoints = $userAchievements->sum(fn($ua) => $ua->is_claimed ? $ua->achievement->points : 0);
        $claimedRewards = $userAchievements->where('is_claimed', true)->sum(fn($ua) => $ua->achievement->reward_amount);

        return [
            'total' => $totalAchievements,
            'unlocked' => $unlockedCount,
            'locked' => $totalAchievements - $unlockedCount,
            'completion_percentage' => $totalAchievements > 0 ? round(($unlockedCount / $totalAchievements) * 100) : 0,
            'total_points' => $totalPoints,
            'claimed_rewards' => $claimedRewards,
        ];
    }

    /**
     * Get user's achievements grouped by category
     */
    public function getUserAchievementsByCategory(User $user): array
    {
        $achievements = Achievement::active()->with(['users' => function ($query) use ($user) {
            $query->where('users.id', $user->id);
        }])->orderBy('category')->orderBy('order')->get();

        $grouped = $achievements->groupBy('category');
        
        return $grouped->map(function ($items) use ($user) {
            return $items->map(function ($achievement) use ($user) {
                $userAchievement = UserAchievement::where('user_id', $user->id)
                    ->where('achievement_id', $achievement->id)
                    ->first();

                return [
                    'achievement' => $achievement,
                    'user_data' => $userAchievement,
                    'progress_percentage' => $userAchievement ? $userAchievement->progress_percentage : 0,
                ];
            });
        })->toArray();
    }

    /**
     * Seed default achievements
     */
    public function seedDefaultAchievements(): void
    {
        $achievements = [
            // Earning Achievements
            ['key' => 'first_offer', 'name' => 'First Steps', 'description' => 'Complete your first offer', 'icon' => '🎯', 'category' => 'earning', 'tier' => 'bronze', 'points' => 10, 'reward_amount' => 0.10, 'requirements' => ['type' => 'offers_completed', 'count' => 1]],
            ['key' => 'offers_10', 'name' => 'Getting Started', 'description' => 'Complete 10 offers', 'icon' => '🚀', 'category' => 'earning', 'tier' => 'bronze', 'points' => 25, 'reward_amount' => 0.25, 'requirements' => ['type' => 'offers_completed', 'count' => 10]],
            ['key' => 'offers_50', 'name' => 'Dedicated Earner', 'description' => 'Complete 50 offers', 'icon' => '💪', 'category' => 'earning', 'tier' => 'silver', 'points' => 50, 'reward_amount' => 0.50, 'requirements' => ['type' => 'offers_completed', 'count' => 50]],
            ['key' => 'offers_100', 'name' => 'Centurion', 'description' => 'Complete 100 offers', 'icon' => '🏆', 'category' => 'earning', 'tier' => 'gold', 'points' => 100, 'reward_amount' => 1.00, 'requirements' => ['type' => 'offers_completed', 'count' => 100]],
            ['key' => 'offers_500', 'name' => 'Offer Master', 'description' => 'Complete 500 offers', 'icon' => '👑', 'category' => 'earning', 'tier' => 'platinum', 'points' => 250, 'reward_amount' => 2.50, 'requirements' => ['type' => 'offers_completed', 'count' => 500]],
            ['key' => 'offers_1000', 'name' => 'Legend', 'description' => 'Complete 1000 offers', 'icon' => '⭐', 'category' => 'earning', 'tier' => 'diamond', 'points' => 500, 'reward_amount' => 5.00, 'requirements' => ['type' => 'offers_completed', 'count' => 1000]],

            // Earning Milestones
            ['key' => 'earned_1', 'name' => 'First Dollar', 'description' => 'Earn your first $1', 'icon' => '💵', 'category' => 'milestone', 'tier' => 'bronze', 'points' => 10, 'reward_amount' => 0.10, 'requirements' => ['type' => 'total_earned', 'count' => 1]],
            ['key' => 'earned_10', 'name' => 'Dime Bag', 'description' => 'Earn $10 in total', 'icon' => '💰', 'category' => 'milestone', 'tier' => 'silver', 'points' => 30, 'reward_amount' => 0.25, 'requirements' => ['type' => 'total_earned', 'count' => 10]],
            ['key' => 'earned_50', 'name' => 'Half Century', 'description' => 'Earn $50 in total', 'icon' => '💎', 'category' => 'milestone', 'tier' => 'gold', 'points' => 75, 'reward_amount' => 0.50, 'requirements' => ['type' => 'total_earned', 'count' => 50]],
            ['key' => 'earned_100', 'name' => 'Benjamin', 'description' => 'Earn $100 in total', 'icon' => '🤑', 'category' => 'milestone', 'tier' => 'platinum', 'points' => 150, 'reward_amount' => 1.00, 'requirements' => ['type' => 'total_earned', 'count' => 100]],
            ['key' => 'earned_500', 'name' => 'High Roller', 'description' => 'Earn $500 in total', 'icon' => '💸', 'category' => 'milestone', 'tier' => 'diamond', 'points' => 300, 'reward_amount' => 2.50, 'requirements' => ['type' => 'total_earned', 'count' => 500]],

            // Social Achievements
            ['key' => 'daily_streak_7', 'name' => 'Week Warrior', 'description' => 'Login for 7 days in a row', 'icon' => '🔥', 'category' => 'social', 'tier' => 'bronze', 'points' => 20, 'reward_amount' => 0.20, 'requirements' => ['type' => 'daily_streak', 'count' => 7]],
            ['key' => 'daily_streak_30', 'name' => 'Monthly Master', 'description' => 'Login for 30 days in a row', 'icon' => '🌟', 'category' => 'social', 'tier' => 'silver', 'points' => 50, 'reward_amount' => 0.50, 'requirements' => ['type' => 'daily_streak', 'count' => 30]],
            ['key' => 'daily_streak_90', 'name' => 'Unstoppable', 'description' => 'Login for 90 days in a row', 'icon' => '💫', 'category' => 'social', 'tier' => 'gold', 'points' => 150, 'reward_amount' => 1.50, 'requirements' => ['type' => 'daily_streak', 'count' => 90]],

            // Level Achievements
            ['key' => 'level_10', 'name' => 'Rising Star', 'description' => 'Reach Level 10', 'icon' => '🌠', 'category' => 'milestone', 'tier' => 'bronze', 'points' => 25, 'reward_amount' => 0.25, 'requirements' => ['type' => 'level_reached', 'count' => 10]],
            ['key' => 'level_20', 'name' => 'Elite Member', 'description' => 'Reach Level 20', 'icon' => '👔', 'category' => 'milestone', 'tier' => 'silver', 'points' => 50, 'reward_amount' => 0.50, 'requirements' => ['type' => 'level_reached', 'count' => 20]],
            ['key' => 'level_25', 'name' => 'VIP Status', 'description' => 'Reach Level 25 (Max)', 'icon' => '👑', 'category' => 'milestone', 'tier' => 'diamond', 'points' => 250, 'reward_amount' => 2.50, 'requirements' => ['type' => 'level_reached', 'count' => 25]],

            // Special Achievements
            ['key' => 'first_withdrawal', 'name' => 'Cashout King', 'description' => 'Make your first withdrawal', 'icon' => '💳', 'category' => 'special', 'tier' => 'gold', 'points' => 50, 'reward_amount' => 0.50, 'requirements' => ['type' => 'withdrawals_completed', 'count' => 1]],
            ['key' => 'referral_1', 'name' => 'Recruiter', 'description' => 'Refer your first user', 'icon' => '🤝', 'category' => 'social', 'tier' => 'bronze', 'points' => 20, 'reward_amount' => 0.25, 'requirements' => ['type' => 'referrals', 'count' => 1]],
            ['key' => 'referral_10', 'name' => 'Influencer', 'description' => 'Refer 10 users', 'icon' => '📢', 'category' => 'social', 'tier' => 'silver', 'points' => 100, 'reward_amount' => 1.00, 'requirements' => ['type' => 'referrals', 'count' => 10]],
        ];

        foreach ($achievements as $data) {
            Achievement::updateOrCreate(
                ['key' => $data['key']],
                $data
            );
        }
    }
}

