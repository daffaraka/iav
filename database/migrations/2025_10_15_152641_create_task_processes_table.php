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
        Schema::create('task_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_measure_id')->constrained('lead_measures')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_tugas', 150);
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah_realisasi')->nullable();
            $table->string('dokumen')->nullable();
            $table->date('tanggal_realisasi')->default(date('Y-m-d'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_processes');
    }
};
