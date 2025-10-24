<?php

namespace Database\Seeders;

use App\Models\LeadMeasure;
use App\Models\TaskProcess;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // $lead = LeadMeasure::all()->pluck('id')->toArray();

        // $tasks = [
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Membuat dokumentasi proyek',
        //         'deskripsi' => 'Menyusun dokumentasi lengkap untuk proyek yang sedang berjalan',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Review kode program',
        //         'deskripsi' => 'Melakukan review dan perbaikan kode program',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Testing aplikasi',
        //         'deskripsi' => 'Melakukan pengujian fungsionalitas aplikasi',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Optimasi database',
        //         'deskripsi' => 'Mengoptimalkan kinerja dan struktur database',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Implementasi fitur baru',
        //         'deskripsi' => 'Menambahkan fitur baru sesuai requirement',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Perbaikan bug',
        //         'deskripsi' => 'Memperbaiki bug yang ditemukan',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Deployment aplikasi',
        //         'deskripsi' => 'Melakukan deployment ke server produksi',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Backup data',
        //         'deskripsi' => 'Melakukan backup rutin database dan file',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Monitoring sistem',
        //         'deskripsi' => 'Memantau kinerja dan keamanan sistem',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Update dependencies',
        //         'deskripsi' => 'Memperbarui package dan dependencies',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Code refactoring',
        //         'deskripsi' => 'Memperbaiki struktur kode program',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Integrasi API',
        //         'deskripsi' => 'Mengintegrasikan dengan API eksternal',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Optimasi performa',
        //         'deskripsi' => 'Meningkatkan kecepatan loading aplikasi',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Security testing',
        //         'deskripsi' => 'Menguji keamanan aplikasi',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'User training',
        //         'deskripsi' => 'Memberikan pelatihan kepada pengguna',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Data migration',
        //         'deskripsi' => 'Migrasi data dari sistem lama',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'UI/UX improvement',
        //         'deskripsi' => 'Memperbaiki tampilan dan pengalaman pengguna',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Load testing',
        //         'deskripsi' => 'Menguji kapasitas beban sistem',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'API documentation',
        //         'deskripsi' => 'Membuat dokumentasi API',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Code review',
        //         'deskripsi' => 'Review kode dari tim developer',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Database backup',
        //         'deskripsi' => 'Backup rutin database',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Server maintenance',
        //         'deskripsi' => 'Pemeliharaan rutin server',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Performance optimization',
        //         'deskripsi' => 'Optimasi kinerja aplikasi',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Security audit',
        //         'deskripsi' => 'Audit keamanan sistem',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Code deployment',
        //         'deskripsi' => 'Deploy kode ke production',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Bug fixing',
        //         'deskripsi' => 'Perbaikan bug aplikasi',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Feature testing',
        //         'deskripsi' => 'Pengujian fitur baru',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Database optimization',
        //         'deskripsi' => 'Optimasi query database',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Code cleanup',
        //         'deskripsi' => 'Pembersihan kode tidak terpakai',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'System integration',
        //         'deskripsi' => 'Integrasi dengan sistem eksternal',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'User acceptance test',
        //         'deskripsi' => 'Pengujian penerimaan pengguna',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Documentation update',
        //         'deskripsi' => 'Pembaruan dokumentasi sistem',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Code optimization',
        //         'deskripsi' => 'Optimasi kode program',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Security implementation',
        //         'deskripsi' => 'Implementasi fitur keamanan',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Performance testing',
        //         'deskripsi' => 'Pengujian performa sistem',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Data analysis',
        //         'deskripsi' => 'Analisis data sistem',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'System monitoring',
        //         'deskripsi' => 'Monitoring kinerja sistem',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        //     [
        //         'lead_measure_id' => $lead[array_rand($lead)],
        //         'nama_tugas' => 'Database maintenance',
        //         'deskripsi' => 'Pemeliharaan database',
        //         'jumlah_realisasi' => rand(1, 100),
        //         'dokumen' => 'doc_' . rand(1000, 9999) . '.pdf'
        //     ],
        // ];

        // TaskProcess::insert($tasks);

        $leadIds = LeadMeasure::pluck('id')->toArray();
        $data = [];

        for ($i = 0; $i < 500; $i++) {
            $data[] = [
                'lead_measure_id' => $leadIds[array_rand($leadIds)],
                'nama_tugas' => 'Tugas ke-' . ($i + 1),
                'deskripsi' => 'Deskripsi tugas ke-' . ($i + 1) . ' berisi rincian pekerjaan dan langkah yang dilakukan.',
                'jumlah_realisasi' => rand(1, 100),
                'dokumen' => 'dokumen_' . Str::random(8) . '.pdf',
                'tanggal_realisasi' => now()->subDays(rand(0, 180))->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        TaskProcess::insert($data);
    }
}
