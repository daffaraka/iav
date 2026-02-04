<?php

namespace Database\Seeders;

use App\Models\MasterPt;
use Illuminate\Database\Seeder;

class TopUniversitasSeeder extends Seeder
{
    public function run(): void
    {
        $universities = [
            ['nama_pt' => 'Universitas Indonesia', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'DKI Jakarta', 'kota' => 'Depok'],
            ['nama_pt' => 'Institut Teknologi Bandung', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Barat', 'kota' => 'Bandung'],
            ['nama_pt' => 'Universitas Gadjah Mada', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'DI Yogyakarta', 'kota' => 'Yogyakarta'],
            ['nama_pt' => 'Institut Pertanian Bogor', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Barat', 'kota' => 'Bogor'],
            ['nama_pt' => 'Universitas Airlangga', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Surabaya'],
            ['nama_pt' => 'Institut Teknologi Sepuluh Nopember', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Surabaya'],
            ['nama_pt' => 'Universitas Padjadjaran', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Barat', 'kota' => 'Bandung'],
            ['nama_pt' => 'Universitas Diponegoro', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Tengah', 'kota' => 'Semarang'],
            ['nama_pt' => 'Universitas Brawijaya', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Malang'],
            ['nama_pt' => 'Universitas Sebelas Maret', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Tengah', 'kota' => 'Surakarta'],
        ];

        foreach ($universities as $univ) {
            MasterPt::create($univ);
        }
    }
}
