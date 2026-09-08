<?php

namespace App\Models\NewMigration;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Departement;
use App\Models\Checklist;
use App\Models\TaskLabel;
use App\Models\Comment;
use App\Models\TaskUserHistory;

class TaskProcess extends Model
{
    protected $table = 'task_processes';

    protected $fillable = [
        'lead_measure_id',
        'nama_tugas',
        'deskripsi',
        'jumlah_realisasi',
        'dokumen',
        'status_tugas',
        'tanggal_realisasi',
        'document_link',
        'pic_id',
        'departement_id',
        'request_date',
        'due_date',
        'priority',
        'column_id',
        'position',
        'new_date',
        'proses_date',
        'end_date'
    ];

    protected $casts = [
        'request_date' => 'date',
        'due_date' => 'date',
        'new_date' => 'datetime',
        'proses_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function leadMeasure()
    {
        return $this->belongsTo(LeadMeasure::class);
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
        return $this->hasMany(Checklist::class, 'task_process_id');
    }

    public function labels()
    {
        return $this->hasMany(TaskLabel::class, 'task_process_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'task_process_id');
    }

    public function histories()
    {
        return $this->hasMany(TaskUserHistory::class, 'task_process_id');
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'task_process_user');
    }
}
