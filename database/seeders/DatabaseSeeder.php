<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WigProgress;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            KaryawanSeeder::class,
            // BPSUserSeeder::class,
            UserSeeder::class,
            // SekolahUserSeeder::class,
            DepartementSeeder::class,
            SekolahSeeder::class,
            MasterSiswaSeeder::class,
            DataPrestasiSeeder::class,
            WigSeeder::class,
            LeadMeasureSeeder::class,
            TaskProcessSeeder::class,
            WigProgressSeeder::class,
            LowonganPekerjaanSeeder::class,
            AqrOptionSeeder::class,
            TiketSeeder::class,
            TopUniversitasSeeder::class,
            PersebaranPtSeeder::class,

        ]);
    }
}
