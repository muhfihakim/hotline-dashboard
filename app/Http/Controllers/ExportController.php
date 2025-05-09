<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AduanLayanan;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AduanLayananExport;

class ExportController extends Controller
{
    public function exportAduanLayanan(Request $request)
    {
        $layanan = $request->input('layanan');
        $format = $request->input('format');
        $tanggal = explode(' - ', $request->input('tanggal'));

        if ($layanan !== 'aduan') {
            return back()->with('alert.config', json_encode([
                'icon' => 'error',
                'title' => 'Terjadi kesalahan',
                'text' => 'Cek kembali data yang akan di export.',
            ]));
        }

        $startDate = date('Y-m-d 00:00:00', strtotime($tanggal[0]));
        $endDate = date('Y-m-d 23:59:59', strtotime($tanggal[1]));

        $data = AduanLayanan::whereBetween('created_at', [$startDate, $endDate])->get();

        if ($format === 'pdf') {
            $pdf = Pdf::loadView('exports.aduan_pdf', compact('data', 'startDate', 'endDate'));
            return $pdf->download('aduan-layanan.pdf');
        } elseif ($format === 'excel') {
            return Excel::download(new AduanLayananExport($data), 'aduan-layanan.xlsx');
        }

        return back();
    }
}
