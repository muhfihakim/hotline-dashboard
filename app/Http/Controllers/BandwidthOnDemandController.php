<?php

namespace App\Http\Controllers;

use App\Models\BandwidthOnDemand;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BandwidthOnDemandController extends Controller
{
    public function index()
    {
        // Ambil semua data aduan dari database
        $bod = BandwidthOnDemand::all();

        // Kirim data ke tampilan
        return view('Admin.bandwidth-on-demand', compact('bod'));
    }

    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'status' => 'required|in:0,1'
        ]);

        try {
            // Cari bod berdasarkan ID dan update status
            $bod = BandwidthOnDemand::findOrFail($id);
            $bod->status = $request->status;
            $bod->save();

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
