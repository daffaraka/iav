<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('task_process_user', function (Blueprint $table) {
            $table->foreignId('task_process_id')->constrained('task_processes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['task_process_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_process_user');
    }
};
