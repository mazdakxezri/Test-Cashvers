<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'withdrawal_type',
        'cover',
        'reward_img',
        'bg_color',
    ];

    public function subCategories()
    {
        return $this->hasMany(WithdrawalSubCategory::class, 'withdrawal_categories_id');
    }
}
