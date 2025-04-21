<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AduanLayanan;
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

    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'status' => 'required|in:0,1'
        ]);

        try {
            // Cari aduan berdasarkan ID dan update status
            $aduan = AduanLayanan::findOrFail($id);
            $aduan->status = $request->status;
            $aduan->save();

            // Tampilkan SweetAlert sukses
            Alert::success('Berhasil', 'Status tiket berhasil diperbarui.');
        } catch (\Exception $e) {
            // Tampilkan SweetAlert error jika terjadi kesalahan
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui status.');
        }

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
    }
}
