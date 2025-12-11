<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AQR\AduanController;
use App\Http\Controllers\AQR\AQRController;
use App\Http\Controllers\AQR\TiketController;
use App\Http\Controllers\AQR\DashboardAQRController;
use App\Http\Controllers\AQR\ProgresTiketController;

Route::middleware('auth')->prefix('dashboard/aqr')->name('dashboard.aqr.')->group(function () {
    Route::get('/', [AQRController::class, 'index'])->name('dashboard');

    Route::resource('tiket', TiketController::class);
    Route::resource('progres-tiket', ProgresTiketController::class);

    // Tiket actions
    Route::patch('tiket/{id}/proses', [TiketController::class, 'proses'])->name('tiket.proses');
    Route::post('tiket/{id}/rating', [TiketController::class, 'rating'])->name('tiket.rating');
    Route::get('tiket/selesaikan/{tiket}', [TiketController::class, 'finish'])->name('tiket.finish');
});
