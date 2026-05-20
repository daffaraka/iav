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
        Schema::create('fq_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('featured_question_id')->constrained('featured_questions')->onDelete('cascade');
            $table->string('visitor_id', 36);
            $table->string('ip_address')->nullable();
            $table->timestamp('clicked_at');
            $table->timestamps();

            $table->unique(['featured_question_id', 'visitor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fq_interactions');
    }
};
