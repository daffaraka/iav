<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskWeight;

class TaskWeightSeeder extends Seeder
{
    public function run()
    {
        $weights = [
            ['level' => 'low', 'weight' => 1],
            ['level' => 'medium', 'weight' => 3],
            ['level' => 'high', 'weight' => 5],
        ];

        foreach ($weights as $weight) {
            TaskWeight::updateOrCreate(
                ['level' => $weight['level']],
                ['weight' => $weight['weight']]
            );
        }
    }
}
