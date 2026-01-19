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
        Schema::create('aqr_options', function (Blueprint $table) {
            $table->id();
            $table->string('nama_option');
            $table->enum('kategori_pic',['Kepala Sekolah','Kepala TU','BK']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aqr_options');
    }
};
