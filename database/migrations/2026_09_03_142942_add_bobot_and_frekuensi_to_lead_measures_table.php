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
        Schema::table('lead_measures', function (Blueprint $table) {
            $table->integer('bobot_persentase')->default(0)->after('bobot_board');
            $table->string('frekuensi', 50)->default('bebas')->after('bobot_persentase');
            $table->integer('target')->default(0)->after('frekuensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lead_measures', function (Blueprint $table) {
            $table->dropColumn(['bobot_persentase', 'frekuensi', 'target']);
        });
    }
};
