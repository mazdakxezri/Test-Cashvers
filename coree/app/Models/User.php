<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\Level;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'uid',
        'email',
        'password',
        'balance',
        'level',
        'ip',
        'last_login_ip',
        'user_agent',
        'country_code',
        'gender',
        'date_of_birth',
        'avatar',
        'referral_code',
        'email_verified_at',
        'invited_by',
        'status',
        'achievement_points',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->uid)) {
                $user->uid = self::generateUniqueUid();
            }

            if (empty($user->referral_code)) {
                $user->referral_code = self::generateUniqueReferralCode();
            }
        });

        // Automatically check for level upgrade on balance update
        static::updated(function ($user) {
            if ($user->isDirty('balance')) {
                $user->upgradeLevel();
            }
        });
    }

    private static function generateUniqueUid($length = 12)
    {
        $firstChar = strtoupper(mb_substr(SiteName(), 0, 1));
        // Adjust the length for the numeric part
        $numericLength = $length - 1; // 1 for the first character

        do {
            $numericString = $firstChar . self::generateRandomDigits($numericLength);
        } while (self::where('uid', $numericString)->exists());

        return $numericString;
    }

    private static function generateRandomDigits($length)
    {
        // Generate a numeric string of the specified length
        return implode('', array_map(function () {
            return mt_rand(0, 9);
        }, range(1, $length)));
    }

    private static function generateUniqueReferralCode($length = 5)
    {
        do {
            $referralCode = Str::random($length);
        } while (self::where('referral_code', $referralCode)->exists());

        return $referralCode;
    }



    public function invitedBy()
    {
        return $this->belongsTo(User::class, 'invited_by', 'id');
    }

    public function upgradeLevel()
    {
        // Get the total earnings for the user from the 'tracks' table
        $currentEarnings = \DB::table('tracks')
            ->where('uid', $this->uid)
            ->sum('reward');

        $level = Level::where('required_earning', '<=', $currentEarnings)
            ->orderBy('level', 'desc')
            ->first();

        if ($level && $this->level < $level->level) {
            $oldLevel = $this->level;
            $this->level = $level->level;
            $this->balance += $level->reward;
            $this->save();
            
            // Award tier upgrade rewards (free loot boxes as cash for now)
            \App\Services\LevelService::awardTierRewards($this, $level->level);
            
            // Store level up info in session for notification
            session()->flash('level_up', [
                'old_level' => $oldLevel,
                'new_level' => $level->level,
                'reward' => $level->reward,
            ]);
        }
    }

    /**
     * Get user's achievements
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withPivot(['progress', 'is_unlocked', 'unlocked_at', 'is_claimed', 'claimed_at'])
            ->withTimestamps();
    }

    /**
     * Get user's unlocked achievements count
     */
    public function getUnlockedAchievementsCountAttribute(): int
    {
        return \App\Models\UserAchievement::where('user_id', $this->id)
            ->where('is_unlocked', true)
            ->count();
    }
}
