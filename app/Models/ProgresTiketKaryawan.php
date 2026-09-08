<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresTiketKaryawan extends Model
{
    protected $table = 'progres_tiket_karyawans';
    protected $fillable = [
        'tiket_karyawan_id',
        'user_id',
        'keterangan',
        'filename'
    ];

    public function tiket()
    {
        return $this->belongsTo(TiketKaryawan::class, 'tiket_karyawan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
