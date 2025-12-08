<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tiket extends Model
{
    protected $fillable = [
        'nisn', 'no_tiket', 'no_hp', 'nama', 'nama_orangtua', 'email',
        'judul_kendala', 'departemen', 'lokasi_kendala', 'detail_kendala',
        'status', 'filename', 'pengirim', 'humas_id', 'pic_id', 'siswa_id',
        'kepuasan', 'rating', 'deskripsi_penilaian', 'lokasi_sekolah',
        'waktu_proses', 'waktu_close'
    ];

    protected $casts = [
        'waktu_proses' => 'datetime',
        'waktu_close' => 'datetime',
        'rating' => 'integer'
    ];

    public function humas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'humas_id');
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(MasterSiswa::class, 'siswa_id');
    }

    public function progres()
    {
        return $this->hasMany(ProgresTiket::class);
    }

    public function getAutoAssignedTU()
    {
        $tuMapping = [
            'Cinere' => ['AVI-0052', 'AVI-0085'], // Ahmad Kamal, Atih Rismawati
            'Jagakarsa' => ['AVI-0054', 'AVI-0291'], // Ahmad Nadir, Rosaulina
            'Pamulang' => ['AVI-0438', 'AVI-0184'] // Raden Windya, Eni Dwinanti
        ];

        if (isset($tuMapping[$this->lokasi_sekolah])) {
            return User::whereIn('employee_code', $tuMapping[$this->lokasi_sekolah])
                      ->whereHas('roles', function($q) {
                          $q->where('name', 'tu');
                      })->first();
        }

        return null;
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
