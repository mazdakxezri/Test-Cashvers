<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LootBoxItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'loot_box_type_id',
        'name',
        'type',
        'value',
        'image',
        'description',
        'rarity',
        'drop_rate',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'drop_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function lootBoxType()
    {
        return $this->belongsTo(LootBoxType::class);
    }

    public function rewards()
    {
        return $this->hasMany(UserLootBoxReward::class);
    }
}

