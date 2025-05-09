<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        // Kirim data ke tampilan
        return view('Admin.rekap');
    }
}
