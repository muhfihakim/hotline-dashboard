<?php

namespace App\Http\Controllers;

use App\Models\TandaTanganElektronik;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TandaTanganElektronikController extends Controller
{
    public function index()
    {
        // Ambil semua data virtual meeting dari database
        $tte = TandaTanganElektronik::all();

        // Kirim data ke tampilan
        return view('Admin.tanda-tangan-elektronik', compact('tte'));
    }

    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'status' => 'required|in:0,1'
        ]);

        try {
            // Cari virtual meeting berdasarkan ID dan update status
            $tte = TandaTanganElektronik::findOrFail($id);
            $tte->status = $request->status;
            $tte->save();

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
