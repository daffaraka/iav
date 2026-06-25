<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('master_prestasi_siswa')) {
            Schema::create('master_prestasi_siswa', function (Blueprint $table) {
                $table->id();
                $table->string('tahun_pelajaran', 20)->default('2025-2026');
                $table->date('tanggal_pelaksanaan_lomba');
                $table->string('nama_siswa', 150);
                $table->string('kelas', 20);
                $table->string('wilayah', 100);
                $table->string('nama_lomba', 200);
                $table->string('jenis_lomba', 50);
                $table->string('mata_bidang_lomba', 100);
                $table->string('raihan_prestasi', 100);
                $table->date('tanggal_perolehan_lomba');
                $table->string('penyelenggara', 200);
                $table->string('level_lomba', 50);
                $table->text('nama_pelatih')->nullable();
                $table->text('nama_pembina')->nullable();
                $table->string('tahapan_lomba', 50);
                $table->string('kategori_lomba', 50);
                $table->string('status_kurasi', 50);
                $table->string('lanjutan_status_kurasi', 100);
                $table->unsignedInteger('created_by')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_prestasi_siswa');
    }
};
