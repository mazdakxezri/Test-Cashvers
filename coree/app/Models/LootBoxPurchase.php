<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LootBoxPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loot_box_type_id',
        'payment_method',
        'price_paid',
        'crypto_currency',
        'opened',
        'opened_at',
    ];

    protected $casts = [
        'price_paid' => 'decimal:2',
        'opened' => 'boolean',
        'opened_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lootBoxType()
    {
        return $this->belongsTo(LootBoxType::class);
    }

    public function rewards()
    {
        return $this->hasMany(UserLootBoxReward::class);
    }
}

