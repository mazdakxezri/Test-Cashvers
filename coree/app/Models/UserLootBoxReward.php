<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLootBoxReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loot_box_purchase_id',
        'loot_box_item_id',
        'value_received',
        'claimed',
        'claimed_at',
    ];

    protected $casts = [
        'value_received' => 'decimal:2',
        'claimed' => 'boolean',
        'claimed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchase()
    {
        return $this->belongsTo(LootBoxPurchase::class, 'loot_box_purchase_id');
    }

    public function item()
    {
        return $this->belongsTo(LootBoxItem::class, 'loot_box_item_id');
    }
}

