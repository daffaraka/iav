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
        Schema::create('topik_permasalahans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_topik');
            $table->unsignedBigInteger('aqr_option_id');
            $table->unsignedBigInteger('tiket_id');

            $table->foreign('aqr_option_id')->references('id')->on('aqr_options')->cascadeOnDelete();
            $table->foreign('tiket_id')->references('id')->on('tikets')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topik_permasalahans');
    }
};
