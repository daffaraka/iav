<?php

namespace Database\Seeders;

use App\Models\Wig;
use App\Models\Departement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dept = Departement::all()->pluck('id')->toArray();
        $status = [1,2,3];
        for ($i = 1; $i < 100; $i++) {
            Wig::create([
                'judul_wig' => 'WIG ' . $i,
                'deskripsi_wig' => 'Deskripsi WIG ' . $i,
                'tanggal_mulai_wig' => now(),
                'tanggal_berakhir_wig' => now()->addMonths(11),
                'unit_wig' => array_rand(['Unit','Persen','Prestasi']),
                'from_x' => rand(1, 50),
                'to_y' => rand(51, 100),
                'status_wig' => $status[array_rand($status)],
                'departement_id' => $dept[array_rand($dept)],
            ]);
        }
    }
}
