<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    protected $fillable = [
        'network_name',
        'network_slug',
        'network_image',
        'network_description',
        'network_rating',
        'offerwall_url',
        'level_id',
        'network_order',
        'postback_method',
        'network_status',
        'network_type',
        'param_url_visibility',
        'param_secret',
        'param_amount',
        'param_payout',
        'param_custom_rate',
        'param_user_id',
        'param_offer_id',
        'param_offer_name',
        'param_tx_id',
        'param_ip',
        'param_country',
        'param_status',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
}
