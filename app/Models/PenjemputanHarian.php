<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjemputanHarian extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->belongsTo(MasterSiswa::class, 'master_siswa_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}
