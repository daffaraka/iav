<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable = ['task_process_id', 'text', 'completed'];

    protected $casts = [
        'completed' => 'boolean',
    ];

    public function taskProcess()
    {
        return $this->belongsTo(TaskProcess::class);
    }
}
