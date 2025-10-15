<?php

namespace App\Models;

use App\Models\LeadMeasure;
use Illuminate\Database\Eloquent\Model;

class Wig extends Model
{
    protected $fillable = [
        'judul_wig',
        'deskripsi_wig',
        'tanggal_mulai_wig',
        'tanggal_berakhir_wig',
        'unit_wig',
        'from_x',
        'to_y',
        'status_wig',
        'department_id',
    ];

    public function deleted_by()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function deptartement()
    {
        return $this->belongsTo(Departement::class, 'department_id');
    }


    public function lead_measures()
    {
        return $this->hasMany(LeadMeasure::class);
    }


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->user()->id ?? null;
        });

        static::deleting(function ($model) {
            $model->deleted_by = auth()->user()->id ?? null;
        });
    }
}
