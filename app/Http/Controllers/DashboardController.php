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
    public function index(Request $request)
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

        $search = $request->search;
        $status = $request->status;

        $applyFilters = function($q) use ($search, $status) {
            if ($search) {
                $q->where(function($q2) use ($search) {
                    $q2->where('nomor_tiket', 'like', "%{$search}%");
                });
            }
            if ($status !== null && $status !== '') {
                $q->where('status', $status);
            }
            return $q;
        };

        // Ambil data dari semua layanan dengan filter
        $allData = collect()
            ->merge($applyFilters(AduanLayanan::query())->latest()->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Aduan Layanan',
                'waktu' => $item->created_at,
                'status' => $item->status,
            ]))
            ->merge($applyFilters(VirtualMeeting::query())->latest()->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Virtual Meeting',
                'waktu' => $item->created_at,
                'status' => $item->status,
            ]))
            ->merge($applyFilters(VirtualPrivateServer::query())->latest()->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Virtual Private Server',
                'waktu' => $item->created_at,
                'status' => $item->status,
            ]))
            ->merge($applyFilters(BandwidthOnDemand::query())->latest()->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Bandwidth on Demand',
                'waktu' => $item->created_at,
                'status' => $item->status,
            ]))
            ->merge($applyFilters(Infrastruktur::query())->latest()->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Infrastruktur Baru',
                'waktu' => $item->created_at,
                'status' => $item->status,
            ]))
            ->merge($applyFilters(ResetEmail::query())->latest()->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Layanan Email',
                'waktu' => $item->created_at,
                'status' => $item->status,
            ]))
            ->merge($applyFilters(Pentest::query())->latest()->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Pen-Testing',
                'waktu' => $item->created_at,
                'status' => $item->status,
            ]))
            ->merge($applyFilters(TandaTanganElektronik::query())->latest()->get()->map(fn($item) => [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => 'Tanda Tangan Elektronik',
                'waktu' => $item->created_at,
                'status' => $item->status,
            ]));

        // Urutkan berdasarkan waktu terbaru
        $allData = $allData->sortByDesc('waktu')->values();

        // Pagination Manual
        $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $latestData = new \Illuminate\Pagination\LengthAwarePaginator(
            $allData->forPage($page, $perPage),
            $allData->count(),
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'stats' => [
                    'totalAduanLayanan' => $totalAduanLayanan,
                    'totalVirtualMeeting' => $totalVirtualMeeting,
                    'totalVps' => $totalVps,
                    'totalBandwidthOnDemand' => $totalBandwidthOnDemand,
                    'totalInfrastrukturBaru' => $totalInfrastrukturBaru,
                    'totalResetEmail' => $totalResetEmail,
                    'totalPentest' => $totalPentest,
                    'totalTte' => $totalTte,
                ],
                'latestData' => $latestData
            ]);
        }

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

    public function indexPimpinan(Request $request)
    {
        $data = [
            'aduanLayanan' => \App\Models\AduanLayanan::all(),
            'virtualMeeting' => \App\Models\VirtualMeeting::all(),
            'vps' => \App\Models\VirtualPrivateServer::all(),
            'bod' => \App\Models\BandwidthOnDemand::all(),
            'infrastruktur' => \App\Models\Infrastruktur::all(),
            'resetEmail' => \App\Models\ResetEmail::all(),
            'pentest' => \App\Models\Pentest::all(),
            'tte' => \App\Models\TandaTanganElektronik::all(),
        ];

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($data);
        }

        return view('Pimpinan.dash', $data);
    }
}
