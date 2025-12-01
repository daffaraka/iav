<?php

namespace Database\Seeders;

use App\Models\LowonganProgress;
use Illuminate\Database\Seeder;

class LowonganProgressSeeder extends Seeder
{
    public function run(): void
    {
        $progress = [
            [
                'lowongan_apply_id' => 1,
                'status' => 'Pending',
                'keterangan' => 'Lamaran diterima dan sedang dalam tahap review awal',
                'tanggal_progress' => now()->subDays(5)
            ],
            [
                'lowongan_apply_id' => 1,
                'status' => 'Review',
                'keterangan' => 'CV dan portfolio sedang direview oleh tim HR',
                'tanggal_progress' => now()->subDays(3)
            ],
            [
                'lowongan_apply_id' => 2,
                'status' => 'Pending',
                'keterangan' => 'Lamaran diterima',
                'tanggal_progress' => now()->subDays(7)
            ],
            [
                'lowongan_apply_id' => 2,
                'status' => 'Review',
                'keterangan' => 'Lolos tahap review, akan dijadwalkan interview',
                'tanggal_progress' => now()->subDays(4)
            ],
            [
                'lowongan_apply_id' => 2,
                'status' => 'Interview',
                'keterangan' => 'Interview dijadwalkan tanggal 25 Januari 2025',
                'tanggal_progress' => now()->subDays(1)
            ]
        ];

        foreach ($progress as $item) {
            LowonganProgress::create($item);
        }
    }
}