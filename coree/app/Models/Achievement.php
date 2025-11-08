<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'icon',
        'badge_image',
        'category',
        'tier',
        'points',
        'reward_amount',
        'requirements',
        'order',
        'is_active',
        'is_hidden',
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_active' => 'boolean',
        'is_hidden' => 'boolean',
        'reward_amount' => 'decimal:2',
    ];

    /**
     * Get users who have this achievement
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->withPivot(['progress', 'is_unlocked', 'unlocked_at', 'is_claimed', 'claimed_at'])
            ->withTimestamps();
    }

    /**
     * Get color for achievement tier
     */
    public function getTierColorAttribute(): string
    {
        return match($this->tier) {
            'bronze' => '#CD7F32',
            'silver' => '#C0C0C0',
            'gold' => '#FFD700',
            'platinum' => '#E5E4E2',
            'diamond' => '#00B8D4',
            default => '#9E9E9E',
        };
    }

    /**
     * Get icon for achievement tier
     */
    public function getTierIconAttribute(): string
    {
        return match($this->tier) {
            'bronze' => '🥉',
            'silver' => '🥈',
            'gold' => '🥇',
            'platinum' => '💎',
            'diamond' => '👑',
            default => '🏆',
        };
    }

    /**
     * Scope to get only active achievements
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get achievements by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}

