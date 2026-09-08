<?php

namespace App\Models\NewMigration;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Departement;
use App\Models\WigProgress;

class Wig extends Model
{
    use SoftDeletes;

    protected $table = 'wigs';

    protected $fillable = [
        'judul_wig',
        'deskripsi_wig',
        'tanggal_mulai_wig',
        'tanggal_berakhir_wig',
        'status_wig',
        'departement_id',
        'user_id',
        'bobot_kpi'
    ];

    protected $casts = [
        'bobot_kpi' => 'decimal:2',
        'tanggal_mulai_wig' => 'date',
        'tanggal_berakhir_wig' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    public function lead_measures()
    {
        return $this->hasMany(LeadMeasure::class, 'wig_id');
    }

    public function wig_progresses()
    {
        return $this->hasMany(WigProgress::class);
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deleted_by_user()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
            }
        });

        static::deleting(function ($model) {
            if (auth()->check()) {
                $model->deleted_by = auth()->id();
                $model->save();
            }
        });
    }

    public function getScoreAttribute()
    {
        return $this->lead_measures->sum('score');
    }
}
