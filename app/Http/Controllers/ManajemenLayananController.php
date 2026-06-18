<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class ManajemenLayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::orderBy('kode', 'asc')->get();
        return view('Admin.manajemen-layanan', compact('layanans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:layanans,kode',
            'nama' => 'required|string|max:255',
            'icon' => 'nullable|string'
        ]);

        Layanan::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'icon' => $request->icon ?? 'folder',
            'pertanyaan' => []
        ]);

        return redirect()->back()->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);
        
        $request->validate([
            'kode' => 'required|unique:layanans,kode,'.$id,
            'nama' => 'required|string|max:255',
            'icon' => 'nullable|string'
        ]);

        $layanan->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'icon' => $request->icon ?? 'folder'
        ]);

        return redirect()->back()->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Layanan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Layanan berhasil dihapus.');
    }

    // Update pertanyaan untuk layanan tertentu
    public function updatePertanyaan(Request $request, $id)
    {
        $layanan = Layanan::findOrFail($id);
        
        $pertanyaan = [];
        if ($request->has('pertanyaan') && is_array($request->pertanyaan)) {
            // Reindex array
            $pertanyaan = array_values($request->pertanyaan);
        }

        $layanan->pertanyaan = $pertanyaan;
        $layanan->save();

        return redirect()->back()->with('success', 'Alur pertanyaan berhasil disimpan.');
    }
}
