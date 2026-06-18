<?php

namespace Database\Seeders;

use App\Models\BotSetting;
use Illuminate\Database\Seeder;

class BotSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'greeting_message',
                'name' => 'Pesan Sapaan Utama',
                'value' => "Halo *{name}*! 👋\nSelamat datang di Layanan Hotline Diskominfo.\n\nSilakan balas dengan angka untuk memilih layanan:\n\n1️⃣ Aduan Layanan\n2️⃣ Virtual Meeting\n3️⃣ Virtual Private Server (VPS)\n4️⃣ Bandwidth on Demand\n5️⃣ Tanda Tangan Elektronik\n6️⃣ Infrastruktur Baru\n7️⃣ Reset Email\n8️⃣ Pentesting",
                'description' => 'Pesan yang dikirim ketika user mengetik "Halo", "Ping", atau "Menu". (Gunakan {name} untuk memanggil nama user)',
            ],
            [
                'key' => 'reply_aduan',
                'name' => 'Balasan Pilih Layanan: Aduan',
                'value' => "Anda memilih layanan *Aduan Layanan*.\nSilakan ketik detail aduan Anda dengan format:\n\n*Aduan#Detail Keluhan*",
                'description' => 'Pesan saat user membalas dengan angka 1',
            ],
            [
                'key' => 'reply_vm',
                'name' => 'Balasan Pilih Layanan: Virtual Meeting',
                'value' => "Anda memilih layanan *Virtual Meeting*.\nSilakan ketik permohonan dengan format:\n\n*VM#Tanggal (HH-BB-TTTT)#Keterangan Acara*",
                'description' => 'Pesan saat user membalas dengan angka 2',
            ],
            [
                'key' => 'reply_vps',
                'name' => 'Balasan Pilih Layanan: VPS',
                'value' => "Anda memilih layanan *Virtual Private Server (VPS)*.\nSilakan ketik permohonan dengan format:\n\n*VPS#Spesifikasi Kebutuhan#Tujuan*",
                'description' => 'Pesan saat user membalas dengan angka 3',
            ],
            [
                'key' => 'reply_bod',
                'name' => 'Balasan Pilih Layanan: Bandwidth on Demand',
                'value' => "Anda memilih layanan *Bandwidth on Demand*.\nSilakan ketik permohonan dengan format:\n\n*BOD#Jumlah Bandwidth#Lokasi*",
                'description' => 'Pesan saat user membalas dengan angka 4',
            ],
            [
                'key' => 'reply_tte',
                'name' => 'Balasan Pilih Layanan: TTE',
                'value' => "Anda memilih layanan *Tanda Tangan Elektronik (TTE)*.\nSilakan ketik permohonan dengan format:\n\n*TTE#Nama Lengkap#NIP*",
                'description' => 'Pesan saat user membalas dengan angka 5',
            ],
            [
                'key' => 'reply_infra',
                'name' => 'Balasan Pilih Layanan: Infrastruktur Baru',
                'value' => "Anda memilih layanan *Infrastruktur Baru*.\nSilakan ketik permohonan dengan format:\n\n*INFRA#Nama Infrastruktur#Deskripsi*",
                'description' => 'Pesan saat user membalas dengan angka 6',
            ],
            [
                'key' => 'reply_reset_email',
                'name' => 'Balasan Pilih Layanan: Reset Email',
                'value' => "Anda memilih layanan *Reset Email*.\nSilakan ketik permohonan dengan format:\n\n*RESET#Alamat Email Asal#Alasan*",
                'description' => 'Pesan saat user membalas dengan angka 7',
            ],
            [
                'key' => 'reply_pentest',
                'name' => 'Balasan Pilih Layanan: Pentesting',
                'value' => "Anda memilih layanan *Pentesting*.\nSilakan ketik permohonan dengan format:\n\n*PENTEST#URL/Sistem Target#Deskripsi Kebutuhan*",
                'description' => 'Pesan saat user membalas dengan angka 8',
            ],
            [
                'key' => 'reply_success',
                'name' => 'Pesan Tiket Berhasil Dibuat',
                'value' => "Terimakasih! Permohonan Anda telah kami terima ke dalam sistem.\n\nNomor Tiket Anda: *{ticket}*\nTim kami akan segera memproses permintaan Anda.",
                'description' => 'Pesan yang terkirim jika format pengajuan benar (Gunakan {ticket} untuk menaruh no tiket)',
            ],
            [
                'key' => 'reply_fallback',
                'name' => 'Pesan Kesalahan (Fallback)',
                'value' => "Maaf, perintah/format Anda tidak dikenali sistem kami. 🤖\n\nSilakan ketik *Menu* untuk melihat daftar layanan dan instruksi yang benar.",
                'description' => 'Pesan saat format tidak sesuai atau sistem bingung',
            ],
        ];

        foreach ($settings as $setting) {
            BotSetting::create($setting);
        }
    }
}
