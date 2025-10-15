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
        Schema::create('wigs', function (Blueprint $table) {
            $table->id();
            $table->string('judul_wig')->unique();
            $table->string('deskripsi_wig');
            $table->date('tanggal_mulai_wig');
            $table->date('tanggal_berakhir_wig');
            $table->string('unit_wig');
            $table->integer('from_x');
            $table->integer('to_y');
            $table->enum('status_wig', [0, 1, 2,])->default(1)->comment('1 aktif, 2 selesai, 0 tidak aktif');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('departement_id')->constrained('departements')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wigs');
    }
};
