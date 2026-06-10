<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'direktur',
            'koordinator',
            'kadept',
            'super-admin',
            'staff',
            'guru',
            'kepala-tata-usaha',
            'tata-usaha',
            'kepala-sekolah',
            'admin-unit',
            'humas',
            'wali-kelas',
            'wakakur',
            'wakasis',
            'psikolog',
            'kepala-psikolog',
            'satpam',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
