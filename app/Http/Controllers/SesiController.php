<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    public function index()
    {
        return view('login');  // Tampilkan halaman login
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        // Data login
        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->role == 'admin') {
                return redirect('/admin');
            } elseif (Auth::user()->role == 'ketua_tim') {
                return redirect('/ketua-tim');
            } elseif (Auth::user()->role == 'kepala_bidang') {
                return redirect('/kepala-bidang');
            }
        } else {
            // return redirect()->route('login')->withErrors(['message' => 'Email dan Password tidak sesuai.'])->withInput();
            return redirect()->route('login')->with([
                'alert.config' => json_encode([
                    'icon' => 'error',
                    'title' => 'Gagal Masuk',
                    'text' => 'Email dan Password tidak sesuai.',
                    'showConfirmButton' => true,
                ])
            ])->withInput();
        }
    }

    public function logout()
    {
        // Logout pengguna
        Auth::logout();
        return redirect('/');
    }
}
