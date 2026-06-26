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
use App\Http\Controllers\QRCodeGenerator;
use App\Http\Controllers\PenjemputanHarianController;
use App\Http\Controllers\MasterPtController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\LeadMeasureController;
use App\Http\Controllers\TaskProcessController;
use App\Http\Controllers\WigProgressController;
use App\Http\Controllers\PrestasiSiswaController;
use App\Http\Controllers\PrestasiGuruController;
use App\Http\Controllers\PersebaranPtController;
use App\Http\Controllers\LowonganApplyController;
use App\Http\Controllers\PersebaranPtnController;
use App\Http\Controllers\LowonganProgressController;
use App\Http\Controllers\LowonganPekerjaanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TopikPermasalahanController;
use App\Http\Controllers\FeaturedQuestionController;
use App\Http\Controllers\MasterSiswaController;
use App\Http\Controllers\MasterGuruController;
use App\Http\Controllers\MasterKelasController;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
});

Route::middleware('auth')->group(function () {



    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::middleware(['role:super-admin|humas|direktur|koordinator'])->group(function () {
        Route::resource('master-guru', MasterGuruController::class);
        Route::resource('master-kelas', MasterKelasController::class);
        Route::resource('sekolah', SekolahController::class);
        Route::resource('master-ptn', MasterPtController::class);
        Route::resource('prestasi-siswa', PrestasiSiswaController::class);
        Route::resource('prestasi-guru', PrestasiGuruController::class);
        Route::resource('lowongan-pekerjaan', LowonganPekerjaanController::class);
        Route::resource('lowongan-apply', LowonganApplyController::class);
        Route::resource('lowongan-progress', LowonganProgressController::class);
        Route::resource('user', UserController::class);
        Route::resource('aqr-option', AqrOptionController::class);
        Route::resource('topik-permasalahan', TopikPermasalahanController::class);
        Route::resource('role', RoleController::class);
        Route::resource('featured-question', FeaturedQuestionController::class);
        Route::post('featured-question/promote/{tiket}', [FeaturedQuestionController::class, 'promoteFromTiket'])->name('featured-question.promote');


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


    Route::get('scan-qr',[QRCodeGenerator::class,'qrCodeScan'])->name('qrCodeScan');
    Route::post('scan-qr-code',[QRCodeGenerator::class,'scanQrCode'])->name('scan.scanQrCode');

    Route::resource('penjemputan-harian', PenjemputanHarianController::class)->except('show');
    Route::post('penjemput-datang',[PenjemputanHarianController::class,'penjemputDatang'])->name('penjemputDatang');

    Route::get('penjemputan-harian/satpam-konfirmasi-kedatangan/{penjemputan_harian}', [PenjemputanHarianController::class, 'satpamKonfirmasiKedatangan'])->name('penjemputan-harian.satpamKonfirmasiKedatangan');
    Route::get('penjemputan-harian/satpam-konfirmasi-keluar/{penjemputan_harian}', [PenjemputanHarianController::class, 'satpamKonfirmasiKeluar'])->name('penjemputan-harian.satpamKonfirmasiKeluar');
    Route::get('penjemputan-harian/guru-konfirmasi/{penjemputan_harian}', [PenjemputanHarianController::class, 'guruKonfirmasi'])->name('penjemputan-harian.guruKonfirmasi');
    Route::get('penjemputan-harian-kelas/{kelas}', [PenjemputanHarianController::class,'penjemputanKelas'])->name('penjemputan-harian.kelas');
    Route::get('generate-harian' , [PenjemputanHarianController::class,'generateSiswaHariIni'])->name('penjemputan-harian.generateSiswaHariIni');
    Route::post('penjemputan-harian/satpam-konfirmasi-ojol/', [PenjemputanHarianController::class, 'satpamKonfirmasiOjol'])->name('penjemputan-harian.satpamKonfirmasiOjol');
    Route::post('data-siswa/{id}', [PenjemputanHarianController::class, 'dataSiswa'])->name('penjemputan-harian.dataSiswa');

    // Ajax Reload
    Route::get('reload-penjemputan', [PenjemputanHarianController::class, 'refreshTablePenjemputan'])->name('penjemputan-harian.refreshTablePenjemputan');
    Route::get('null-penjemputan', [PenjemputanHarianController::class, 'nullPenjemputan'])->name('penjemputan-harian.nullPenjemputan');

    require __DIR__ . '/aqr.php';
});


require __DIR__ . '/auth.php';

require __DIR__ . '/frontend.php';

if (app()->environment('local')) {
    require __DIR__ . '/test-gemini.php';
}
Route::get('siswa/{siswa}/qrcode', [App\Http\Controllers\MasterSiswaController::class, 'generateQrCode'])->name('siswa.generateQrCode');


Route::get('siswa', [App\Http\Controllers\MasterSiswaController::class, 'index'])->name('siswa.index');
