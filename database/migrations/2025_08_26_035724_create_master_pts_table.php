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
        Schema::create('master_pts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pt');
            $table->string('status_pt')->nullable(); //Swasta or Negeri
            $table->string('lokasi')->nullable(); // Luar negeri atau dalam Negeri
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('alamat')->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->string('jenjang')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('jalur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_ptns');
    }
};
