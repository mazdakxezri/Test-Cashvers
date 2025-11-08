<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAchievement extends Model
{
    protected $fillable = [
        'user_id',
        'achievement_id',
        'progress',
        'is_unlocked',
        'unlocked_at',
        'is_claimed',
        'claimed_at',
    ];

    protected $casts = [
        'is_unlocked' => 'boolean',
        'is_claimed' => 'boolean',
        'unlocked_at' => 'datetime',
        'claimed_at' => 'datetime',
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the achievement
     */
    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class);
    }

    /**
     * Get progress percentage
     */
    public function getProgressPercentageAttribute(): int
    {
        if (!$this->achievement || !$this->achievement->requirements) {
            return 0;
        }

        $required = $this->achievement->requirements['count'] ?? 1;
        return min(100, (int)(($this->progress / $required) * 100));
    }
}

