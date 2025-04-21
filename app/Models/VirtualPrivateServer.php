<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualPrivateServer extends Model
{
    protected $table = 'permohonan_vps';

    protected $fillable = [
        'nomor_tiket',
        'user_id',
        'nama_lengkap',
        'instansi',
        'spesifikasi',
        'surat_permohonan',
        'status',
    ];
}
