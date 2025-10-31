<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPtn extends Model
{
    protected $fillable = [
        'nama_pt',
        'status_pt',
        'lokasi',
        'provinsi',
        'kota',
        'alamat',
        'tahun_ajaran',
        'jenjang',
        'fakultas',
        'jurusan',
        'jalur'
    ];
}
