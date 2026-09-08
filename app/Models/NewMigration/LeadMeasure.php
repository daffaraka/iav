<?php

namespace App\Models\NewMigration;

use Illuminate\Database\Eloquent\Model;
use App\Models\KategoriProgramKerja;

class LeadMeasure extends Model
{
    protected $table = 'lead_measures';

    protected $fillable = [
        'wig_id',
        'judul_lead',
        'deskripsi_lead',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'kategori_program_id',
        'kondisi_aktual',
        'target_akhir_tahun',
        'output_akhir',
        'prioritas',
        'bobot_board'
    ];

    protected $casts = [
        'bobot_board' => 'decimal:2',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function wig()
    {
        return $this->belongsTo(Wig::class);
    }

    public function kategoriProgram()
    {
        return $this->belongsTo(KategoriProgramKerja::class, 'kategori_program_id');
    }

    public function taskProcesses()
    {
        return $this->hasMany(TaskProcess::class, 'lead_measure_id');
    }

    public function getScoreAttribute()
    {
        $taskWeights = [
            'low' => 1,
            'medium' => 3,
            'high' => 5,
        ];

        $tasks = $this->taskProcesses;
        
        $totalWeight = 0;
        $completedWeight = 0;

        foreach ($tasks as $task) {
            $weight = $taskWeights[strtolower($task->priority)] ?? 1;
            $totalWeight += $weight;
            if (strtolower($task->status_tugas) === 'completed' || strtolower($task->status_tugas) === 'done') {
                $completedWeight += $weight;
            }
        }

        if ($totalWeight == 0) {
            return 0;
        }

        return ($completedWeight / $totalWeight) * $this->bobot_board;
    }
}
