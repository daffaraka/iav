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
        Schema::create('progres_tikets', function (Blueprint $table) {
            $table->id();
            // $table->string('progres');
            $table->string('penanganan')->nullable();
            $table->string('status');
            $table->string('fotopengerjaan')->nullable();
            // $table->dateTime('direspon_at')->nullable();

            $table->foreignId('tiket_id')->constrained('tikets')->onDelete('cascade'); //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_tikets');
    }
};
