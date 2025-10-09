<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $users = [
            [
                'name' => 'Imam Sukendro',
                'username' => 'imam_sukendro',
                'nip' => '1',
                'jabatan' => 'Koordinator',
                'email' => 'imam.sukendro@avicenna.sch.id',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Tri Sari Andita',
                'username' => 'tri_sari',
                'nip' => '2',
                'jabatan' => 'Koordinator',
                'email' => 'tri.sari@avicenna.sch.id',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ajeng',
                'username' => 'ajeng',
                'nip' => '3',
                'jabatan' => 'Koordinator',
                'email' => 'ajeng@avicenna.sch.id',
                'password' => Hash::make('password'),
            ]
        ];


        User::create($users);
    }
}
