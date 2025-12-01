<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LowonganApply extends Model
{
    use HasFactory;

    protected $fillable = [
        'lowongan_pekerjaan_id',
        'nama_pelamar',
        'email_pelamar',
        'phone_pelamar',
        'alamat_pelamar',
        'cv_file',
        'cover_letter',
        'status',
        'catatan'
    ];

    public function lowonganPekerjaan()
    {
        return $this->belongsTo(LowonganPekerjaan::class);
    }

    public function progress()
    {
        return $this->hasMany(LowonganProgress::class);
    }

    public function latestProgress()
    {
        return $this->hasOne(LowonganProgress::class)->latest();
    }
}