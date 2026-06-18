<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'name',
        'value',
        'description',
    ];

    /**
     * Helper to get setting value quickly
     */
    public static function getValue($key, $default = '')
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
