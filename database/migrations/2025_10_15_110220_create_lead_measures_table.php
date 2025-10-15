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
         Schema::create('lead_measures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wig_id')->constrained('wigs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('judul_lead', 150);
            $table->text('deskripsi_lead')->nullable();
            $table->integer('target')->nullable();
            $table->string('satuan', 50)->nullable();
            $table->tinyInteger('status')->comment('0 = tidak aktif, 1 = aktif, 2 = selesai,3 = review')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_measures');
    }
};
