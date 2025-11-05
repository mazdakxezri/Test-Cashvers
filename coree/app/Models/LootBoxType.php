<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LootBoxType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price_usd',
        'can_buy_with_earnings',
        'can_buy_with_crypto',
        'is_active',
        'order',
    ];

    protected $casts = [
        'price_usd' => 'decimal:2',
        'can_buy_with_earnings' => 'boolean',
        'can_buy_with_crypto' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function items()
    {
        return $this->hasMany(LootBoxItem::class);
    }

    public function purchases()
    {
        return $this->hasMany(LootBoxPurchase::class);
    }
}

