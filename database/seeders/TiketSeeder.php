<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departemen = ['Humas', 'Tata-Usaha', 'Wakakur', 'Wakasis', 'Psikolog','BK'];
        $status = ['New', 'Proses', 'Selesai'];


        $detailKendala = [
            'Koneksi internet lambat',
            'Perundungan',
            'Kebocoran air',
            'Guru tidak hadir',
            'Siswa tidak hadir',
            'Komputer rusak',
            'Printer tidak berfungsi',
            'Koneksi internet lambat',
            'Listrik padam',
            'Tidak ada air',
            'Kebocoran air',
            'Lampu tidak berfungsi',
            'Fans tidak berfungsi',
            'Tidak ada listrik',
            'Komputer tidak ada',
            'Tidak ada printer',
            'Perundungan',
            'Siswa tidak mengikuti aturan',
            'Guru tidak memberi perhatian',
            'Tidak ada ruang kelas',
            'Tidak ada sarana',
            'Tidak ada prasarana',
        ];

        for ($i = 0; $i < 20; $i++) {
            \App\Models\Tiket::create([
                'waktu_proses' => now()->format('Y-m-d H:i:s'),
                'waktu_close' => now()->format('Y-m-d H:i:s'),
                'no_hp' => '08123456789'.$i,
                'nama' => 'Tiket ' . $i,
                'email' => 'tiket' . $i . '@mail.com',
                'judul_kendala' => 'Aduan ' . $i,
                'lokasi_kendala' => 'Lantai 2',
                'detail_kendala' => $detailKendala[array_rand($detailKendala)],
                'status' => $status[array_rand($status)],
            ]);
        }
    }
}
