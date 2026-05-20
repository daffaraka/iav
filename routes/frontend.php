<?php

use App\Http\Controllers\AQR\HomeAQRController;
use App\Http\Controllers\AQR\Demo\DemoController;
use App\Http\Controllers\DynamicRoutes\SelectController;
use Illuminate\Support\Facades\Route;


// Frontend
// Route::middleware('guest')->group(function () {
//     // Route::get('/', function () {
//     //     return view('frontend.index');
//     // });


Route::prefix('helpdesk')->name('helpdesk.')->group(function () {

    Route::get('/', [HomeAQRController::class, 'create'])->name('home.open-tiket');
    Route::get('/cek-pengirim', [HomeAQRController::class, 'cekPengirim'])->name('home.cek-pengirim');
    Route::post('/store-tiket', [HomeAQRController::class, 'storeTiket'])->name('home.tiket-store');
    Route::get('/tiket/tracking', [HomeAQRController::class, 'tracking'])->name('home.tiket-tracking');
    Route::post('/pencarian-tiket', [HomeAQRController::class, 'pencarianTiket'])->name('home.pencarianTiket');
    Route::get('/tiket/tracking/{tiket}', [HomeAQRController::class, 'show'])->name('home.tiket-show');
    Route::post('/kepuasan/store/{id}', [HomeAQRController::class, 'storeKepuasan'])->name('home.kepuasan-store');
    Route::post('/get-siswa-by-nisn', [HomeAQRController::class, 'getSiswaByNisn'])->name('home.get-siswa');

    Route::post('get-pic-by-dept', [SelectController::class, 'getPicByDept'])->name('home.get-pic-by-dept');

    Route::post('/faq/track', [HomeAQRController::class, 'trackFaqInteraction'])->name('home.faq-track');
    Route::post('/faq/vote', [HomeAQRController::class, 'toggleFaqVote'])->name('home.faq-vote');
});

// Demo Routes (using lovable views)
Route::prefix('helpdesk-demo')->name('helpdesk.demo.')->group(function () {
    Route::get('/', [DemoController::class, 'create'])->name('open-tiket');
    Route::get('/cek-pengirim', [DemoController::class, 'cekPengirim'])->name('cek-pengirim');
    Route::post('/store-tiket', [DemoController::class, 'storeTiket'])->name('tiket-store');
    Route::get('/tiket/tracking', [DemoController::class, 'tracking'])->name('tiket-tracking');
    Route::post('/pencarian-tiket', [DemoController::class, 'pencarianTiket'])->name('pencarianTiket');
    Route::get('/tiket/tracking/{tiket}', [DemoController::class, 'show'])->name('tiket-show');
    Route::post('/kepuasan/store/{id}', [DemoController::class, 'storeKepuasan'])->name('kepuasan-store');
    Route::post('/get-siswa-by-nisn', [DemoController::class, 'getSiswaByNisn'])->name('get-siswa');
});
// });
