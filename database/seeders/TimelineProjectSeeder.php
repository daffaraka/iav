<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Departement;
use App\Models\NewMigration\Project;
use App\Models\NewMigration\ProgramKerja;
use App\Models\NewMigration\Board;
use App\Models\NewMigration\Task;
use App\Models\NewMigration\KategoriProgramKerja;

class TimelineProjectSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get references
        $admin = User::first();
        $dept = Departement::first();

        // 2. Clear old data (optional, using truncate might violate FK)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Task::truncate();
        Board::truncate();
        Project::truncate();
        ProgramKerja::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 3. Create Projects (WIG)
        $project1 = Project::create([
            'title' => 'Optimalisasi Sistem Internal Portal Humas',
            'description' => 'Meningkatkan performa dan fitur portal humas untuk kebutuhan internal PT INKA.',
            'departement_id' => $dept ? $dept->id : null,
            'pic_id' => $admin ? $admin->id : null,
            'start_date' => Carbon::now()->subDays(10),
            'target_date' => Carbon::now()->addDays(30),
            'bobot' => 100,
            'status' => 'active',
            'type' => 'wig'
        ]);

        $project2 = Project::create([
            'title' => 'Kampanye Publikasi Eksternal Q4',
            'description' => 'Target meningkatkan jangkauan media sosial dan website eksternal sebesar 40%.',
            'departement_id' => $dept ? $dept->id : null,
            'pic_id' => $admin ? $admin->id : null,
            'start_date' => Carbon::now()->subDays(5),
            'target_date' => Carbon::now()->addDays(45),
            'bobot' => 100,
            'status' => 'active',
            'type' => 'wig'
        ]);

        // 4. Create Boards (Lead Measure) for Project 1
        $board1 = Board::create([
            'boardable_type' => Project::class,
            'boardable_id' => $project1->id,
            'title' => 'Desain Antarmuka (UI/UX) Baru',
            'description' => 'Re-desain untuk dashboard WIG dan Kanban Board',
            'pic_id' => $admin ? $admin->id : null,
            'departement_id' => $dept ? $dept->id : null,
            'start_date' => Carbon::now()->subDays(10),
            'target_date' => Carbon::now()->addDays(5),
            'kondisi_aktual' => 'Masih menggunakan desain lama.',
            'target_akhir_tahun' => 'Implementasi SPA Laravel React.',
            'output_akhir' => 'Figma Prototype & React Components.',
            'prioritas' => 'high',
            'bobot_board' => 40
        ]);

        $board2 = Board::create([
            'boardable_type' => Project::class,
            'boardable_id' => $project1->id,
            'title' => 'Pengembangan Backend API & Controller',
            'description' => 'Integrasi Inertia.js dan Database Migrations.',
            'pic_id' => $admin ? $admin->id : null,
            'departement_id' => $dept ? $dept->id : null,
            'start_date' => Carbon::now()->subDays(5),
            'target_date' => Carbon::now()->addDays(20),
            'kondisi_aktual' => 'Controller lama masih terpisah-pisah.',
            'target_akhir_tahun' => 'Refactoring total dengan resource controller.',
            'output_akhir' => 'API yang bersih dan optimal.',
            'prioritas' => 'medium',
            'bobot_board' => 60
        ]);

        // 5. Create Boards for Project 2
        $board3 = Board::create([
            'boardable_type' => Project::class,
            'boardable_id' => $project2->id,
            'title' => 'Distribusi Konten Instagram',
            'description' => 'Pembuatan konten mingguan untuk Instagram.',
            'pic_id' => $admin ? $admin->id : null,
            'departement_id' => $dept ? $dept->id : null,
            'start_date' => Carbon::now()->subDays(2),
            'target_date' => Carbon::now()->addDays(40),
            'prioritas' => 'high',
            'bobot_board' => 100
        ]);

        // 6. Create Tasks for Board 1
        Task::create([
            'board_id' => $board1->id,
            'title' => 'Wireframing Dashboard',
            'description' => 'Membuat wireframe kasar menggunakan Balsamiq.',
            'pic_id' => $admin ? $admin->id : null,
            'priority' => 'low',
            'column_id' => 'done',
            'position' => 0
        ]);

        Task::create([
            'board_id' => $board1->id,
            'title' => 'Desain High-Fidelity',
            'description' => 'Mengkonversi wireframe ke Figma.',
            'pic_id' => $admin ? $admin->id : null,
            'priority' => 'high',
            'column_id' => 'progress',
            'position' => 1
        ]);

        Task::create([
            'board_id' => $board1->id,
            'title' => 'Slicing UI ke Tailwind CSS',
            'description' => 'Konversi ke komponen React.',
            'pic_id' => $admin ? $admin->id : null,
            'priority' => 'medium',
            'column_id' => 'todo',
            'position' => 2
        ]);

        // 7. Create Tasks for Board 2
        Task::create([
            'board_id' => $board2->id,
            'title' => 'Database Migration',
            'description' => 'Membuat schema migration baru.',
            'pic_id' => $admin ? $admin->id : null,
            'priority' => 'high',
            'column_id' => 'done',
            'position' => 0
        ]);

        Task::create([
            'board_id' => $board2->id,
            'title' => 'Setup Models & Relasi',
            'description' => 'Membuat Eloquent Models.',
            'pic_id' => $admin ? $admin->id : null,
            'priority' => 'medium',
            'column_id' => 'progress',
            'position' => 1
        ]);

        Task::create([
            'board_id' => $board2->id,
            'title' => 'Testing Endpoints',
            'description' => 'Uji coba CRUD WIG dan Board.',
            'pic_id' => $admin ? $admin->id : null,
            'priority' => 'high',
            'column_id' => 'todo',
            'position' => 2
        ]);
        
        echo "TimelineProjectSeeder completed successfully!\n";
    }
}
