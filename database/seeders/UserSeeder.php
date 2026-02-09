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
                'name' => 'Admin',
                'username' => 'admin',
                'jabatan' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'unit' => 'BPS',
                'departemen' => 'Admin',

            ],
            [
                'name' => 'User',
                'username' => 'user',
                'jabatan' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'unit' => 'BPS',
                'departemen' => 'Admin',
            ],
        ];


        foreach ($users as $user) {
            $newUser = User::create($user);
            $newUser->assignRole('super-admin');
        }
    }
}
