<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TandaTanganElektronik extends Model
{
    protected $table = 'penerbitan_tte';

    protected $fillable = [
        'nomor_tiket',
        'user_id',
        'nama_lengkap',
        'instansi',
        'email_dinas',
        'surat_permohonan',
        'status',
    ];
}
