<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLoginBonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'login_date',
        'bonus_amount',
        'claimed',
    ];

    protected $casts = [
        'login_date' => 'date',
        'claimed' => 'boolean',
        'bonus_amount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the bonus.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

