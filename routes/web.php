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
    
    // Manajemen Layanan (CRUD CMS)
    Route::get('/manajemen-layanan', [App\Http\Controllers\ManajemenLayananController::class, 'index'])->name('index.manajemen.layanan')->middleware('userAkses:admin');
    Route::post('/manajemen-layanan', [App\Http\Controllers\ManajemenLayananController::class, 'store'])->name('store.manajemen.layanan')->middleware('userAkses:admin');
    Route::patch('/manajemen-layanan/{id}', [App\Http\Controllers\ManajemenLayananController::class, 'update'])->name('update.manajemen.layanan')->middleware('userAkses:admin');
    Route::delete('/manajemen-layanan/{id}', [App\Http\Controllers\ManajemenLayananController::class, 'destroy'])->name('destroy.manajemen.layanan')->middleware('userAkses:admin');
    Route::patch('/manajemen-layanan/{id}/pertanyaan', [App\Http\Controllers\ManajemenLayananController::class, 'updatePertanyaan'])->name('update.pertanyaan.layanan')->middleware('userAkses:admin');

    // Layanan Dinamis
    Route::get('/layanan/{kode}', [App\Http\Controllers\LayananController::class, 'index'])->name('index.layanan.admin')->middleware('userAkses:admin');
    Route::patch('/layanan/{id}/update-status', [App\Http\Controllers\LayananController::class, 'update'])->name('update.layanan.admin')->middleware('userAkses:admin');
    Route::post('/layanan/{id}/reply', [App\Http\Controllers\LayananController::class, 'reply'])->name('reply.layanan.admin')->middleware('userAkses:admin');

    Route::get('/laporan-rekap', [LaporanController::class, 'index'])->name('index.rekap')->middleware('userAkses:admin');
    Route::get('/export/layanan', [ExportController::class, 'exportLayanan'])->name('export.layanan');
    Route::get('/test', function () {
        return view('Admin.modal');
    });
    Route::get('/pengguna', [App\Http\Controllers\PenggunaController::class, 'index'])->name('index.pengguna')->middleware('userAkses:admin');
    Route::post('/pengguna', [App\Http\Controllers\PenggunaController::class, 'store'])->name('store.pengguna.admin')->middleware('userAkses:admin');
    Route::patch('/pengguna/{id}', [App\Http\Controllers\PenggunaController::class, 'update'])->name('update.pengguna.admin')->middleware('userAkses:admin');
    Route::delete('/pengguna/{id}', [App\Http\Controllers\PenggunaController::class, 'destroy'])->name('destroy.pengguna.admin')->middleware('userAkses:admin');
    
    Route::get('/bot-settings', [App\Http\Controllers\BotSettingController::class, 'index'])->name('index.bot-settings.admin')->middleware('userAkses:admin');
    Route::patch('/bot-settings', [App\Http\Controllers\BotSettingController::class, 'update'])->name('update.bot-settings.admin')->middleware('userAkses:admin');
    Route::post('/bot-settings/logout', [App\Http\Controllers\BotSettingController::class, 'logoutBot'])->name('logout.bot.admin')->middleware('userAkses:admin');

    Route::get('/pimpinan', [DashboardController::class, 'indexPimpinan'])->name('dashboard.pimpinan')->middleware('userAkses:pimpinan');

    Route::post('/logout', [SesiController::class, 'logout'])->name('aksi.logout');
});
