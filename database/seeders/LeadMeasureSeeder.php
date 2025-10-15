<?php

namespace Database\Seeders;

use App\Models\Wig;
use App\Models\LeadMeasure;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeadMeasureSeeder extends Seeder
{

    public function run(): void
    {

        $wig = Wig::all()->pluck('id')->toArray();
        for ($i = 1; $i <= 100; $i++) {
            LeadMeasure::create([
                'wig_id' => $wig[array_rand($wig)],
                'judul_lead' => 'Lead Measure ' . $i,
                'deskripsi_lead' => 'Deskripsi untuk lead measure ' . $i,
                'target' => rand(1, 100),
                'satuan' => ['Persen', 'Unit', 'Orang'][array_rand(['Persen', 'Unit', 'Orang'])],
                'status' => rand(0, 3),
            ]);
        }
    }
}
