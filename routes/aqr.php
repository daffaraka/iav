<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AQR\AQRController;
use App\Http\Controllers\AQR\AduanController;
use App\Http\Controllers\AQR\TiketController;
use App\Http\Controllers\AqrOptionController;
use App\Http\Controllers\AQR\DashboardAQRController;
use App\Http\Controllers\AQR\ProgresTiketController;
use App\Http\Controllers\AQR\AnalyticsController;

Route::middleware('auth')->prefix('dashboard/aqr')->name('dashboard.aqr.')->group(function () {
    Route::get('/', [AQRController::class, 'index'])->name('dashboard');

    Route::resource('tiket', TiketController::class);
    Route::resource('progres-tiket', ProgresTiketController::class);

    Route::resource('aqr-option', AqrOptionController::class);
    // Tiket actions
    Route::patch('tiket/{id}/proses', [TiketController::class, 'proses'])->name('tiket.proses');
    Route::post('tiket/{id}/rating', [TiketController::class, 'rating'])->name('tiket.rating');
    Route::get('tiket/selesaikan/{tiket}', [TiketController::class, 'finish'])->name('tiket.finish');

    // AI Analytics
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::post('analytics/analyze/{id}', [AnalyticsController::class, 'analyzeTicket'])->name('analytics.analyze');
    Route::post('analytics/bulk-analyze', [AnalyticsController::class, 'bulkAnalyze'])->name('analytics.bulk');
    
    // Delete All Tickets
    Route::delete('tiket/delete-all', [TiketController::class, 'deleteAll'])->name('tiket.deleteAll');
});
