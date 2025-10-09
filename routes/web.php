<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WigController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\DataPrestasiController;
use App\Http\Controllers\DepartementController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard');

Route::resource('sekolah', SekolahController::class);
Route::resource('data-prestasi', DataPrestasiController::class);


Route::resource('departement',DepartementController::class);
Route::resource('wig', WigController::class);




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
