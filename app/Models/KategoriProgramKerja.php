<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProgramKerja extends Model
{
    protected $fillable = ['name'];

    public function leadMeasures()
    {
        return $this->hasMany(LeadMeasure::class);
    }
}
