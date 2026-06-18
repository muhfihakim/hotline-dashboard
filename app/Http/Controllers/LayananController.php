<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request, $kode)
    {
        $layanan = Layanan::where('kode', $kode)->firstOrFail();
        
        $query = Permohonan::where('service_id', $kode);

        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->search);
            // Search in JSON column 'data' or nomor_tiket
            $query->where(function ($q) use ($search) {
                $q->where('nomor_tiket', 'LIKE', "%{$search}%")
                  ->orWhere('data', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $permohonan = $query->latest()->paginate(10);
        
        // Pass the service object disguised as array for backward compatibility with the view
        $serviceInfo = [
            'name' => $layanan->nama,
            'route_base' => 'layanan'
        ];

        return view('Admin.layanan-dinamis', compact('permohonan', 'serviceInfo', 'kode', 'layanan'));
    }

    public function update(Request $request, $id)
    {
        $item = Permohonan::findOrFail($id);
        $item->status = $request->status;
        $item->save();

        return redirect()->back()->with('success', 'Status tiket berhasil diubah.');
    }

    public function reply(Request $request, $id)
    {
        // Fitur balas chat
        return redirect()->back()->with('success', 'Balasan sedang dikirim.');
    }
}
