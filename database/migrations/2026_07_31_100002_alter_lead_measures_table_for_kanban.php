<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lead_measures', function (Blueprint $table) {
            $table->dropColumn(['satuan', 'target']);
            $table->foreignId('kategori_program_id')->nullable()->after('deskripsi_lead')->constrained('kategori_program_kerjas')->nullOnDelete();
            $table->text('kondisi_aktual')->nullable()->after('kategori_program_id');
            $table->text('target_akhir_tahun')->nullable()->after('kondisi_aktual');
            $table->text('output_akhir')->nullable()->after('target_akhir_tahun');
            $table->string('prioritas')->nullable()->after('output_akhir');
            $table->decimal('bobot_board', 8, 2)->default(0)->after('prioritas');
        });
    }

    public function down(): void
    {
        Schema::table('lead_measures', function (Blueprint $table) {
            $table->dropForeign(['kategori_program_id']);
            $table->dropColumn([
                'kategori_program_id',
                'kondisi_aktual',
                'target_akhir_tahun',
                'output_akhir',
                'prioritas',
                'bobot_board'
            ]);
            $table->string('satuan')->nullable();
            $table->string('target')->nullable();
        });
    }
};
