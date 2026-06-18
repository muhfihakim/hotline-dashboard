<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BotSession extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'service_id', 'step', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
