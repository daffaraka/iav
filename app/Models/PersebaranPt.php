<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersebaranPt extends Model
{

    protected $fillable = [
        'master_ptn_id',
        'fakultas',
        'jurusan',
        'program_studi',
        'starta',
        'akreditasi',
        'jalur_masuk'
    ];

    public function ptn()
    {
        return $this->belongsTo(MasterPtn::class, 'master_ptn_id');
    }
}
