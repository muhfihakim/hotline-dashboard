<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Infrastruktur extends Model
{
    protected $table = 'permohonan_infrastruktur';

    protected $fillable = [
        'nomor_tiket',
        'user_id',
        'nama_lengkap',
        'instansi',
        'jenis_koneksi',
        'lokasi',
        'surat_permohonan',
        'status',
    ];
}
