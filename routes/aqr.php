<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AQR\AduanController;
use App\Http\Controllers\AQR\TiketController;
use App\Http\Controllers\AQR\DashboardAQRController;
use App\Http\Controllers\AQR\ProgresTiketController;

Route::prefix('aqr')->name('aqr.')->group(function () {
    Route::get('/', [DashboardAQRController::class, 'index'])->name('dashboard');

    Route::resource('aduan', AduanController::class);
    Route::resource('tiket', TiketController::class);
    Route::resource('progres-tiket', ProgresTiketController::class);
});
