<?php

use App\Models\Wig;
use App\Models\TaskProcess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WigController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\AqrOptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterPtnController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\LeadMeasureController;
use App\Http\Controllers\TaskProcessController;
use App\Http\Controllers\WigProgressController;
use App\Http\Controllers\DataPrestasiController;
use App\Http\Controllers\PersebaranPtController;
use App\Http\Controllers\LowonganApplyController;
use App\Http\Controllers\PersebaranPtnController;
use App\Http\Controllers\LowonganProgressController;
use App\Http\Controllers\LowonganPekerjaanController;

Route::get('/', function () {
    return redirect()->to('dashboard');
});


Route::middleware('auth')->group(function () {



    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::middleware(['role:super-admin|humas|direktur|koordinator'])->group(function () {
        Route::resource('sekolah', SekolahController::class);
        Route::resource('master-ptn', MasterPtnController::class);
        Route::resource('data-prestasi', DataPrestasiController::class);
        Route::get('prestasi/jagakarsa', [DataPrestasiController::class, 'jagakarsa'])->name('prestasi.jagakarsa');
        Route::get('prestasi/cinere', [DataPrestasiController::class, 'cinere'])->name('prestasi.cinere');
        Route::get('prestasi/pamulang', [DataPrestasiController::class, 'pamulang'])->name('prestasi.pamulang');
        Route::resource('lowongan-pekerjaan', LowonganPekerjaanController::class);
        Route::resource('lowongan-apply', LowonganApplyController::class);
        Route::resource('lowongan-progress', LowonganProgressController::class);
        Route::resource('user', UserController::class);
        Route::resource('aqr-option', AqrOptionController::class);


        Route::resource('departement', DepartementController::class);
        Route::get('departement/{departement}/{wig}', [DepartementController::class, 'showWig'])->name('dept.show.wig');
        Route::get('departement/{departement}/{wig}/edit', [WigController::class, 'editByDept'])->name('dept.edit.wig');

        Route::resource('wig', WigController::class);
        Route::resource('wig.lead-measure', LeadMeasureController::class);
        Route::resource('wig.lead-measure.task-process', TaskProcessController::class);
        Route::resource('departement.wig.progress-wig', WigProgressController::class);
        Route::post('departement/store-wig', [WigController::class, 'storeByDept'])->name('wig.storeByDept');
        Route::resource('persebaran-ptn', PersebaranPtController::class);
    });

    // Routing json
    Route::post('get-wig-by-id/{id}', [WigProgressController::class, 'getWigById'])->name('getWigId');
    Route::post('wig-chart/{id}', [WigController::class, 'wigChart'])->name('wig.chart');
    Route::post('get-lm-tasks/{id}', [LeadMeasureController::class, 'getLmTasks'])->name('getLmTasks');
    Route::post('tasks.toggleStatus', [TaskProcessController::class, 'toggleStatus'])->name('tasks.toggleStatus');
    Route::post('get-lm/{id}', [LeadMeasureController::class, 'getLm'])->name('getLm');
    Route::post('add-new-task/{id}', [DepartementController::class, 'addNewTask'])->name('addNewTask');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    require __DIR__ . '/aqr.php';
});


require __DIR__ . '/auth.php';

require __DIR__ . '/frontend.php';
