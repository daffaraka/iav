<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresTiket extends Model
{
    protected $fillable = [
        'penanganan',
        'status',
        'fotopengerjaan',
        // 'direspon_at',
        'tiket_id',
    ];


    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }
}
