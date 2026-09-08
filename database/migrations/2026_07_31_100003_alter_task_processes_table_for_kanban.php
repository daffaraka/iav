<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_processes', function (Blueprint $table) {
            $table->string('document_link')->nullable()->after('dokumen');
            $table->foreignId('pic_id')->nullable()->after('lead_measure_id')->constrained('users')->nullOnDelete();
            $table->foreignId('departement_id')->nullable()->after('pic_id')->constrained('departements')->nullOnDelete();
            $table->date('request_date')->nullable()->after('tanggal_realisasi');
            $table->date('due_date')->nullable()->after('request_date');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low')->after('due_date');
            $table->enum('column_id', ['new', 'progress', 'done'])->default('new')->after('priority');
            $table->integer('position')->default(0)->after('column_id');
            $table->timestamp('new_date')->nullable()->after('position');
            $table->timestamp('proses_date')->nullable()->after('new_date');
            $table->timestamp('end_date')->nullable()->after('proses_date');
        });
    }

    public function down(): void
    {
        Schema::table('task_processes', function (Blueprint $table) {
            $table->dropForeign(['pic_id']);
            $table->dropForeign(['departement_id']);
            $table->dropColumn([
                'document_link',
                'pic_id',
                'departement_id',
                'request_date',
                'due_date',
                'priority',
                'column_id',
                'position',
                'new_date',
                'proses_date',
                'end_date'
            ]);
        });
    }
};
