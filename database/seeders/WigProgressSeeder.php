<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WigProgress;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WigProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::all()->pluck('id')->toArray();
        for ($i = 1; $i <= 300; $i++) {
            WigProgress::create([
                'wig_id' => rand(1, 10),
                'progress_wig' => rand(1, 100),
                'bulan' => rand(1,12),
            ]);
        }
    }
}
