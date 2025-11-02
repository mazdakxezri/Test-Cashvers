<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id',
        'user_id',
        'earnings',
        'offer_id',
    ];

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
