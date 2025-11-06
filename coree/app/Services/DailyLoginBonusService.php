<?php

namespace App\Services;

use App\Models\DailyLoginBonus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DailyLoginBonusService
{
    /**
     * Daily bonus amount in dollars
     */
    const DAILY_BONUS = 0.02;

    /**
     * Check and award daily login bonus to user
     *
     * @param User $user
     * @return array
     */
    public function checkAndAwardBonus(User $user): array
    {
        $today = Carbon::today();
        
        // Check if user already claimed today
        $existingBonus = DailyLoginBonus::where('user_id', $user->id)
            ->where('login_date', $today)
            ->first();

        if ($existingBonus) {
            return [
                'awarded' => false,
                'message' => 'Already claimed today',
                'next_bonus_in' => $this->getTimeUntilNextBonus(),
            ];
        }

        // Award the bonus
        DB::transaction(function () use ($user, $today) {
            // Create bonus record
            DailyLoginBonus::create([
                'user_id' => $user->id,
                'login_date' => $today,
                'bonus_amount' => self::DAILY_BONUS,
                'claimed' => true,
            ]);

            // Add to user balance
            $user->increment('balance', self::DAILY_BONUS);

            // Create track record for admin activity log
            \App\Models\Track::create([
                'uid' => $user->uid,
                'offer_id' => 'daily_login_bonus',
                'offer_name' => 'Daily Login Bonus',
                'amount' => self::DAILY_BONUS,
                'payout' => self::DAILY_BONUS,
                'reward' => self::DAILY_BONUS,
                'status' => 1,
                'partners' => 'system',
                'network_name' => 'Daily Bonus',
                'ip_address' => request()->ip(),
                'country' => $user->country_code ?? 'Unknown',
            ]);
        });

        return [
            'awarded' => true,
            'amount' => self::DAILY_BONUS,
            'message' => 'Daily bonus claimed!',
            'current_streak' => $this->getCurrentStreak($user),
        ];
    }

    /**
     * Get current login streak for user
     *
     * @param User $user
     * @return int
     */
    public function getCurrentStreak(User $user): int
    {
        $streak = 0;
        $date = Carbon::today();

        while (true) {
            $hasLogin = DailyLoginBonus::where('user_id', $user->id)
                ->where('login_date', $date)
                ->exists();

            if (!$hasLogin) {
                break;
            }

            $streak++;
            $date = $date->subDay();
        }

        return $streak;
    }

    /**
     * Get total bonuses earned by user
     *
     * @param User $user
     * @return float
     */
    public function getTotalBonuses(User $user): float
    {
        return DailyLoginBonus::where('user_id', $user->id)
            ->sum('bonus_amount');
    }

    /**
     * Get time until next bonus is available
     *
     * @return string
     */
    public function getTimeUntilNextBonus(): string
    {
        $tomorrow = Carbon::tomorrow();
        $now = Carbon::now();
        
        $diff = $tomorrow->diff($now);
        
        return sprintf('%dh %dm', $diff->h, $diff->i);
    }

    /**
     * Check if user can claim bonus today
     *
     * @param User $user
     * @return bool
     */
    public function canClaimToday(User $user): bool
    {
        $today = Carbon::today();
        
        return !DailyLoginBonus::where('user_id', $user->id)
            ->where('login_date', $today)
            ->exists();
    }

    /**
     * Get user's login history for the last 30 days
     *
     * @param User $user
     * @return array
     */
    public function getLoginHistory(User $user, int $days = 30): array
    {
        $startDate = Carbon::today()->subDays($days - 1);
        $endDate = Carbon::today();

        $bonuses = DailyLoginBonus::where('user_id', $user->id)
            ->whereBetween('login_date', [$startDate, $endDate])
            ->pluck('login_date')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->toArray();

        $calendar = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $dateStr = $currentDate->format('Y-m-d');
            $calendar[] = [
                'date' => $dateStr,
                'day' => $currentDate->format('D'),
                'day_number' => $currentDate->format('j'),
                'claimed' => in_array($dateStr, $bonuses),
                'is_today' => $currentDate->isToday(),
            ];
            $currentDate->addDay();
        }

        return $calendar;
    }
}

