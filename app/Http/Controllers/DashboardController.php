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
use Illuminate\Support\Collection;

class DashboardController extends Controller

{
    public function index()
    {
        // Hitung total
        $totalAduanLayanan = AduanLayanan::count();
        $totalVirtualMeeting = VirtualMeeting::count();
        $totalVps = VirtualPrivateServer::count();
        $totalBandwidthOnDemand = BandwidthOnDemand::count();
        $totalInfrastrukturBaru = Infrastruktur::count();
        $totalResetEmail = ResetEmail::count();
        $totalPentest = Pentest::count();
        $totalTte = TandaTanganElektronik::count();

        // Ambil data terbaru dari semua layanan
        $latestData = collect()
            ->merge(AduanLayanan::latest()->take(3)->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Aduan Layanan',
                'waktu' => $item->created_at,
            ]))
            ->merge(VirtualMeeting::latest()->take(3)->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Virtual Meeting',
                'waktu' => $item->created_at,
            ]))
            ->merge(VirtualPrivateServer::latest()->take(3)->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Virtual Private Server',
                'waktu' => $item->created_at,
            ]))
            ->merge(BandwidthOnDemand::latest()->take(3)->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Bandwidth on Demand',
                'waktu' => $item->created_at,
            ]))
            ->merge(Infrastruktur::latest()->take(3)->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Infrastruktur Baru',
                'waktu' => $item->created_at,
            ]))
            ->merge(ResetEmail::latest()->take(3)->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Layanan Email',
                'waktu' => $item->created_at,
            ]))
            ->merge(Pentest::latest()->take(3)->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Pen-Testing',
                'waktu' => $item->created_at,
            ]))
            ->merge(TandaTanganElektronik::latest()->take(3)->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Tanda Tangan Elektronik',
                'waktu' => $item->created_at,
            ]));

        // Urutkan berdasarkan waktu terbaru
        $latestData = $latestData->sortByDesc('waktu')->take(10);

        return view('Admin.dash', compact(
            'totalAduanLayanan',
            'totalVirtualMeeting',
            'totalVps',
            'totalBandwidthOnDemand',
            'totalInfrastrukturBaru',
            'totalResetEmail',
            'totalPentest',
            'totalTte',
            'latestData'
        ));
    }
}
