<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WigProgress extends Model
{
    protected $fillable = [
        'wig_id',
        'progress_wig',
        'bulan',
        // 'user_id'
    ];

    public function wig()
    {
        return $this->belongsTo(Wig::class);
    }

   

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
