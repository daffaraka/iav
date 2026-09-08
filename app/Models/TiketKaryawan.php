<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketKaryawan extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'no_tiket',
        'user_id',
        'judul_kendala',
        'departemen',
        'masalah_dept',
        'lokasi_kendala',
        'detail_kendala',
        'status',
        'filename',
        'admin_id',
        'pic_id',
        'kepuasan',
        'rating',
        'deskripsi_penilaian',
        'waktu_proses',
        'waktu_close'
    ];

    protected $casts = [
        'waktu_proses' => 'datetime',
        'waktu_close' => 'datetime',
        'rating' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function progres()
    {
        return $this->hasMany(ProgresTiketKaryawan::class, 'tiket_karyawan_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tiket) {
            $tiket->no_tiket = 'EMP-' . rand(100000, 999999);
            while (static::where('no_tiket', $tiket->no_tiket)->exists()) {
                $tiket->no_tiket = 'EMP-' . rand(100000, 999999);
            }
        });
    }
}
