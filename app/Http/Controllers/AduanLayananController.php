<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AduanLayanan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class AduanLayananController extends Controller
{
    public function index()
    {
        // Ambil semua data aduan dari database
        $aduan = AduanLayanan::all();

        // Kirim data ke tampilan
        return view('Admin.aduan-layanan', compact('aduan'));
    }

    // public function update(Request $request, $id)
    // {
    //     // Validasi request
    //     $request->validate([
    //         'status' => 'required|in:0,1'
    //     ]);

    //     try {
    //         // Cari aduan berdasarkan ID dan update status
    //         $aduan = AduanLayanan::findOrFail($id);
    //         $aduan->status = $request->status;
    //         $aduan->save();

    //         // Tampilkan SweetAlert sukses
    //         Alert::success('Berhasil', 'Status tiket berhasil diperbarui.');
    //     } catch (\Exception $e) {
    //         // Tampilkan SweetAlert error jika terjadi kesalahan
    //         Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui status.');
    //     }

    //     // Redirect kembali ke halaman sebelumnya
    //     return redirect()->back();
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'required|in:0,1'
    //     ]);

    //     try {
    //         $aduan = AduanLayanan::findOrFail($id);
    //         $aduan->status = $request->status;
    //         $aduan->save();

    //         // Custom config for toast
    //         $toast = [
    //             'toast' => true,
    //             'position' => 'top-end',
    //             'icon' => 'success',
    //             'title' => 'Status tiket berhasil diperbarui.',
    //             'showConfirmButton' => false,
    //             'timer' => 3000,
    //             'timerProgressBar' => true
    //         ];

    //         Session::flash('alert.config', json_encode($toast));
    //     } catch (\Exception $e) {
    //         $toast = [
    //             'toast' => true,
    //             'position' => 'top-end',
    //             'icon' => 'error',
    //             'title' => 'Gagal memperbarui status.',
    //             'showConfirmButton' => false,
    //             'timer' => 3000,
    //             'timerProgressBar' => true
    //         ];

    //         Session::flash('alert.config', json_encode($toast));
    //     }

    //     return redirect()->back();
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1'
        ]);

        try {
            $aduan = AduanLayanan::findOrFail($id);
            $aduan->status = $request->status;
            $aduan->save();

            // ==========================================================
            // ## KODE BARU UNTUK KIRIM NOTIFIKASI WA ##
            // ==========================================================

            // Cek apakah status yang baru adalah '1' (Closed)
            if ($aduan->status == 1 && !empty($aduan->user_id)) {
                // 1. Ambil data yang diperlukan dari model $aduan
                $nomor_wa = str_replace('@c.us', '', $aduan->user_id);
                $nomor_tiket = $aduan->nomor_tiket;

                // 2. Buat template pesan notifikasi
                $pesan_wa = "Pemberitahuan Layanan 🔔\n\n" .
                    "Tiket aduan Anda dengan nomor *{$nomor_tiket}* telah selesai ditangani dan ditutup (Closed).\n\n" .
                    "Terima kasih telah menggunakan layanan kami.";

                // 3. Panggil API Node.js (gunakan try-catch terpisah agar tidak mengganggu proses utama)
                try {
                    $nodeApiUrl = env('NODE_API_URL', 'http://localhost:3000') . '/kirim-pesan';
                    Http::timeout(15)->post($nodeApiUrl, [
                        'nomor' => $nomor_wa,
                        'pesan' => $pesan_wa,
                    ]);
                } catch (\Exception $e) {
                    // Jika pengiriman WA gagal, proses update status tetap berhasil.
                    // Kita bisa mencatat error ini untuk diperiksa nanti.
                    Log::error('Gagal mengirim notifikasi WA close ticket: ' . $e->getMessage());
                }
            }
            // ==========================================================
            // ## AKHIR DARI KODE BARU ##
            // ==========================================================

            // Custom config for toast (tidak berubah)
            $toast = [
                'toast' => true,
                'position' => 'top-end',
                'icon' => 'success',
                'title' => 'Status tiket berhasil diperbarui.',
                'showConfirmButton' => false,
                'timer' => 3000,
                'timerProgressBar' => true
            ];

            Session::flash('alert.config', json_encode($toast));
        } catch (\Exception $e) {
            $toast = [
                'toast' => true,
                'position' => 'top-end',
                'icon' => 'error',
                'title' => 'Gagal memperbarui status.',
                'showConfirmButton' => false,
                'timer' => 3000,
                'timerProgressBar' => true
            ];

            Session::flash('alert.config', json_encode($toast));
        }

        return redirect()->back();
    }

    // public function reply(Request $request, $id)
    // {
    //     // 1. Validasi input dari form
    //     $request->validate([
    //         'nomor' => 'required|string',
    //         'pesan' => 'required|string|min:5',
    //     ]);

    //     // 2. Tentukan URL API Node.js
    //     // Sebaiknya simpan di file .env -> NODE_API_URL=http://localhost:3000
    //     $nodeApiUrl = env('NODE_API_URL', 'http://localhost:3000') . '/kirim-pesan';

    //     // 3. Kirim request ke API Node.js
    //     try {
    //         $response = Http::timeout(30)->post($nodeApiUrl, [
    //             'nomor' => $request->nomor,
    //             'pesan' => $request->pesan,
    //         ]);

    //         // 4. Proses response dari API
    //         if ($response->successful()) {
    //             // Jika sukses, kembalikan ke halaman sebelumnya dengan notifikasi sukses
    //             return redirect()->back()->with('success', 'Pesan balasan berhasil dikirim via WhatsApp.');
    //         } else {
    //             // Jika gagal, tampilkan pesan error dari API
    //             $errorDetails = $response->json('message', 'Terjadi kesalahan pada server WhatsApp.');
    //             return redirect()->back()->with('error', 'Gagal mengirim pesan: ' . $errorDetails);
    //         }
    //     } catch (\Illuminate\Http\Client\ConnectionException $e) {
    //         // Tangani jika server Node.js tidak bisa dihubungi
    //         return redirect()->back()->with('error', 'Tidak dapat terhubung ke server WhatsApp. Pastikan server Node.js berjalan.');
    //     }
    // }

    public function reply(Request $request, $id)
    {
        // 1. Validasi input dari form (tidak ada perubahan)
        $request->validate([
            'nomor' => 'required|string',
            'pesan' => 'required|string|min:5',
        ]);

        // 2. Tentukan URL API Node.js (tidak ada perubahan)
        $nodeApiUrl = env('NODE_API_URL', 'http://localhost:3000') . '/kirim-pesan';

        // 3. Kirim request ke API Node.js
        try {
            $response = Http::timeout(30)->post($nodeApiUrl, [
                'nomor' => $request->nomor,
                'pesan' => $request->pesan,
            ]);

            // 4. Proses response dari API
            if ($response->successful()) {
                // ## PERUBAHAN DI SINI ##
                // Membuat notifikasi toast untuk kondisi SUKSES
                $toast = [
                    'toast' => true,
                    'position' => 'top-end',
                    'icon' => 'success',
                    'title' => 'Pesan balasan berhasil dikirim.',
                    'showConfirmButton' => false,
                    'timer' => 3000,
                    'timerProgressBar' => true
                ];
                Session::flash('alert.config', json_encode($toast));
            } else {
                // ## PERUBAHAN DI SINI ##
                // Membuat notifikasi toast untuk kondisi GAGAL dari API
                $errorDetails = $response->json('message', 'Terjadi kesalahan pada server WhatsApp.');
                $toast = [
                    'toast' => true,
                    'position' => 'top-end',
                    'icon' => 'error',
                    'title' => 'Gagal mengirim pesan: ' . $errorDetails,
                    'showConfirmButton' => false,
                    'timer' => 5000, // Waktu lebih lama agar pesan error bisa dibaca
                    'timerProgressBar' => true
                ];
                Session::flash('alert.config', json_encode($toast));
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // ## PERUBAHAN DI SINI ##
            // Membuat notifikasi toast untuk kondisi GAGAL KONEKSI
            $toast = [
                'toast' => true,
                'position' => 'top-end',
                'icon' => 'error',
                'title' => 'Gagal terhubung ke server WhatsApp.',
                'showConfirmButton' => false,
                'timer' => 5000,
                'timerProgressBar' => true
            ];
            Session::flash('alert.config', json_encode($toast));
        }

        // Cukup satu kali redirect di akhir
        return redirect()->back();
    }
}
