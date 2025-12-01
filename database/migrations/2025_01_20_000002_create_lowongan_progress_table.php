<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lowongan_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lowongan_apply_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Pending', 'Review', 'Interview', 'Diterima', 'Ditolak']);
            $table->text('keterangan')->nullable();
            $table->date('tanggal_progress');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lowongan_progress');
    }
};