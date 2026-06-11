<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPrestasi extends Model
{


    protected $fillable = [
        'master_siswa_id',
        'sekolah_id',
        'nama_lomba',
        'penyelenggara_lomba',
        'tingkat_lomba',
        'status_lomba',
        'tahun_pelajaran',
        'lokasi',
        'tanggal_pelaksanaan',
        'keterangan',
        'kategori_lomba',
        'tipe_lomba',
        'guru_eskul',
        'guru_pendamping',
    ];

    public function masterSiswa()
    {
        return $this->belongsTo(MasterSiswa::class);
    }

    public function siswa()
    {
        return $this->belongsTo(MasterSiswa::class, 'master_siswa_id');
    }

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }
}
