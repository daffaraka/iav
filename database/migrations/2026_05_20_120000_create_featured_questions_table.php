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
        Schema::create('featured_questions', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('jawaban');
            $table->string('kategori');
            $table->unsignedBigInteger('tiket_id')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_published')->default(false);
            $table->integer('view_count')->default(0);
            $table->integer('vote_count')->default(0);
            $table->integer('order')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('tiket_id')->references('id')->on('tikets')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_questions');
    }
};
