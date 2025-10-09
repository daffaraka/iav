<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'nama_dept' => 'Departemen IT',
                'deskripsi_dept' => 'Mengelola infrastruktur teknologi dan sistem informasi',
                'koor_id' => 1
            ],
            [
                'nama_dept' => 'Departemen SDM',
                'deskripsi_dept' => 'Mengelola sumber daya manusia dan pengembangan karyawan',
                'koor_id' => 1
            ],
            [
                'nama_dept' => 'Departemen Keuangan',
                'deskripsi_dept' => 'Mengelola keuangan dan akuntansi perusahaan',
                'koor_id' => 2
            ],
            [
                'nama_dept' => 'Departemen Marketing',
                'deskripsi_dept' => 'Mengelola pemasaran dan hubungan pelanggan',
                'koor_id' => 1
            ],
            [
                'nama_dept' => 'Departemen Operasional',
                'deskripsi_dept' => 'Mengelola operasional dan logistik perusahaan',
                'koor_id' => 3
            ],
            [
                'nama_dept' => 'Departemen RND KB TK',
                'deskripsi_dept' => 'Mengelola riset dan pengembangan kurikulum KB/TK',
                'koor_id' => 1
            ],
            [
                'nama_dept' => 'Departemen RND SD',
                'deskripsi_dept' => 'Mengelola riset dan pengembangan kurikulum SD',
                'koor_id' => 1
            ],
            [
                'nama_dept' => 'Departemen RND SMP',
                'deskripsi_dept' => 'Mengelola riset dan pengembangan kurikulum SMP',
                'koor_id' => 1
            ],
            [
                'nama_dept' => 'Departemen RND SMA',
                'deskripsi_dept' => 'Mengelola riset dan pengembangan kurikulum SMA',
                'koor_id' => 1
            ],


        ];

        foreach ($departments as $department) {
            Departement::create($department);
        }
    }
}
