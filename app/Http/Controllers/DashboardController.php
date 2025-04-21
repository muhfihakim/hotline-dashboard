<?php

namespace App\Http\Controllers;

use App\Models\AduanLayanan;
use App\Models\BandwidthOnDemand;
use App\Models\Infrastruktur;
use App\Models\Pentest;
use App\Models\ResetEmail;
use App\Models\TandaTanganElektronik;
use App\Models\User;
use App\Models\VirtualMeeting;
use App\Models\VirtualPrivateServer;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total dari masing-masing tabel
        $totalAduanLayanan = AduanLayanan::count();
        $totalVirtualMeeting = VirtualMeeting::count();
        $totalVps = VirtualPrivateServer::count();
        $totalBandwidthOnDemand = BandwidthOnDemand::count();
        $totalInfrastrukturBaru = Infrastruktur::count();
        $totalResetEmail = ResetEmail::count();
        $totalPentest = Pentest::count();
        $totalTte = TandaTanganElektronik::count();

        // Kirim data ke view
        return view('Admin.dash', compact(
            'totalAduanLayanan',
            'totalVirtualMeeting',
            'totalVps',
            'totalBandwidthOnDemand',
            'totalInfrastrukturBaru',
            'totalResetEmail',
            'totalPentest',
            'totalTte'
        ));
    }
}
