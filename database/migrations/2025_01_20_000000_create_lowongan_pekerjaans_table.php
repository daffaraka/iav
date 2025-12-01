<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongan_pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->string('judul_lowongan');
            $table->string('perusahaan');
            $table->text('deskripsi');
            $table->string('lokasi');
            $table->enum('jenis_pekerjaan', ['Full Time', 'Part Time', 'Kontrak', 'Magang']);
            $table->string('gaji_min')->nullable();
            $table->string('gaji_max')->nullable();
            $table->text('persyaratan');
            $table->date('tanggal_tutup');
            $table->enum('status', ['Aktif', 'Tutup', 'Draft'])->default('Aktif');
            $table->string('kontak_email');
            $table->string('kontak_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan_pekerjaans');
    }
};