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
        Schema::create('data_prestasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_siswa_id')->constrained()->onDelete('cascade');
            $table->foreignId('sekolah_id')->constrained()->onDelete('cascade');

            $table->string('nama_lomba');
            $table->string('tingkat_lomba');
            $table->enum('status_lomba', ['Terkurasi', 'Tidak terkurasi']);
            $table->string('tahun_pelajaran');
            $table->string('lokasi');
            $table->date('tanggal_pelaksanaan');
            $table->text('keterangan')->nullable();
            $table->string('kategori_lomba')->nullable();
            $table->string('guru_eskul')->nullable();
            $table->string('guru_pendamping')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_prestasis');
    }
};
