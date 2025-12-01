<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongan_applies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lowongan_pekerjaan_id')->constrained()->onDelete('cascade');
            $table->string('nama_pelamar');
            $table->string('email_pelamar');
            $table->string('phone_pelamar');
            $table->text('alamat_pelamar');
            $table->string('cv_file')->nullable();
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['Pending', 'Review', 'Interview', 'Diterima', 'Ditolak'])->default('Pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan_applies');
    }
};