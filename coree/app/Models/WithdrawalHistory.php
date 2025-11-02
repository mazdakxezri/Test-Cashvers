<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'redeem_wallet',
        'withdrawal_categories_id',
        'status',
        'hold_due_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(WithdrawalCategory::class, 'withdrawal_categories_id');
    }
}
