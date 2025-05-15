<?php

use App\Http\Controllers\AduanLayananController;
use App\Http\Controllers\BandwidthOnDemandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InfrastrukturController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PentestingController;
use App\Http\Controllers\ResetEmailController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\TandaTanganElektronikController;
use App\Http\Controllers\VirtualMeetingController;
use App\Http\Controllers\VirtualPrivateServerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controllers\Middleware;


Route::middleware(['guest'])->group(function () {
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});
Route::get('/home', function () {
    return redirect('/admin');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('dashboard.admin')->middleware('userAkses:admin');
    Route::get('/aduan-layanan', [AduanLayananController::class, 'index'])->name('index.aduan.admin')->middleware('userAkses:admin');
    Route::patch('/aduan-layanan/{id}/update-status', [AduanLayananController::class, 'update'])->name('update.aduan.admin')->middleware('userAkses:admin');
    Route::get('/virtual-meeting', [VirtualMeetingController::class, 'index'])->name('index.vm.admin')->middleware('userAkses:admin');
    Route::patch('/virtual-meeting/{id}/update-status', [VirtualMeetingController::class, 'update'])->name('update.vm.admin')->middleware('userAkses:admin');
    Route::get('/virtual-private-server', [VirtualPrivateServerController::class, 'index'])->name('index.vps.admin')->middleware('userAkses:admin');
    Route::patch('/virtual-private-server/{id}/update-status', [VirtualPrivateServerController::class, 'update'])->name('update.vps.admin')->middleware('userAkses:admin');
    Route::get('/bandwidth-on-demand', [BandwidthOnDemandController::class, 'index'])->name('index.bod.admin')->middleware('userAkses:admin');
    Route::patch('/bandwidth-on-demand/{id}/update-status', [BandwidthOnDemandController::class, 'update'])->name('update.bod.admin')->middleware('userAkses:admin');
    Route::get('/tanda-tangan-elektronik', [TandaTanganElektronikController::class, 'index'])->name('index.tte.admin')->middleware('userAkses:admin');
    Route::patch('/tanda-tangan-elektronik/{id}/update-status', [TandaTanganElektronikController::class, 'update'])->name('update.tte.admin')->middleware('userAkses:admin');
    Route::get('/infrastruktur-baru', [InfrastrukturController::class, 'index'])->name('index.infrastruktur.admin')->middleware('userAkses:admin');
    Route::patch('/infrastruktur-baru/{id}/update-status', [InfrastrukturController::class, 'update'])->name('update.infrastruktur.admin')->middleware('userAkses:admin');
    Route::get('/reset-email', [ResetEmailController::class, 'index'])->name('index.resetemail.admin')->middleware('userAkses:admin');
    Route::patch('/reset-email/{id}/update-status', [ResetEmailController::class, 'update'])->name('update.resetemail.admin')->middleware('userAkses:admin');
    Route::get('/pentesting', [PentestingController::class, 'index'])->name('index.pentest.admin')->middleware('userAkses:admin');
    Route::patch('/pentesting/{id}/update-status', [PentestingController::class, 'update'])->name('update.pentest.admin')->middleware('userAkses:admin');
    Route::get('/laporan-rekap', [LaporanController::class, 'index'])->name('index.rekap')->middleware('userAkses:admin');
    Route::get('/export/layanan', [ExportController::class, 'exportLayanan'])->name('export.layanan');
    Route::get('/test', function () {
        return view('Admin.modal');
    });
    Route::get('/test', function () {
        return view('Admin.pengguna');
    })->name('index.pengguna');

    Route::post('/logout', [SesiController::class, 'logout'])->name('aksi.logout');
});
