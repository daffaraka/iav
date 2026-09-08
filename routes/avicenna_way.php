<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvicennaWayController;
use App\Http\Controllers\AvicennaWayAnalyticsController;

Route::prefix('avicenna-way')->name('avicenna-way.')->group(function () {
    Route::get('/', [AvicennaWayController::class, 'index'])->name('index');
    Route::post('/store', [AvicennaWayController::class, 'store'])->name('store');
    
    // Analytics
    Route::get('/analytics', [AvicennaWayAnalyticsController::class, 'index'])->name('analytics');
});
