<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPrestasiGuru extends Model
{
    protected $table = 'master_prestasi_guru';

    protected $fillable = [
        'tahun_pelajaran',
        'tanggal_pelaksanaan_lomba',
        'user_id',
        'nama_lomba',
        'jenis_lomba',
        'mata_bidang_lomba',
        'raihan_prestasi',
        'tanggal_perolehan_lomba',
        'penyelenggara',
        'level_lomba',
        'tahapan_lomba',
        'kategori_lomba',
        'status_kurasi',
        'lanjutan_status_kurasi',
        'created_by'
    ];

    protected $casts = [
        'tanggal_pelaksanaan_lomba' => 'date',
        'tanggal_perolehan_lomba' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
