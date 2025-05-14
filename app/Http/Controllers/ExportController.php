<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AduanLayanan;
use App\Models\BandwidthOnDemand;
use App\Models\Infrastruktur;
use App\Models\Pentest;
use App\Models\ResetEmail;
use App\Models\TandaTanganElektronik;
use App\Models\VirtualMeeting;
use App\Models\VirtualPrivateServer;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AduanLayananExport;
use App\Exports\BandwidthOnDemandExport;
use App\Exports\InfrastrukturBaruExport;
use App\Exports\LayananEmailExport;
use App\Exports\PenTestingExport;
use App\Exports\TTEExport;
use App\Exports\VirtualMeetingExport;
use App\Exports\VirtualPrivateServerExport;

class ExportController extends Controller
{
    public function exportLayanan(Request $request)
    {
        $layanan = $request->input('layanan');
        $format = $request->input('format');
        $tanggal = explode(' - ', $request->input('tanggal'));

        if (!isset($tanggal[0]) || !isset($tanggal[1])) {
            return back()->with('alert.config', json_encode([
                'icon' => 'error',
                'title' => 'Tanggal tidak valid',
                'text' => 'Harap pilih rentang tanggal yang benar.',
            ]));
        }

        $startDate = date('Y-m-d 00:00:00', strtotime($tanggal[0]));
        $endDate = date('Y-m-d 23:59:59', strtotime($tanggal[1]));

        switch ($layanan) {
            case 'aduan':
                $data = AduanLayanan::whereBetween('created_at', [$startDate, $endDate])->get();
                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('exports.aduan_pdf', compact('data', 'startDate', 'endDate'));
                    return $pdf->download('aduan-layanan.pdf');
                } elseif ($format === 'excel') {
                    return Excel::download(new AduanLayananExport($data), 'aduan-layanan.xlsx');
                }
                break;

            case 'virtualmeeting':
                $data = VirtualMeeting::whereBetween('created_at', [$startDate, $endDate])->get();
                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('exports.virtual_meeting_pdf', compact('data', 'startDate', 'endDate'));
                    return $pdf->download('virtual-meeting.pdf');
                } elseif ($format === 'excel') {
                    return Excel::download(new VirtualMeetingExport($data), 'virtual-meeting.xlsx');
                }
                break;

            case 'vps':
                $data = VirtualPrivateServer::whereBetween('created_at', [$startDate, $endDate])->get();
                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('exports.vps_pdf', compact('data', 'startDate', 'endDate'));
                    return $pdf->download('virtual-private-server.pdf');
                } elseif ($format === 'excel') {
                    return Excel::download(new VirtualPrivateServerExport($data), 'virtual-private-server.xlsx');
                }
                break;

            case 'bod':
                $data = BandwidthOnDemand::whereBetween('created_at', [$startDate, $endDate])->get();
                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('exports.bod_pdf', compact('data', 'startDate', 'endDate'));
                    return $pdf->download('bandwidth-on-demand.pdf');
                } elseif ($format === 'excel') {
                    return Excel::download(new BandwidthOnDemandExport($data), 'bandwidth-on-demand.xlsx');
                }
                break;

            case 'infrastruktur':
                $data = Infrastruktur::whereBetween('created_at', [$startDate, $endDate])->get();
                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('exports.infrastruktur_pdf', compact('data', 'startDate', 'endDate'));
                    return $pdf->download('infrastruktur-baru.pdf');
                } elseif ($format === 'excel') {
                    return Excel::download(new InfrastrukturBaruExport($data), 'infrastruktur-baru.xlsx');
                }
                break;

            case 'email':
                $data = ResetEmail::whereBetween('created_at', [$startDate, $endDate])->get();
                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('exports.layanan_email_pdf', compact('data', 'startDate', 'endDate'));
                    return $pdf->download('layanan-email.pdf');
                } elseif ($format === 'excel') {
                    return Excel::download(new LayananEmailExport($data), 'layanan-email.xlsx');
                }
                break;

            case 'pentest':
                $data = Pentest::whereBetween('created_at', [$startDate, $endDate])->get();
                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('exports.pentesting_pdf', compact('data', 'startDate', 'endDate'));
                    return $pdf->download('pentesting.pdf');
                } elseif ($format === 'excel') {
                    return Excel::download(new PenTestingExport($data), 'pentesting.xlsx');
                }
                break;

            case 'tte':
                $data = TandaTanganElektronik::whereBetween('created_at', [$startDate, $endDate])->get();
                if ($format === 'pdf') {
                    $pdf = Pdf::loadView('exports.tte_pdf', compact('data', 'startDate', 'endDate'));
                    return $pdf->download('tte.pdf');
                } elseif ($format === 'excel') {
                    return Excel::download(new TTEExport($data), 'tte.xlsx');
                }
                break;


            default:
                return back()->with('alert.config', json_encode([
                    'icon' => 'error',
                    'title' => 'Layanan tidak dikenali',
                    'text' => 'Silakan pilih layanan yang tersedia.',
                ]));
        }

        return back();
    }
}
