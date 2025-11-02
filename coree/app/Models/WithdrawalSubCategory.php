<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalSubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'description',
        'withdrawal_categories_id',
    ];

    public function category()
    {
        return $this->belongsTo(WithdrawalCategory::class, 'withdrawal_categories_id');
    }
}
