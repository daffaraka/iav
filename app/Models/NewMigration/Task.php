<?php

namespace App\Models\NewMigration;

use App\Models\Departement;
use App\Models\TaskUserHistory;
use App\Models\TaskWeight;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    protected $casts = [
        'request_date' => 'date',
        'due_date' => 'date',
        'new_date' => 'datetime',
        'proses_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function board()
    {
        return $this->belongsTo(Board::class);
    }
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function labels()
    {
        return $this->hasMany(TaskLabel::class);
    }
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'task_user', 'task_id', 'user_id');
    }
    public function histories()
    {
        return $this->hasMany(TaskUserHistory::class)->orderBy('created_at', 'desc');
    }
    public function taskWeight()
    {
        return $this->belongsTo(TaskWeight::class, 'priority', 'level');
    }
}
