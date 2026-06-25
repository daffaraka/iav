<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersebaranPt extends Model
{

    protected $fillable = [
        'pt_id',
        'siswa_id',
        'fakultas',
        'jurusan',
        'rumpun_ilmu',
        'program_studi',
        'starta',
        'akreditasi',
        'jalur_masuk'
    ];

    public function ptn()
    {
        return $this->belongsTo(MasterPt::class, 'pt_id');
    }

    public function siswa()
    {
        return $this->belongsTo(MasterSiswa::class, 'siswa_id');
    }
}
