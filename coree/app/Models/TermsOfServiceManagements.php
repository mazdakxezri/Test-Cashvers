<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsOfServiceManagements extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;

    protected $fillable = [
        'privacy_policy',
        'privacy_policy_updated_at',
        'terms_of_use',
        'terms_of_use_updated_at',
    ];
}
