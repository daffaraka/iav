<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $modules = [
            'dashboard',
            'sekolah',
            'data-prestasi',
            'lowongan-pekerjaan',
            'lowongan-apply',
            'lowongan-progress',
            'departement',
            'wig',
            'lead-measure',
            'task-process',
            'wig-progress',
            'aqr-dashboard',
            'tiket',
            'aduan',
            'progres-tiket',
            'rating-tiket',
            'user',
            'penjemputan-harian',
            'featured-question',
            'tiket-karyawan',
            'progres-tiket-karyawan'
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => $action . '-' . $module]);
            }
        }

        // Additional specific permissions
        $specificPermissions = [
            'manage-all-data',
            'view-reports',
            'export-data',
            'manage-settings',
            'assign-roles',
            'view-analytics',
            'tiket-finish',
            'tiket-pilih-pic',
            'monitor-all-tiket',
            'reminder-tiket',
            'view-all-locations',
            'konfirmasi-kedatangan',
            'konfirmasi-keluar',
            'konfirmasi-ojol',
            'konfirmasi-penyerahan',
            'monitor-all-tiket-karyawan',
            'tiket-karyawan-finish'
        ];

        foreach ($specificPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
