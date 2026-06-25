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
        Schema::table('persebaran_pts', function (Blueprint $table) {
            $table->enum('rumpun_ilmu', ['Saintek', 'Soshum', 'Campuran'])->nullable()->after('jurusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('persebaran_pts', function (Blueprint $table) {
            $table->dropColumn('rumpun_ilmu');
        });
    }
};
