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
        Schema::create('tikets', function (Blueprint $table) {
             $table->id();
            $table->string('nisn')->nullable();
            $table->string('no_tiket', 250)->unique();
            $table->string('no_hp', 250)->nullable();
            $table->string('nama', 50)->nullable();
            $table->string('nama_orangtua', 100)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('judul_kendala', 255);
            $table->string('departemen', 50)->nullable();
            $table->string('lokasi_kendala', 250)->nullable();
            $table->text('detail_kendala')->nullable();
            $table->enum('status', ['New', 'Proses', 'Selesai'])->nullable();
            $table->string('filename', 100)->nullable();
            $table->enum('pengirim', ['Masyarakat Umum', 'Warga Sekolah']);

            $table->unsignedBigInteger('humas_id')->nullable();
            $table->unsignedBigInteger('pic_id')->nullable();

            $table->foreign('humas_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pic_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('kepuasan', ['Puas', 'Tidak Puas'])->nullable();

            $table->timestamp('waktu_proses')->nullable();
            $table->timestamp('waktu_close')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
