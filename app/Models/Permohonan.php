<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_tiket',
        'service_id',
        'phone',
        'data',
        'status',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function layanan()
    {
        // Hubungkan ke model Layanan menggunakan service_id == kode
        return $this->belongsTo(Layanan::class, 'service_id', 'kode');
    }
}
