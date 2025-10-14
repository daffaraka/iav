<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $fillable =
    [
        'nama_dept',
        'deskripsi_dept',
        'koor_id'
    ];


    public function koor()
    {
        return $this->belongsTo(User::class, 'koor_id');
    }

    public function wigs()
    {
        return $this->hasMany(Wig::class);
    }


}
