<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'no_hp' => '081234567890',
            'departemen' => 'Admin'
        ]);
        $user->assignRole('Admin');


        // Humas
        $humas = User::create([
            'name' => 'Siti Nurjanah',
            'email' => 'humas@humas.com',
            'password' => bcrypt('password'),
            'no_hp' => '',
            'departemen' => 'Humas'
        ]);
        $humas->assignRole('Humas');


        $kepsek = User::create([
            'name' => 'Budi Santoso',
            'email' => 'kepsek@kepsek.com',
            'password' => bcrypt('password'),
            'no_hp' => '',
            'departemen' => 'Kepsek'
        ]);
        $kepsek->assignRole('Humas');


        $tu = User::create([
            'name' => 'Rina Widiastuti',
            'email' => 'tata_usaha@tu.com',
            'password' => bcrypt('password'),
            'no_hp' => '',
            'departemen' => 'TataUsaha'
        ]);
        $tu->assignRole('TataUsaha');


        $wakasis = User::create([
            'name' => 'Dian Eka Sari',
            'email' => 'wakasis@wakasis.com',
            'password' => bcrypt('password'),
            'no_hp' => '',
            'departemen' => 'Wakasis'
        ]);
        $wakasis->assignRole('Wakasis');

        $wakakur = User::create([
            'name' => 'Rudi Hartono',
            'email' => 'wakakur@wakakur.com',
            'password' => bcrypt('password'),
            'no_hp' => '',
            'departemen' => 'Wakakur'
        ]);
        $wakakur->assignRole('Wakakur');

        $psikolog = User::create([
            'name' => 'Dra. Sri Wahyuni',
            'email' => 'psikolog@psikolog.com',
            'password' => bcrypt('password'),
            'no_hp' => '',
            'departemen' => 'Psikolog'
        ]);
        $psikolog->assignRole('Psikolog');

        $bk = User::create([
            'name' => 'Dra. Yanti Widowati',
            'email' => 'bk@bk.com',
            'password' => bcrypt('password'),
            'no_hp' => '',
            'departemen' => 'BK'
        ]);
        $bk->assignRole('BK');
        // $humasCnr = User::create([
        //     'name' => 'Humas Cinere',
        //     'email' => 'humas_cnr@admin.com',
        //     'password' => bcrypt('password'),
        //     'no_hp' => '',
        //     'role' => 'Humas',
        //     'departemen' => 'Humas Cinere'
        // ]);
        // $humasCnr->assignRole('Humas');

        // $humasPml = User::create([
        //     'name' => 'Humas Pamulang',
        //     'email' => 'humas_pml@admin.com',
        //     'password' => bcrypt('password'),
        //     'no_hp' => '',
        //     'role' => 'Humas',
        //     'departemen' => 'Humas Pamulang'
        // ]);
        // $humasPml->assignRole('Humas');

        // //
        // $kepsekCnr = User::create([
        //     'name' => 'Kepala Sekolah Jagakarsa',
        //     'email' => 'kepsek_cinere@admin.com',
        //     'password' => bcrypt('password'),
        //     'no_hp' => '',
        //     'role' => 'KepalaSekolah',
        //     'departemen' => 'Kepala Sekolah'
        // ]);
        // $kepsekCnr->assignRole('KepalaSekolah');


        // $kepsekCnr = User::create([
        //     'name' => 'Kepala Sekolah Cinere',
        //     'email' => 'kepsek@admin.com',
        //     'password' => bcrypt('password'),
        //     'no_hp' => '',
        //     'role' => 'KepalaSekolah',
        //     'departemen' => 'Kepala Sekolah'
        // ]);
        // $kepsekCnr->assignRole('KepalaSekolah');


        // $kepsekPml = User::create([
        //     'name' => 'Kepala Sekolah Pamulang',
        //     'email' => 'kepsek@admin.com',
        //     'password' => bcrypt('password'),
        //     'no_hp' => '',
        //     'role' => 'KepalaSekolah',
        //     'departemen' => 'Kepala Sekolah'
        // ]);
        // $kepsekPml->assignRole('KepalaSekolah');

        // $user = User::create([
        //     'name' => 'Wakasis',
        //     'email' => 'wakasis@admin.com',
        //     'password' => bcrypt('password'),
        //     'no_hp' => '',
        //     'role' => 'Wakasis',
        //     'departemen' => 'Wakasis'
        // ]);
        // $user->assignRole('Wakasis');

        // $user = User::create([
        //     'name' => 'Wakakur',
        //     'email' => 'wakakur@admin.com',
        //     'password' => bcrypt('password'),
        //     'no_hp' => '',
        //     'role' => 'Wakakur',
        //     'departemen' => 'Wakakur'
        // ]);
        // $user->assignRole('Wakakur');


        // $user = User::create([
        //     'name' => 'Kepala TU',
        //     'email' => 'tu@admin.com',
        //     'password' => bcrypt('password'),
        //     'no_hp' => '',
        //     'role' => 'TataUsaha',
        //     'departemen' => 'Tata Usaha'
        // ]);
        // $user->assignRole('TataUsaha');
        // $user = User::create([
        //     'name' => 'Psikolog BK',
        //     'email' => 'psikolog_bk@admin.com',
        //     'password' => bcrypt('password'),
        //     'no_hp' => '',
        //     'role' => 'PsikologBK',
        //     'departemen' => 'Psikolog-BK'
        // ]);
        // $user->assignRole('PsikologBK');

    }
}
