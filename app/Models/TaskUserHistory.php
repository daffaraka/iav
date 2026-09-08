<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskUserHistory extends Model
{
    protected $table = 'task_user_histories';

    protected $fillable = ['task_process_id', 'user_id', 'action'];

    public function taskProcess()
    {
        return $this->belongsTo(TaskProcess::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
