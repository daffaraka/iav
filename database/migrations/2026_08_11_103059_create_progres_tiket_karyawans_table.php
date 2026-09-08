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
        Schema::create('progres_tiket_karyawans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tiket_karyawan_id');
            $table->unsignedBigInteger('user_id'); // Yang merespon
            $table->text('keterangan');
            $table->string('filename')->nullable();
            $table->timestamps();

            $table->foreign('tiket_karyawan_id')->references('id')->on('tiket_karyawans')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_tiket_karyawans');
    }
};
