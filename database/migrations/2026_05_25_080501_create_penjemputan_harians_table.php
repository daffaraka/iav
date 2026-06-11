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
        Schema::create('penjemputan_harians', function (Blueprint $table) {
            $table->id();
            // Changed from siswa_id to master_siswa_id because of our relation change
            $table->foreignId('master_siswa_id')->constrained('master_siswas')->onDelete('cascade');
            $table->foreignId('pic_id')->nullable();
            $table->string('nama_penjemput')->nullable();

            $table->string('type_ojol')->nullable();
            $table->string('nama_ojol')->nullable();
            $table->string('plat_ojol')->nullable();

            $table->dateTime('waktu_dijemput')->nullable();
            $table->dateTime('confirm_pic_at')->nullable();
            $table->dateTime('confirm_satpam_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjemputan_harians');
    }
};
