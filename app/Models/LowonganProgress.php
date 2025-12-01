<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LowonganProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'lowongan_apply_id',
        'status',
        'keterangan',
        'tanggal_progress'
    ];

    protected $casts = [
        'tanggal_progress' => 'date'
    ];

    public function lowonganApply()
    {
        return $this->belongsTo(LowonganApply::class);
    }
}