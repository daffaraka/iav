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
        Schema::create('tiket_karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('no_tiket', 250)->unique();
            $table->unsignedBigInteger('user_id'); // Pengirim tiket (Karyawan)
            $table->string('judul_kendala', 255);
            $table->string('departemen', 50)->nullable();
            $table->text('masalah_dept')->nullable();
            $table->string('lokasi_kendala', 250)->nullable();
            $table->text('detail_kendala')->nullable();
            $table->enum('status', ['New', 'Proses', 'Selesai', 'Spam'])->default('New');
            $table->string('filename', 100)->nullable();
            
            // Assignment / Handling
            $table->unsignedBigInteger('admin_id')->nullable(); // Admin/HR yang menerima/assign
            $table->unsignedBigInteger('pic_id')->nullable();   // PIC/Teknisi yang ditugaskan

            // Penilaian
            $table->enum('kepuasan', ['Puas', 'Tidak Puas'])->nullable();
            $table->integer('rating')->nullable()->comment('Rating 1-5 bintang');
            $table->text('deskripsi_penilaian')->nullable();
            
            // Waktu
            $table->timestamp('waktu_proses')->nullable();
            $table->timestamp('waktu_close')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket_karyawans');
    }
};
