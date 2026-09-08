<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AwActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::where('unit', 'BPS')->get();
        $awValues = ['Berintegritas', 'Profesional', 'Adaptif', 'Bersinergi', 'Dedikatif'];
        $habits = [
            'Be Proactive',
            'Begin with the End in Mind',
            'Put First Things First',
            'Think Win-Win',
            'Seek First to Understand Then to Be Understood',
            'Synergize',
            'Sharpen the Saw'
        ];

        // Buat data untuk 7 hari terakhir termasuk hari ini
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            
            // Tentukan 1 orang fasilitator dan 1 culture champion secara acak tiap harinya
            $facilitatorId = $users->random()->id;
            $cultureChampionId = $users->random()->id;
            $favoriteId = $users->random()->id;

            foreach ($users as $user) {
                // Random values and habits (1-3 item each)
                $userAwValues = collect($awValues)->random(rand(1, 3))->values()->toArray();
                $userHabits = collect($habits)->random(rand(1, 3))->values()->toArray();

                \App\Models\AwActivity::updateOrCreate(
                    [
                        'date' => $date,
                        'user_id' => $user->id,
                    ],
                    [
                        'yesterday_activity' => 'Melakukan pekerjaan rutin harian tanggal ' . now()->subDays($i + 1)->format('d M Y') . ' dan menyelesaikan task unit BPS.',
                        'aw_value' => $userAwValues,
                        'habits' => $userHabits,
                        'is_facilitator' => ($user->id === $facilitatorId),
                        'is_culture_champion' => ($user->id === $cultureChampionId),
                        'is_favorite' => ($user->id === $favoriteId),
                    ]
                );
            }
        }
    }
}
