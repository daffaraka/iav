<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Projects Table (For WIG Main Project Tab)
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['wig', 'program_kerja'])->default('wig');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('departement_id')->nullable()->constrained('departements')->nullOnDelete();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('target_date')->nullable();
            $table->decimal('bobot', 8, 2)->default(100);
            $table->enum('status', ['active', 'completed', 'archived'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Program Kerjas Table (Independent from Projects)
        Schema::create('program_kerjas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_program_id')->nullable()->constrained('kategori_program_kerjas')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('departement_id')->nullable()->constrained('departements')->nullOnDelete();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('target_date')->nullable();
            $table->decimal('bobot', 8, 2)->default(100);
            $table->enum('status', ['active', 'completed', 'archived'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Boards Table (Polymorphic, can belong to Project or ProgramKerja)
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->morphs('boardable'); // Creates boardable_type and boardable_id
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('departement_id')->nullable()->constrained('departements')->nullOnDelete();
            $table->date('start_date')->nullable();
            $table->date('target_date')->nullable();
            $table->text('kondisi_aktual')->nullable();
            $table->text('target_akhir_tahun')->nullable();
            $table->text('output_akhir')->nullable();
            $table->string('prioritas')->nullable();
            $table->decimal('bobot_board', 8, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Tasks Table
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained('boards')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('document_link')->nullable();
            $table->string('attachment')->nullable();
            $table->foreignId('pic_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('departement_id')->nullable()->constrained('departements')->nullOnDelete();
            $table->date('request_date')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->enum('column_id', ['todo', 'progress', 'done'])->default('todo');
            $table->integer('position')->default(0);
            $table->timestamp('new_date')->nullable();
            $table->timestamp('proses_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. Checklists
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->string('text');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });

        // 6. Comments
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('text');
            $table->timestamps();
        });

        // 7. Task Labels (pivot to master_labels)
        Schema::create('task_labels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('master_label_id')->constrained('master_labels')->cascadeOnDelete();
            $table->unique(['task_id', 'master_label_id']);
            $table->timestamps();
        });

        // 8. Task Users (collaborators)
        Schema::create('task_user', function (Blueprint $table) {
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['task_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_user');
        Schema::dropIfExists('task_labels');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('checklists');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('boards');
        Schema::dropIfExists('program_kerjas');
        Schema::dropIfExists('projects');
    }
};
