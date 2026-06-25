<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPrestasiSiswa extends Model
{
    protected $table = 'master_prestasi_siswa';

    protected $fillable = [
        'tahun_pelajaran',
        'tanggal_pelaksanaan_lomba',
        'nama_siswa',
        'kelas',
        'wilayah',
        'nama_lomba',
        'jenis_lomba',
        'mata_bidang_lomba',
        'raihan_prestasi',
        'tanggal_perolehan_lomba',
        'penyelenggara',
        'level_lomba',
        'nama_pelatih',
        'nama_pembina',
        'tahapan_lomba',
        'kategori_lomba',
        'status_kurasi',
        'lanjutan_status_kurasi',
        'created_by'
    ];

    protected $casts = [
        'nama_pelatih' => 'array',
        'nama_pembina' => 'array',
        'tanggal_pelaksanaan_lomba' => 'date',
        'tanggal_perolehan_lomba' => 'date',
    ];
}
