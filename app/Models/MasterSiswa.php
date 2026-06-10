<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterSiswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'nama_orang_tua',
        'nama_ayah',
        'nama_ibu',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'tahun_ajaran',
        'nisn',
        'nis',
        'jenjang',
        'kelas',
        'sub_kelas',
        'angkatan',
        'jurusan',
        'status',
        'foto',
        'asal_sekolah',
        'sekolah_id',
    ];


    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function penjemputan()
    {
        return $this->hasMany(PenjemputanHarian::class, 'master_siswa_id');
    }

}
