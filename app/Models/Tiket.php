<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MasterSiswa as Siswa;

class Tiket extends Model
{
     protected $fillable = [
        'nisn',
        'siswa_id',
        'no_hp',
        'nama',
        'nama_orangtua',
        'email',
        'judul_kendala',
        'departemen',

        'lokasi_kendala',
        'detail_kendala',
        'penanganan',
        'status',
        'filename',
        'fotopengerjaan',
        'pengirim',
        'humas_id',
        'pic_id',
        'waktu_proses',
        'waktu_close',
        'kepuasan'
    ];


    public function humas()
    {
        return $this->belongsTo(User::class, 'humas_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }


    public function progres()
    {
        return $this->hasMany(ProgresTiket::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tiket) {
            $tiket->no_tiket = rand(100000, 999999);
            while (static::where('no_tiket', $tiket->no_tiket)->exists()) {
                $tiket->no_tiket = (string) rand(100000, 999999);
            }
        });
    }
}
