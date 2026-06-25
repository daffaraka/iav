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
            ['nama_pt' => 'Universitas Padjadjaran', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Barat', 'kota' => 'Sumedang'],
            ['nama_pt' => 'Universitas Diponegoro', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Tengah', 'kota' => 'Semarang'],
            ['nama_pt' => 'Universitas Brawijaya', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Malang'],
            ['nama_pt' => 'Universitas Sebelas Maret', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Tengah', 'kota' => 'Surakarta'],
            
            // PTN Terkenal Lainnya
            ['nama_pt' => 'Universitas Hasanuddin', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Sulawesi Selatan', 'kota' => 'Makassar'],
            ['nama_pt' => 'Universitas Sumatera Utara', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Sumatera Utara', 'kota' => 'Medan'],
            ['nama_pt' => 'Universitas Andalas', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Sumatera Barat', 'kota' => 'Padang'],
            ['nama_pt' => 'Universitas Sriwijaya', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Sumatera Selatan', 'kota' => 'Palembang'],
            ['nama_pt' => 'Universitas Syiah Kuala', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Aceh', 'kota' => 'Banda Aceh'],
            ['nama_pt' => 'Universitas Riau', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Riau', 'kota' => 'Pekanbaru'],
            ['nama_pt' => 'Universitas Lampung', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Lampung', 'kota' => 'Bandar Lampung'],
            ['nama_pt' => 'Universitas Jenderal Soedirman', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Tengah', 'kota' => 'Purwokerto'],
            ['nama_pt' => 'Universitas Negeri Yogyakarta', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'DI Yogyakarta', 'kota' => 'Yogyakarta'],
            ['nama_pt' => 'Universitas Negeri Malang', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Malang'],
            ['nama_pt' => 'Universitas Negeri Semarang', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Tengah', 'kota' => 'Semarang'],
            ['nama_pt' => 'Universitas Negeri Jakarta', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'DKI Jakarta', 'kota' => 'Jakarta'],
            ['nama_pt' => 'Universitas Negeri Surabaya', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Surabaya'],
            ['nama_pt' => 'Universitas Pendidikan Indonesia', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Barat', 'kota' => 'Bandung'],
            ['nama_pt' => 'Universitas Jember', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Jember'],
            ['nama_pt' => 'UPN Veteran Jawa Timur', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Surabaya'],
            ['nama_pt' => 'UPN Veteran Jakarta', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'DKI Jakarta', 'kota' => 'Jakarta'],
            ['nama_pt' => 'UPN Veteran Yogyakarta', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'DI Yogyakarta', 'kota' => 'Yogyakarta'],
            ['nama_pt' => 'Universitas Udayana', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Bali', 'kota' => 'Denpasar'],
            ['nama_pt' => 'Universitas Mataram', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Nusa Tenggara Barat', 'kota' => 'Mataram'],
            ['nama_pt' => 'Universitas Mulawarman', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Kalimantan Timur', 'kota' => 'Samarinda'],
            ['nama_pt' => 'Universitas Tanjungpura', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Kalimantan Barat', 'kota' => 'Pontianak'],
            ['nama_pt' => 'Universitas Lambung Mangkurat', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Kalimantan Selatan', 'kota' => 'Banjarmasin'],
            ['nama_pt' => 'Universitas Sam Ratulangi', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Sulawesi Utara', 'kota' => 'Manado'],
            ['nama_pt' => 'Universitas Pattimura', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Maluku', 'kota' => 'Ambon'],
            ['nama_pt' => 'Universitas Cenderawasih', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Papua', 'kota' => 'Jayapura'],
            ['nama_pt' => 'UIN Syarif Hidayatullah', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Banten', 'kota' => 'Tangerang Selatan'],
            ['nama_pt' => 'UIN Sunan Kalijaga', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'DI Yogyakarta', 'kota' => 'Yogyakarta'],
            ['nama_pt' => 'UIN Maulana Malik Ibrahim', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Malang'],
            ['nama_pt' => 'Universitas Terbuka', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Banten', 'kota' => 'Tangerang Selatan'],
            ['nama_pt' => 'Institut Teknologi Sumatera', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Lampung', 'kota' => 'Bandar Lampung'],
            ['nama_pt' => 'Institut Teknologi Kalimantan', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Kalimantan Timur', 'kota' => 'Balikpapan'],
            ['nama_pt' => 'Universitas Tidar', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Tengah', 'kota' => 'Magelang'],
            ['nama_pt' => 'Universitas Trunojoyo Madura', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Jawa Timur', 'kota' => 'Bangkalan'],
            ['nama_pt' => 'Universitas Khairun', 'status_pt' => 'Negeri', 'lokasi' => 'Dalam Negeri', 'provinsi' => 'Maluku Utara', 'kota' => 'Ternate']
        ];

        foreach ($universities as $univ) {
            MasterPt::firstOrCreate(['nama_pt' => $univ['nama_pt']], $univ);
        }
    }
}
