<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BandwidthOnDemand extends Model
{
    protected $table = 'permohonan_bod';

    protected $fillable = [
        'nomor_tiket',
        'user_id',
        'nama_lengkap',
        'instansi',
        'jenis_koneksi_peruntukan',
        'lokasi',
        'surat_permohonan',
        'status',
    ];
}
