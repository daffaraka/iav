<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wig extends Model
{
    protected $fillable = [
        'judul_wig',
        'deskripsi_wig',
        'tanggal_mulai_wig',
        'tanggal_berakhir_wig',
        'unit_wig',
        'created_by',
        'deleted_by',
    ];

    public function deleted_by()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id;
        });

        static::deleting(function ($model) {
            $model->deleted_by = auth()->user()->id;
        });
    }
}
