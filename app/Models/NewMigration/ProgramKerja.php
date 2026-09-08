<?php
namespace App\Models\NewMigration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramKerja extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function kategori() { return $this->belongsTo(\App\Models\KategoriProgramKerja::class, 'kategori_program_id'); }
    public function departement() { return $this->belongsTo(\App\Models\Departement::class); }
    public function pic() { return $this->belongsTo(\App\Models\User::class, 'pic_id'); }
    public function boards() { return $this->morphMany(Board::class, 'boardable'); }
}
