<?php

namespace App\Http\Controllers;

use App\Models\ResetEmail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;

class ResetEmailController extends Controller
{
    public function index()
    {
        // Ambil semua data virtual meeting dari database
        
        $query = \App\Models\ResetEmail::query();
        if (request()->has('search') && request()->search != '') {
            $search = request()->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_tiket', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }
        if (request()->has('status') && request()->status != '') {
            $query->where('status', request()->status);
        }
        $resetemail = $query->latest()->paginate(10);

        // Kirim data ke tampilan
        return view('Admin.reset-email', compact('resetemail'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1'
        ]);

        try {
            $resetemail = ResetEmail::findOrFail($id);
            $resetemail->status = $request->status;
            $resetemail->save();

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
