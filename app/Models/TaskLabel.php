<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NewMigration\TaskProcess;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskLabel extends Model
{
    protected $fillable = ['task_process_id', 'master_label_id'];

    public function taskProcess(): BelongsTo
    {
        return $this->belongsTo(TaskProcess::class);
    }

    public function masterLabel(): BelongsTo
    {
        return $this->belongsTo(MasterLabel::class);
    }
}
