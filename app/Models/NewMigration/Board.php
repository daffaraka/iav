<?php
namespace App\Models\NewMigration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $appends = ['score'];

    public function getScoreAttribute()
    {
        // Prevent N+1 lazy-loading
        if (!$this->relationLoaded('tasks')) return 0;
        $tasks = $this->getRelation('tasks');
        if (!$tasks || $tasks->isEmpty()) return 0;

        $maxScore = 0;
        $completedScore = 0;

        foreach ($tasks as $task) {
            $weight = 0;
            if ($task->priority === 'low') $weight = 1;
            elseif ($task->priority === 'medium') $weight = 3;
            elseif ($task->priority === 'high') $weight = 5;

            $maxScore += $weight;
            
            if ($task->column_id === 'done') {
                $completedScore += $weight;
            }
        }

        if ($maxScore == 0) return 0;

        $score = ($completedScore / $maxScore) * ($this->bobot_board ?? 0);
        return round($score, 2);
    }

    public function boardable() { return $this->morphTo(); }
    public function tasks() { return $this->hasMany(Task::class); }
    public function pic() { return $this->belongsTo(\App\Models\User::class, 'pic_id'); }
    public function departement() { return $this->belongsTo(\App\Models\Departement::class, 'departement_id'); }
}
