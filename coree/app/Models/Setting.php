<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'value',
    ];

    public static function getValue($name)
    {
        $setting = static::where('name', $name)->select('value')->first();
        return $setting ? $setting->value : null;
    }
}
