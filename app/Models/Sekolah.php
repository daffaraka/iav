<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'unit',
        'jenjang',
    ];

    public function siswas()
    {
        return $this->hasMany(MasterSiswa::class);
    }
}
