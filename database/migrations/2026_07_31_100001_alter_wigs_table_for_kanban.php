<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wigs', function (Blueprint $table) {
            $table->dropColumn(['from_x', 'to_y', 'unit_wig']);
            $table->decimal('bobot_kpi', 8, 2)->default(100)->after('status_wig');
        });
    }

    public function down(): void
    {
        Schema::table('wigs', function (Blueprint $table) {
            $table->dropColumn('bobot_kpi');
            $table->string('from_x')->nullable();
            $table->string('to_y')->nullable();
            $table->string('unit_wig')->nullable();
        });
    }
};
