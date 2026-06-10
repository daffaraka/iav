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
            'penjemputan-harian'
        ];

        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::create(['name' => $action . '-' . $module]);
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
            'konfirmasi-penyerahan'
        ];

        foreach ($specificPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
