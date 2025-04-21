<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AduanLayanan extends Model
{
    protected $table = 'aduan_layanan';

    protected $fillable = [
        'nomor_tiket',
        'user_id',
        'nama_lengkap',
        'instansi',
        'isi_aduan',
        'status',
    ];
}
