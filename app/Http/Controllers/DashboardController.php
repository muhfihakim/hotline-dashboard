<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua layanan dinamis
        $layanans = Layanan::orderBy('kode', 'asc')->get();

        // 2. Hitung statistik dinamis per layanan
        $stats = [];
        foreach ($layanans as $layanan) {
            $stats[$layanan->kode] = [
                'nama' => $layanan->nama,
                'icon' => $layanan->icon ?? 'folder',
                'total' => Permohonan::where('service_id', $layanan->kode)->count(),
                'kode' => $layanan->kode
            ];
        }

        // 3. Ambil permohonan dengan fitur filter
        $query = Permohonan::with('layanan');

        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'LIKE', "%{$search}%")
                  ->orWhere('data', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 4. Format latest data agar kompatibel dengan view sebelumnya
        $latestDataPaginator = $query->latest()->paginate(10);
        $latestData = $latestDataPaginator->map(function($item) {
            return [
                'tiket' => $item->nomor_tiket ?? '-',
                'kategori' => $item->layanan ? $item->layanan->nama : 'Layanan ('.$item->service_id.')',
                'waktu' => $item->created_at,
                'status' => $item->status,
                'kode_layanan' => $item->service_id
            ];
        });

        // Rekonstruksi pagination
        $latestData = new \Illuminate\Pagination\LengthAwarePaginator(
            $latestData,
            $latestDataPaginator->total(),
            $latestDataPaginator->perPage(),
            $latestDataPaginator->currentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'stats' => $stats,
                'latestData' => $latestData
            ]);
        }

        return view('Admin.dash', compact('stats', 'latestData'));
    }

    public function indexPimpinan(Request $request)
    {
        // 1. Ambil semua layanan dinamis
        $layanans = Layanan::orderBy('kode', 'asc')->get();

        // 2. Format struktur dinamis per layanan
        $data = [];
        foreach ($layanans as $layanan) {
            $data[$layanan->kode] = [
                'nama' => $layanan->nama,
                'permohonan' => Permohonan::where('service_id', $layanan->kode)->get()
            ];
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($data);
        }

        return view('Pimpinan.dash', compact('data', 'layanans'));
    }
}
