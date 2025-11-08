<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'event_type',
        'banner_image',
        'banner_color',
        'bonus_multiplier',
        'start_date',
        'end_date',
        'is_active',
        'show_banner',
        'send_notification',
        'priority',
        'target_users',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'show_banner' => 'boolean',
        'send_notification' => 'boolean',
        'target_users' => 'array',
        'bonus_multiplier' => 'decimal:2',
    ];

    /**
     * Check if event is currently running
     */
    public function isRunning(): bool
    {
        $now = Carbon::now();
        return $this->is_active 
            && $now->between($this->start_date, $this->end_date);
    }

    /**
     * Get time remaining in human readable format
     */
    public function getTimeRemainingAttribute(): string
    {
        if (!$this->isRunning()) {
            return 'Ended';
        }

        return $this->end_date->diffForHumans();
    }

    /**
     * Get countdown in seconds
     */
    public function getCountdownSecondsAttribute(): int
    {
        if (!$this->isRunning()) {
            return 0;
        }

        return max(0, Carbon::now()->diffInSeconds($this->end_date, false));
    }

    /**
     * Scope to get only active events
     */
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now);
    }

    /**
     * Scope to get upcoming events
     */
    public function scopeUpcoming($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
            ->where('start_date', '>', $now);
    }

    /**
     * Scope to get events with banners
     */
    public function scopeWithBanners($query)
    {
        return $query->where('show_banner', true);
    }
}

