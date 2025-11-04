<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSession extends Model
{
    protected $fillable = [
        'user_id',
        'uid',
        'ip_address',
        'country_code',
        'city',
        'timezone',
        'device_type',
        'os',
        'browser',
        'browser_version',
        'screen_width',
        'screen_height',
        'user_agent',
        'device_fingerprint',
        'login_at',
    ];

    protected $casts = [
        'login_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get fraud risk indicators for this session
     */
    public function getFraudIndicators($allUserSessions)
    {
        $indicators = [];
        
        // Check for IP changes
        $uniqueIps = $allUserSessions->pluck('ip_address')->unique()->count();
        if ($uniqueIps > 3) {
            $indicators[] = ['type' => 'ip_changes', 'severity' => 'high', 'value' => $uniqueIps];
        }
        
        // Check for country changes
        $uniqueCountries = $allUserSessions->pluck('country_code')->unique()->count();
        if ($uniqueCountries > 1) {
            $indicators[] = ['type' => 'country_change', 'severity' => 'high', 'value' => $uniqueCountries];
        }
        
        // Check for timezone mismatches
        $uniqueTimezones = $allUserSessions->pluck('timezone')->unique()->count();
        if ($uniqueTimezones > 2) {
            $indicators[] = ['type' => 'timezone_mismatch', 'severity' => 'medium', 'value' => $uniqueTimezones];
        }
        
        // Check for multiple devices
        $uniqueDevices = $allUserSessions->pluck('device_fingerprint')->unique()->count();
        if ($uniqueDevices > 3) {
            $indicators[] = ['type' => 'multiple_devices', 'severity' => 'medium', 'value' => $uniqueDevices];
        }
        
        return $indicators;
    }

    /**
     * Calculate fraud risk score (0-100)
     */
    public static function calculateFraudScore($userId)
    {
        $sessions = static::where('user_id', $userId)->orderBy('login_at', 'desc')->get();
        
        if ($sessions->count() < 2) {
            return 0; // New user, no data yet
        }
        
        $score = 0;
        
        // IP changes
        $uniqueIps = $sessions->pluck('ip_address')->unique()->count();
        if ($uniqueIps > 1) $score += 15 * ($uniqueIps - 1);
        
        // Country changes
        $uniqueCountries = $sessions->pluck('country_code')->unique()->count();
        if ($uniqueCountries > 1) $score += 30 * ($uniqueCountries - 1);
        
        // Timezone inconsistencies
        $uniqueTimezones = $sessions->pluck('timezone')->unique()->count();
        if ($uniqueTimezones > 2) $score += 10 * ($uniqueTimezones - 2);
        
        // Multiple devices
        $uniqueDevices = $sessions->pluck('device_fingerprint')->unique()->count();
        if ($uniqueDevices > 3) $score += 5 * ($uniqueDevices - 3);
        
        // Cap at 100
        return min($score, 100);
    }
}

