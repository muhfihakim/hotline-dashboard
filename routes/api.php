<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AduanLayananController;
use App\Http\Controllers\BandwidthOnDemandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\InfrastrukturController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PentestingController;
use App\Http\Controllers\ResetEmailController;
use App\Http\Controllers\TandaTanganElektronikController;
use App\Http\Controllers\VirtualMeetingController;
use App\Http\Controllers\VirtualPrivateServerController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

// Rute Webhook Node.js Bot
Route::post('/bot/webhook', [App\Http\Controllers\Api\BotWebhookController::class, 'handle']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('userAkses:admin')->group(function () {
        Route::get('/admin', [DashboardController::class, 'index']);
        Route::get('/aduan-layanan', [AduanLayananController::class, 'index']);
        Route::patch('/aduan-layanan/{id}/update-status', [AduanLayananController::class, 'update']);
        Route::post('/aduan-layanan/{id}/reply', [AduanLayananController::class, 'reply']);
        Route::get('/virtual-meeting', [VirtualMeetingController::class, 'index']);
        Route::patch('/virtual-meeting/{id}/update-status', [VirtualMeetingController::class, 'update']);
        Route::get('/virtual-private-server', [VirtualPrivateServerController::class, 'index']);
        Route::patch('/virtual-private-server/{id}/update-status', [VirtualPrivateServerController::class, 'update']);
        Route::get('/bandwidth-on-demand', [BandwidthOnDemandController::class, 'index']);
        Route::patch('/bandwidth-on-demand/{id}/update-status', [BandwidthOnDemandController::class, 'update']);
        Route::get('/tanda-tangan-elektronik', [TandaTanganElektronikController::class, 'index']);
        Route::patch('/tanda-tangan-elektronik/{id}/update-status', [TandaTanganElektronikController::class, 'update']);
        Route::get('/infrastruktur-baru', [InfrastrukturController::class, 'index']);
        Route::patch('/infrastruktur-baru/{id}/update-status', [InfrastrukturController::class, 'update']);
        Route::get('/reset-email', [ResetEmailController::class, 'index']);
        Route::patch('/reset-email/{id}/update-status', [ResetEmailController::class, 'update']);
        Route::get('/pentesting', [PentestingController::class, 'index']);
        Route::patch('/pentesting/{id}/update-status', [PentestingController::class, 'update']);
        Route::get('/laporan-rekap', [LaporanController::class, 'index']);
        Route::get('/pengguna', function () {
            return response()->json(['message' => 'View Pengguna (API)']);
        });
    });

    Route::middleware('userAkses:pimpinan')->group(function () {
        Route::get('/pimpinan', [DashboardController::class, 'indexPimpinan']);
    });

    Route::get('/export/layanan', [ExportController::class, 'exportLayanan']);
});
