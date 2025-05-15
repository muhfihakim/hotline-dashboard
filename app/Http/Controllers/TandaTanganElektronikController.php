<?php

namespace App\Http\Controllers;

use App\Models\TandaTanganElektronik;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

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
        $request->validate([
            'status' => 'required|in:0,1'
        ]);

        try {
            $tte = TandaTanganElektronik::findOrFail($id);
            $tte->status = $request->status;
            $tte->save();

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
