<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WigHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'riwayat_wig',
        'realisasi',
        'tanggal',
        'lampiran',
        'wig_id',
        'user_id'
    ];


    public function wig()
    {
        return $this->belongsTo(Wig::class, 'wig_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
