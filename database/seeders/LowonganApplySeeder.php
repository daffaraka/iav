<?php

namespace Database\Seeders;

use App\Models\LowonganApply;
use App\Models\LowonganPekerjaan;
use Illuminate\Database\Seeder;

class LowonganApplySeeder extends Seeder
{
    public function run(): void
    {
        $applies = [
            [
                'lowongan_pekerjaan_id' => 1,
                'nama_pelamar' => 'Ahmad Rizki',
                'email_pelamar' => 'ahmad.rizki@email.com',
                'phone_pelamar' => '081234567890',
                'alamat_pelamar' => 'Jl. Merdeka No. 123, Jakarta Selatan',
                'cover_letter' => 'Saya tertarik untuk bergabung sebagai Frontend Developer di perusahaan Anda.',
                'status' => 'Review'
            ],
            [
                'lowongan_pekerjaan_id' => 2,
                'nama_pelamar' => 'Siti Nurhaliza',
                'email_pelamar' => 'siti.nurhaliza@email.com',
                'phone_pelamar' => '081987654321',
                'alamat_pelamar' => 'Jl. Sudirman No. 456, Bandung',
                'cover_letter' => 'Dengan pengalaman 3 tahun di bidang backend development, saya siap berkontribusi.',
                'status' => 'Interview'
            ],
            [
                'lowongan_pekerjaan_id' => 3,
                'nama_pelamar' => 'Budi Santoso',
                'email_pelamar' => 'budi.santoso@email.com',
                'phone_pelamar' => '081122334455',
                'alamat_pelamar' => 'Jl. Malioboro No. 789, Yogyakarta',
                'cover_letter' => 'Portfolio desain saya dapat dilihat di website pribadi saya.',
                'status' => 'Pending'
            ]
        ];

        foreach ($applies as $apply) {
            LowonganApply::create($apply);
        }
    }
}