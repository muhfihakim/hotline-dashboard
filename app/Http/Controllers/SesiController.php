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

    // public function login(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'email' => 'required',
    //         'password' => 'required'
    //     ], [
    //         'email.required' => 'Email wajib diisi',
    //         'password.required' => 'Password wajib diisi'
    //     ]);

    //     // Data login
    //     $infologin = [
    //         'email' => $request->email,
    //         'password' => $request->password,
    //     ];

    //     if (Auth::attempt($infologin)) {
    //         if (Auth::user()->role == 'admin') {
    //             return redirect('/admin');
    //         } elseif (Auth::user()->role == 'pimpinan') {
    //             return redirect('/pimpinan');
    //         }
    //     } else {
    //         // return redirect()->route('login')->withErrors(['message' => 'Email dan Password tidak sesuai.'])->withInput();
    //         return redirect()->route('login')->with([
    //             'alert.config' => json_encode([
    //                 'icon' => 'error',
    //                 'title' => 'Gagal Masuk',
    //                 'text' => 'Email dan Password tidak sesuai.',
    //                 'showConfirmButton' => true,
    //             ])
    //         ])->withInput();
    //     }
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            // 'cf-turnstile-response' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'password.required' => 'Password wajib diisi',
            // 'cf-turnstile-response.required' => 'Verifikasi CAPTCHA diperlukan',
        ]);

        // Verifikasi Turnstile dimatikan sementara untuk local development
        /*
        $response = \Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => env('TURNSTILE_SECRET_KEY'),
            'response' => $request->input('cf-turnstile-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!($response->json('success') ?? false)) {
            return redirect()->route('login')->with([
                'alert.config' => json_encode([
                    'icon' => 'error',
                    'title' => 'Gagal Verifikasi',
                    'text' => 'Validasi CAPTCHA gagal. Silakan coba lagi.',
                    'showConfirmButton' => true,
                ])
            ])->withInput();
        }
        */

        // Proses login
        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->role == 'admin') {
                return redirect('/admin');
            } elseif (Auth::user()->role == 'pimpinan') {
                return redirect('/pimpinan');
            }
        } else {
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
