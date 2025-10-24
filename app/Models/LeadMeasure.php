<?php

namespace App\Models;

use App\Models\TaskProcess;
use Illuminate\Database\Eloquent\Model;

class LeadMeasure extends Model
{
    protected $fillable = [
        'wig_id',
        'judul_lead',
        'deskripsi_lead',
        'target',
        'satuan',
        'status',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    public function wig()
    {
        return $this->belongsTo(Wig::class);
    }

    public function tasks()
    {
        return $this->hasMany(TaskProcess::class);
    }
}
