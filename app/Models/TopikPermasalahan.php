<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopikPermasalahan extends Model
{
    protected $fillable = [
        'nama_topik',
        'aqr_option_id',
        'tiket_id',
    ];

    public function aqrOption()
    {
        return $this->belongsTo(AqrOption::class, 'aqr_option_id');
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'tiket_id');
    }
}
