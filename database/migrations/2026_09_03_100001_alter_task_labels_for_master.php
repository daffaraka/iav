<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('task_labels');

        Schema::create('task_labels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_process_id')->constrained('task_processes')->cascadeOnDelete();
            $table->foreignId('master_label_id')->constrained('master_labels')->cascadeOnDelete();
            $table->unique(['task_process_id', 'master_label_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_labels');

        Schema::create('task_labels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_process_id')->constrained('task_processes')->cascadeOnDelete();
            $table->string('label_id');
            $table->unique(['task_process_id', 'label_id']);
            $table->timestamps();
        });
    }
};
