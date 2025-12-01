<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LowonganPekerjaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul_lowongan',
        'perusahaan',
        'deskripsi',
        'lokasi',
        'jenis_pekerjaan',
        'gaji_min',
        'gaji_max',
        'persyaratan',
        'tanggal_tutup',
        'status',
        'kontak_email',
        'kontak_phone'
    ];

    protected $casts = [
        'tanggal_tutup' => 'date'
    ];

    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif')->where('tanggal_tutup', '>=', now());
    }

    public function applies()
    {
        return $this->hasMany(LowonganApply::class);
    }
}