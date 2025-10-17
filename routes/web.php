<?php

use App\Models\TaskProcess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WigController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\LeadMeasureController;
use App\Http\Controllers\TaskProcessController;
use App\Http\Controllers\WigProgressController;
use App\Http\Controllers\DataPrestasiController;
use App\Models\Wig;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard');

Route::resource('sekolah', SekolahController::class);
Route::resource('data-prestasi', DataPrestasiController::class);


Route::resource('departement',DepartementController::class);
Route::get('departement/{departement}/{wig}',[DepartementController::class,'showWig'])->name('dept.show.wig');
Route::get('departement/{departement}/{wig}/edit',[WigController::class,'editByDept'])->name('dept.edit.wig');

Route::resource('wig', WigController::class);
Route::resource('lead-measure', LeadMeasureController::class);
Route::resource('task-process', TaskProcessController::class);
Route::resource('departement.wig.progress-wig',WigProgressController::class);
Route::post('departement/store-wig',[WigController::class,'storeByDept'])->name('wig.storeByDept');

// Routing json
Route::post('get-wig-by-id/{id}', [WigProgressController::class,'getWigById'])->name('getWigId');
Route::post('wig-chart/{id}', [WigController::class,'wigChart'])->name('wig.chart');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
