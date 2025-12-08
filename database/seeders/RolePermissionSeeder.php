<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin - All permissions
        $superAdmin = Role::findByName('super-admin');
        $superAdmin->givePermissionTo(Permission::all());

        // Staff - Basic operations
        $staff = Role::findByName('staff');
        $staffPermissions = [
            'view-dashboard',
            'view-sekolah', 'create-sekolah', 'edit-sekolah',
            'view-data-prestasi', 'create-data-prestasi', 'edit-data-prestasi',
            'view-lowongan-pekerjaan', 'create-lowongan-pekerjaan', 'edit-lowongan-pekerjaan',
            'view-lowongan-apply', 'edit-lowongan-apply',
            'view-lowongan-progress', 'create-lowongan-progress', 'edit-lowongan-progress',
            'view-aqr-dashboard',
            'view-tiket', 'edit-tiket',
            'view-aduan', 'edit-aduan'
        ];
        $staff->givePermissionTo($staffPermissions);

        // Guru - Limited access
        $guru = Role::findByName('guru');
        $guruPermissions = [
            'view-dashboard',
            'view-sekolah',
            'view-data-prestasi', 'create-data-prestasi', 'edit-data-prestasi',
            'view-wig', 'view-lead-measure', 'view-task-process',
            'create-task-process', 'edit-task-process',
            'view-tiket', 'create-tiket'
        ];
        $guru->givePermissionTo($guruPermissions);

        // TU - Administrative tasks
        $tu = Role::findByName('tata-usaha');
        $tuPermissions = [
            'view-dashboard',
            'view-sekolah', 'create-sekolah', 'edit-sekolah',
            'view-data-prestasi', 'create-data-prestasi', 'edit-data-prestasi', 'delete-data-prestasi',
            'view-lowongan-pekerjaan', 'create-lowongan-pekerjaan', 'edit-lowongan-pekerjaan',
            'view-lowongan-apply', 'create-lowongan-apply', 'edit-lowongan-apply',
            'view-lowongan-progress', 'create-lowongan-progress', 'edit-lowongan-progress',
            'view-user', 'create-user', 'edit-user',
            'view-aqr-dashboard',
            'view-tiket', 'create-tiket', 'edit-tiket', 'tiket-finish',
            'view-aduan', 'create-aduan', 'edit-aduan',
            'view-rating-tiket', 'create-rating-tiket', 'edit-rating-tiket',
            'export-data'
        ];
        $tu->givePermissionTo($tuPermissions);

        // Kepala Sekolah - Management level
        $kepalaSekolah = Role::findByName('kepala-sekolah');
        $kepalaSekolahPermissions = [
            'view-dashboard',
            'view-sekolah',
            'view-data-prestasi',
            'view-lowongan-pekerjaan',
            'view-lowongan-apply',
            'view-lowongan-progress',
            'view-departement', 'create-departement', 'edit-departement',
            'view-wig', 'create-wig', 'edit-wig',
            'view-lead-measure', 'create-lead-measure', 'edit-lead-measure',
            'view-task-process',
            'view-wig-progress',
            'view-aqr-dashboard',
            'view-tiket',
            'view-aduan',
            'view-reports',
            'view-analytics',
            'export-data'
        ];
        $kepalaSekolah->givePermissionTo($kepalaSekolahPermissions);

        // Humas - Full monitoring access
        $humas = Role::firstOrCreate(['name' => 'humas']);
        $humasPermissions = Permission::all(); // All permissions for monitoring
        $humas->givePermissionTo($humasPermissions);
    }
}
