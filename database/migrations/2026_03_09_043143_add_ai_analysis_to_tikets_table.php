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
        Schema::table('tikets', function (Blueprint $table) {
            $table->string('ai_kategori')->nullable()->after('lokasi_sekolah');
            $table->string('ai_sub_kategori')->nullable()->after('ai_kategori');
            $table->string('ai_prioritas')->nullable()->after('ai_sub_kategori');
            $table->string('ai_sentiment')->nullable()->after('ai_prioritas');
            $table->text('ai_ringkasan')->nullable()->after('ai_sentiment');
            $table->timestamp('ai_analyzed_at')->nullable()->after('ai_ringkasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            $table->dropColumn(['ai_kategori', 'ai_sub_kategori', 'ai_prioritas', 'ai_sentiment', 'ai_ringkasan', 'ai_analyzed_at']);
        });
    }
};
