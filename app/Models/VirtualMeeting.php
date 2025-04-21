<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualMeeting extends Model
{
    protected $table = 'permohonan_virtual_meeting';

    protected $fillable = [
        'nomor_tiket',
        'user_id',
        'nama_lengkap',
        'instansi',
        'topik_meeting',
        'waktu_pelaksanaan',
        'jumlah_partisipan',
        'durasi_meeting',
        'lokasi_meeting',
        'jenis_fasilitas',
        'surat_permohonan',
        'status',
    ];
}
