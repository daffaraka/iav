<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop old Kanban pivot/child tables safely
        Schema::dropIfExists('task_labels');
        Schema::dropIfExists('checklists');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('task_process_user');
        Schema::dropIfExists('task_user_histories');

        // 2. Revert task_processes
        if (Schema::hasTable('task_processes')) {
            Schema::table('task_processes', function (Blueprint $table) {
                if (Schema::hasColumn('task_processes', 'document_link')) {
                    $table->dropColumn([
                        'document_link', 'request_date', 
                        'due_date', 'priority', 'column_id', 'position', 
                        'new_date', 'proses_date', 'end_date'
                    ]);
                }
                
                // Drop foreign keys if they exist
                // Just use hasColumn to check
                
                // Usually easier to just catch exceptions or check index
                // but checking hasColumn is enough to know if we should drop FK in some cases
                if (Schema::hasColumn('task_processes', 'pic_id')) {
                    $table->dropForeign(['pic_id']);
                    $table->dropColumn('pic_id');
                }
                if (Schema::hasColumn('task_processes', 'departement_id')) {
                    $table->dropForeign(['departement_id']);
                    $table->dropColumn('departement_id');
                }
            });
        }

        // 3. Revert lead_measures
        if (Schema::hasTable('lead_measures')) {
            Schema::table('lead_measures', function (Blueprint $table) {
                if (Schema::hasColumn('lead_measures', 'kategori_program_id')) {
                    $table->dropForeign(['kategori_program_id']);
                    $table->dropColumn('kategori_program_id');
                }
                
                $dropCols = [];
                foreach (['kondisi_aktual', 'target_akhir_tahun', 'output_akhir', 'prioritas', 'bobot_board'] as $col) {
                    if (Schema::hasColumn('lead_measures', $col)) {
                        $dropCols[] = $col;
                    }
                }
                if (count($dropCols) > 0) {
                    $table->dropColumn($dropCols);
                }

                if (!Schema::hasColumn('lead_measures', 'satuan')) {
                    $table->string('satuan')->nullable();
                }
                if (!Schema::hasColumn('lead_measures', 'target')) {
                    $table->string('target')->nullable();
                }
            });
        }

        // 4. Revert wigs
        if (Schema::hasTable('wigs')) {
            Schema::table('wigs', function (Blueprint $table) {
                if (Schema::hasColumn('wigs', 'bobot_kpi')) {
                    $table->dropColumn('bobot_kpi');
                }
                if (!Schema::hasColumn('wigs', 'from_x')) {
                    $table->string('from_x')->nullable();
                }
                if (!Schema::hasColumn('wigs', 'to_y')) {
                    $table->string('to_y')->nullable();
                }
                if (!Schema::hasColumn('wigs', 'unit_wig')) {
                    $table->string('unit_wig')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // 
    }
};
