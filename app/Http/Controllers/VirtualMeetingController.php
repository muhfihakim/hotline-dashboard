<?php

namespace App\Http\Controllers;

use App\Models\VirtualMeeting;
use Illuminate\Support\Facades\Session;
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
        $request->validate([
            'status' => 'required|in:0,1'
        ]);

        try {
            $vm = VirtualMeeting::findOrFail($id);
            $vm->status = $request->status;
            $vm->save();

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
