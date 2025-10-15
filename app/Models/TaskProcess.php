<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskProcess extends Model
{
    protected $fillable = [
        'lead_measure_id',
        'nama_tugas',
        'deskripsi',
        'jumlah_realisasi',
        'dokumen',
        'tanggal_realisasi'
    ];

    public function lead_measure()
    {
        return $this->belongsTo(LeadMeasure::class);
    }
}
