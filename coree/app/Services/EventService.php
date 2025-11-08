<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EventService
{
    /**
     * Get currently active events
     */
    public function getActiveEvents(): Collection
    {
        return Event::active()
            ->orderBy('priority', 'desc')
            ->orderBy('start_date', 'desc')
            ->get();
    }

    /**
     * Get active events that should show banners
     */
    public function getActiveBanners(): Collection
    {
        return Event::active()
            ->withBanners()
            ->orderBy('priority', 'desc')
            ->limit(3) // Show max 3 banners
            ->get();
    }

    /**
     * Get active bonus multiplier (returns highest if multiple active)
     */
    public function getActiveBonusMultiplier(): float
    {
        $activeEvents = Event::active()
            ->where('event_type', 'bonus_multiplier')
            ->get();

        if ($activeEvents->isEmpty()) {
            return 1.00;
        }

        // Return the highest multiplier
        return $activeEvents->max('bonus_multiplier');
    }

    /**
     * Apply event bonus to reward amount
     */
    public function applyEventBonus(float $amount): float
    {
        $multiplier = $this->getActiveBonusMultiplier();
        return $amount * $multiplier;
    }

    /**
     * Get upcoming events
     */
    public function getUpcomingEvents(): Collection
    {
        return Event::upcoming()
            ->orderBy('start_date')
            ->limit(5)
            ->get();
    }

    /**
     * Check if user should see event (based on target_users)
     */
    public function userCanSeeEvent(User $user, Event $event): bool
    {
        // If no targeting, show to all
        if (!$event->target_users) {
            return true;
        }

        // Check targeting conditions
        foreach ($event->target_users as $condition => $value) {
            switch ($condition) {
                case 'min_level':
                    if ($user->level < $value) {
                        return false;
                    }
                    break;
                case 'max_level':
                    if ($user->level > $value) {
                        return false;
                    }
                    break;
                case 'countries':
                    if (!in_array($user->country_code, $value)) {
                        return false;
                    }
                    break;
                case 'exclude_countries':
                    if (in_array($user->country_code, $value)) {
                        return false;
                    }
                    break;
            }
        }

        return true;
    }

    /**
     * Get events for specific user (filtered by targeting)
     */
    public function getEventsForUser(User $user): Collection
    {
        $events = $this->getActiveEvents();

        return $events->filter(function ($event) use ($user) {
            return $this->userCanSeeEvent($user, $event);
        });
    }
}

