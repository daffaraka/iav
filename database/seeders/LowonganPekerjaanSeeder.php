<?php

namespace Database\Seeders;

use App\Models\LowonganPekerjaan;
use Illuminate\Database\Seeder;

class LowonganPekerjaanSeeder extends Seeder
{
    public function run(): void
    {
        $lowongans = [
            [
                'judul_lowongan' => 'Frontend Developer',
                'perusahaan' => 'PT Tech Indonesia',
                'deskripsi' => 'Mengembangkan antarmuka pengguna yang responsif dan interaktif menggunakan teknologi modern seperti React, Vue.js, atau Angular.',
                'lokasi' => 'Jakarta Selatan',
                'jenis_pekerjaan' => 'Full Time',
                'gaji_min' => 'Rp 8.000.000',
                'gaji_max' => 'Rp 12.000.000',
                'persyaratan' => 'Minimal S1 Teknik Informatika, Pengalaman 2+ tahun, Menguasai HTML, CSS, JavaScript',
                'tanggal_tutup' => now()->addDays(30),
                'status' => 'Aktif',
                'kontak_email' => 'hr@techindonesia.com',
                'kontak_phone' => '021-12345678'
            ],
            [
                'judul_lowongan' => 'Backend Developer',
                'perusahaan' => 'PT Digital Solutions',
                'deskripsi' => 'Mengembangkan sistem backend yang scalable dan secure menggunakan Laravel, Node.js, atau Python.',
                'lokasi' => 'Bandung',
                'jenis_pekerjaan' => 'Full Time',
                'gaji_min' => 'Rp 9.000.000',
                'gaji_max' => 'Rp 15.000.000',
                'persyaratan' => 'Minimal S1 Teknik Informatika, Pengalaman 3+ tahun, Menguasai PHP/Laravel, Database MySQL/PostgreSQL',
                'tanggal_tutup' => now()->addDays(25),
                'status' => 'Aktif',
                'kontak_email' => 'recruitment@digitalsolutions.co.id',
                'kontak_phone' => '022-87654321'
            ],
            [
                'judul_lowongan' => 'UI/UX Designer',
                'perusahaan' => 'Creative Studio',
                'deskripsi' => 'Merancang pengalaman pengguna yang intuitif dan menarik untuk aplikasi web dan mobile.',
                'lokasi' => 'Yogyakarta',
                'jenis_pekerjaan' => 'Part Time',
                'gaji_min' => 'Rp 5.000.000',
                'gaji_max' => 'Rp 8.000.000',
                'persyaratan' => 'Minimal D3 Desain Grafis, Portfolio yang kuat, Menguasai Figma, Adobe XD, Sketch',
                'tanggal_tutup' => now()->addDays(20),
                'status' => 'Aktif',
                'kontak_email' => 'jobs@creativestudio.id',
                'kontak_phone' => null
            ]
        ];

        foreach ($lowongans as $lowongan) {
            LowonganPekerjaan::create($lowongan);
        }
    }
}