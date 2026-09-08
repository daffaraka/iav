<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriProgramKerja;

class KategoriProgramKerjaSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Program Strategis',
            'Program Rutin',
            'Program Pengembangan',
            'Program Evaluasi'
        ];

        foreach ($categories as $category) {
            KategoriProgramKerja::updateOrCreate(
                ['name' => $category],
                ['name' => $category]
            );
        }
    }
}
