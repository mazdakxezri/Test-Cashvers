<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaderboardSettings extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_prize',
        'number_of_users',
        'distribution_method',
        'top_ranks_prizes',
        'duration',
        'status'
    ];

    protected $casts = [
        'top_ranks_prizes' => 'array',
    ];
}
