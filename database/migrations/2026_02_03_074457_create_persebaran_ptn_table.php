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
        Schema::create('persebaran_pts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_ptn_id');
            $table->string('fakultas')->nullable();
            $table->string('jurusan')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('starta')->nullable();
            $table->string('akreditasi')->nullable();
            $table->string('jalur_masuk')->nullable();

            $table->foreign('master_ptn_id')->references('id')->on('master_ptns')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persebaran_ptns');
    }
};
