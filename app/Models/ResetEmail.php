<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetEmail extends Model
{
    protected $table = 'permohonan_reset_email';

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
