<?php

namespace Database\Seeders;

use App\Models\BotSetting;
use Illuminate\Database\Seeder;

class AddFlowSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'flow_1_questions',
                'name' => 'Pertanyaan: Aduan Layanan',
                'value' => "nama_lengkap|Silakan masukkan *Nama Lengkap* Anda:\ninstansi|Dari *Instansi/Bidang* mana Anda berasal?\nisi_aduan|Silakan masukkan *Detail Keluhan / Aduan* Anda:",
                'description' => 'Format: "nama_kolom|Pertanyaan". Pisahkan tiap pertanyaan dengan baris baru (Enter).',
            ],
            [
                'key' => 'flow_2_questions',
                'name' => 'Pertanyaan: Virtual Meeting',
                'value' => "nama_lengkap|Silakan masukkan *Nama Lengkap* pemohon:\ninstansi|Dari *Instansi/Bidang* mana Anda berasal?\nwaktu_mulai|Masukkan *Waktu Mulai* (Contoh: 12 Okt 09:00):\nwaktu_selesai|Masukkan *Waktu Selesai* (Contoh: 12 Okt 12:00):\nagenda|Masukkan *Agenda/Nama Acara*:",
                'description' => 'Format: "nama_kolom|Pertanyaan". Pisahkan tiap pertanyaan dengan baris baru (Enter).',
            ],
            [
                'key' => 'flow_3_questions',
                'name' => 'Pertanyaan: VPS',
                'value' => "nama_lengkap|Silakan masukkan *Nama Lengkap* pemohon:\ninstansi|Dari *Instansi/Bidang* mana Anda berasal?\nkebutuhan_cpu|Berapa Core CPU yang dibutuhkan?:\nkebutuhan_ram|Berapa GB RAM yang dibutuhkan?:\nkebutuhan_storage|Berapa GB Storage yang dibutuhkan?:\nsistem_operasi|Sistem Operasi apa yang diinginkan?:",
                'description' => 'Format: "nama_kolom|Pertanyaan". Pisahkan tiap pertanyaan dengan baris baru (Enter).',
            ],
            [
                'key' => 'flow_4_questions',
                'name' => 'Pertanyaan: Bandwidth on Demand',
                'value' => "nama_lengkap|Silakan masukkan *Nama Lengkap* pemohon:\ninstansi|Dari *Instansi/Bidang* mana Anda berasal?\nkapasitas|Berapa Mbps bandwidth tambahan yang dibutuhkan?:\nwaktu_mulai|Mulai tanggal/jam berapa?:\nwaktu_selesai|Sampai tanggal/jam berapa?:\nketerangan|Apa tujuan penggunaan bandwidth tambahan ini?:",
                'description' => 'Format: "nama_kolom|Pertanyaan". Pisahkan tiap pertanyaan dengan baris baru (Enter).',
            ],
            [
                'key' => 'flow_5_questions',
                'name' => 'Pertanyaan: Tanda Tangan Elektronik',
                'value' => "nama_lengkap|Silakan masukkan *Nama Lengkap* pemohon TTE:\nnip|Silakan masukkan *NIP* Anda:\ninstansi|Dari *Instansi/Bidang* mana Anda berasal?\njabatan|Apa *Jabatan* Anda?:",
                'description' => 'Format: "nama_kolom|Pertanyaan". Pisahkan tiap pertanyaan dengan baris baru (Enter).',
            ],
            [
                'key' => 'flow_6_questions',
                'name' => 'Pertanyaan: Infrastruktur Baru',
                'value' => "nama_lengkap|Silakan masukkan *Nama Lengkap* pemohon:\ninstansi|Dari *Instansi/Bidang* mana Anda berasal?\njenis_infrastruktur|Jenis infrastruktur apa yang dibutuhkan?:\nlokasi|Di mana lokasi penempatan infrastruktur?:\nketerangan|Jelaskan secara detail kebutuhan Anda:",
                'description' => 'Format: "nama_kolom|Pertanyaan". Pisahkan tiap pertanyaan dengan baris baru (Enter).',
            ],
            [
                'key' => 'flow_7_questions',
                'name' => 'Pertanyaan: Reset Email',
                'value' => "nama_lengkap|Silakan masukkan *Nama Lengkap* pemilik email:\ninstansi|Dari *Instansi/Bidang* mana Anda berasal?\nalamat_email|Silakan masukkan *Alamat Email*:\nalasan|Apa alasan reset password?:",
                'description' => 'Format: "nama_kolom|Pertanyaan". Pisahkan tiap pertanyaan dengan baris baru (Enter).',
            ],
            [
                'key' => 'flow_8_questions',
                'name' => 'Pertanyaan: Pentesting',
                'value' => "nama_lengkap|Silakan masukkan *Nama Lengkap* pemohon:\ninstansi|Dari *Instansi/Bidang* mana Anda berasal?\nnama_aplikasi|Apa *Nama Aplikasi/Sistem* yang akan diuji?:\nurl_aplikasi|Masukkan *URL/Domain* aplikasi target:\ndeskripsi|Berikan deskripsi singkat tentang aplikasi ini:",
                'description' => 'Format: "nama_kolom|Pertanyaan". Pisahkan tiap pertanyaan dengan baris baru (Enter).',
            ],
        ];

        foreach ($settings as $setting) {
            BotSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'name' => $setting['name'],
                    'value' => $setting['value'],
                    'description' => $setting['description']
                ]
            );
        }
    }
}
