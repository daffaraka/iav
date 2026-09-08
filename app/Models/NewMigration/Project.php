<?php

namespace App\Models\NewMigration;

use App\Models\Departement;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
    public function pic()
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
    public function boards()
    {
        return $this->morphMany(Board::class, 'boardable');
    }
}
