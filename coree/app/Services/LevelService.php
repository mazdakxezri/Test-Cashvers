<?php

namespace App\Services;

use App\Models\Level;
use App\Models\User;

class LevelService
{
    /**
     * Tier definitions with names and colors
     */
    const TIERS = [
        'bronze' => [
            'name' => 'Bronze',
            'levels' => [1, 2, 3, 4, 5],
            'color' => '#CD7F32',
            'ranks' => [
                1 => 'Bronze Starter',
                2 => 'Bronze Earner',
                3 => 'Bronze Hunter',
                4 => 'Bronze Champion',
                5 => 'Bronze Elite',
            ],
            'icon' => '🥉',
        ],
        'silver' => [
            'name' => 'Silver',
            'levels' => [6, 7, 8, 9, 10],
            'color' => '#C0C0C0',
            'ranks' => [
                6 => 'Silver Explorer',
                7 => 'Silver Warrior',
                8 => 'Silver Master',
                9 => 'Silver Legend',
                10 => 'Silver Elite',
            ],
            'icon' => '🥈',
        ],
        'gold' => [
            'name' => 'Gold',
            'levels' => [11, 12, 13, 14, 15],
            'color' => '#FFD700',
            'ranks' => [
                11 => 'Gold Crusader',
                12 => 'Gold Conqueror',
                13 => 'Gold Champion',
                14 => 'Gold Legend',
                15 => 'Gold Elite',
            ],
            'icon' => '🥇',
        ],
        'diamond' => [
            'name' => 'Diamond',
            'levels' => [16, 17, 18, 19, 20],
            'color' => '#00E5FF',
            'ranks' => [
                16 => 'Diamond Ace',
                17 => 'Diamond Pro',
                18 => 'Diamond King',
                19 => 'Diamond Emperor',
                20 => 'Diamond Elite',
            ],
            'icon' => '💎',
        ],
        'elite' => [
            'name' => 'Elite',
            'levels' => [21, 22, 23, 24, 25],
            'color' => '#FF00FF',
            'ranks' => [
                21 => 'Elite Titan',
                22 => 'Elite Immortal',
                23 => 'Elite Divine',
                24 => 'Elite Mythic',
                25 => 'Elite God',
            ],
            'icon' => '👑',
        ],
    ];

    /**
     * Get tier info for a level
     */
    public static function getTierForLevel(int $level): array
    {
        foreach (self::TIERS as $tierKey => $tier) {
            if (in_array($level, $tier['levels'])) {
                return [
                    'key' => $tierKey,
                    'name' => $tier['name'],
                    'color' => $tier['color'],
                    'rank_name' => $tier['ranks'][$level] ?? $tier['name'] . ' Member',
                    'icon' => $tier['icon'],
                ];
            }
        }
        
        // Default for level 0 or very high levels
        return [
            'key' => 'bronze',
            'name' => 'Bronze',
            'color' => '#CD7F32',
            'rank_name' => $level == 0 ? 'Newcomer' : 'Elite God',
            'icon' => $level == 0 ? '🌱' : '👑',
        ];
    }

    /**
     * Get progress to next level
     */
    public static function getProgressToNextLevel(User $user): array
    {
        $currentEarnings = \DB::table('tracks')
            ->where('uid', $user->uid)
            ->sum('reward');

        $currentLevel = Level::where('required_earning', '<=', $currentEarnings)
            ->orderBy('level', 'desc')
            ->first();

        $nextLevel = Level::where('level', '>', $user->level)
            ->orderBy('level', 'asc')
            ->first();

        if (!$nextLevel) {
            return [
                'current_xp' => $currentEarnings,
                'required_xp' => $currentEarnings,
                'percentage' => 100,
                'next_level' => null,
            ];
        }

        $currentLevelRequirement = $currentLevel->required_earning ?? 0;
        $xpInCurrentLevel = $currentEarnings - $currentLevelRequirement;
        $xpNeededForNext = $nextLevel->required_earning - $currentLevelRequirement;
        $percentage = ($xpInCurrentLevel / $xpNeededForNext) * 100;

        return [
            'current_xp' => $currentEarnings,
            'required_xp' => $nextLevel->required_earning,
            'xp_in_level' => $xpInCurrentLevel,
            'xp_needed' => $xpNeededForNext,
            'percentage' => min(100, $percentage),
            'next_level' => $nextLevel,
            'next_tier' => self::getTierForLevel($nextLevel->level),
        ];
    }

    /**
     * Get unlocked features for current level
     */
    public static function getUnlockedFeatures(int $level): array
    {
        $features = [];
        
        // Offer access
        if ($level >= 1) {
            $features[] = 'Basic Offers';
        }
        if ($level >= 6) {
            $features[] = 'High-Paying Offers (2x+ rewards)';
        }
        if ($level >= 11) {
            $features[] = 'Premium Offerwalls';
        }
        if ($level >= 16) {
            $features[] = 'Exclusive Surveys';
        }
        
        // Loot boxes
        if ($level >= 1) {
            $features[] = 'Bronze Loot Boxes';
        }
        if ($level >= 6) {
            $features[] = 'Silver Loot Boxes + Free Box on Level Up';
        }
        if ($level >= 11) {
            $features[] = 'Gold Loot Boxes + Free Box on Level Up';
        }
        if ($level >= 16) {
            $features[] = 'Diamond Loot Boxes + 2 Free Boxes on Level Up';
        }
        if ($level >= 21) {
            $features[] = 'Elite Loot Boxes + 3 Free Boxes on Level Up';
        }
        
        // Special perks
        if ($level >= 11) {
            $features[] = 'Priority Withdrawal (24h processing)';
        }
        if ($level >= 16) {
            $features[] = 'Instant Withdrawal (no hold)';
        }
        if ($level >= 21) {
            $features[] = 'VIP Badge + Exclusive Events';
            $features[] = 'No Withdrawal Fees';
        }
        
        return $features;
    }

    /**
     * Award tier upgrade rewards (free loot boxes)
     */
    public static function awardTierRewards(User $user, int $newLevel): void
    {
        $tierInfo = self::getTierForLevel($newLevel);
        
        // Award free loot boxes based on tier
        $freeBoxes = 0;
        
        if ($newLevel >= 6 && $newLevel <= 10) {
            $freeBoxes = 1; // Silver tier
        } elseif ($newLevel >= 11 && $newLevel <= 15) {
            $freeBoxes = 1; // Gold tier
        } elseif ($newLevel >= 16 && $newLevel <= 20) {
            $freeBoxes = 2; // Diamond tier
        } elseif ($newLevel >= 21) {
            $freeBoxes = 3; // Elite tier
        }
        
        // Create loot box rewards (we'll implement this when boxes exist)
        // For now, just give cash equivalent
        if ($freeBoxes > 0) {
            $cashReward = $freeBoxes * 2.00; // $2 per free box
            $user->increment('balance', $cashReward);
            
            // Log the reward
            \App\Models\Track::create([
                'uid' => $user->uid,
                'offer_id' => 'tier_upgrade_reward',
                'offer_name' => 'Tier Upgrade Reward - ' . $tierInfo['rank_name'],
                'amount' => $cashReward,
                'payout' => $cashReward,
                'reward' => $cashReward,
                'status' => 1,
                'partners' => 'system',
                'network_name' => 'Tier Rewards',
                'ip' => request()->ip(),
                'country' => $user->country_code ?? 'Unknown',
            ]);
        }
    }

    /**
     * Check if user can access offer based on level
     */
    public static function canAccessOffer(User $user, float $payout): bool
    {
        $level = $user->level;
        
        // High-paying offers (2x average) locked until level 6
        if ($payout >= 2.00 && $level < 6) {
            return false;
        }
        
        // Premium offers (5x average) locked until level 11
        if ($payout >= 5.00 && $level < 11) {
            return false;
        }
        
        // Exclusive offers (10x average) locked until level 16
        if ($payout >= 10.00 && $level < 16) {
            return false;
        }
        
        return true;
    }
}

