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
        Schema::create('wig_histories', function (Blueprint $table) {
            $table->id();
            $table->string('riwayat_wig');
            $table->integer('realisasi')->default(0);
            $table->date('tanggal');
            $table->string('lampiran')->nullable();

            $table->foreignId('wig_id')->constrained('wigs')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wig_histories');
    }
};
