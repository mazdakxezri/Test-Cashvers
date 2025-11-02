<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'offer_name',
        'reward',
        'payout',
        'ip',
        'country',
        'status',
        'uid',
        'partners',
        'transaction_id',
    ];
}
