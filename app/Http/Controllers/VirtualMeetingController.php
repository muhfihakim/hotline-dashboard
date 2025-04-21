<?php

namespace App\Http\Controllers;

use App\Models\VirtualMeeting;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class VirtualMeetingController extends Controller
{
    public function index()
    {
        // Ambil semua data virtual meeting dari database
        $vm = VirtualMeeting::all();

        // Kirim data ke tampilan
        return view('Admin.virtual-meeting', compact('vm'));
    }

    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'status' => 'required|in:0,1'
        ]);

        try {
            // Cari virtual meeting berdasarkan ID dan update status
            $vm = VirtualMeeting::findOrFail($id);
            $vm->status = $request->status;
            $vm->save();

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
