<?php

namespace App\Http\Controllers;

use App\Models\BandwidthOnDemand;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

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
        $request->validate([
            'status' => 'required|in:0,1'
        ]);

        try {
            // Cari bod berdasarkan ID dan update status
            $bod = BandwidthOnDemand::findOrFail($id);
            $bod->status = $request->status;
            $bod->save();

            // Custom config for toast
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
}
