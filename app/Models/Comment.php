<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['task_process_id', 'user_id', 'text'];

    public function taskProcess()
    {
        return $this->belongsTo(TaskProcess::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
