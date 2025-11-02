<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'name',
        'description',
        'requirements',
        'payout',
        'link',
        'creative',
        'countries',
        'event',
        'device',
        'partner',
        'status',
        'type',
    ];
}
