<?php

namespace Database\Seeders;

use App\Models\MasterSiswa;
use App\Models\MasterPt;
use App\Models\PersebaranPt;
use Illuminate\Database\Seeder;

class PersebaranPtSeeder extends Seeder
{
    public function run(): void
    {
        $ptns = MasterPt::pluck('nama_pt')->toArray();

        if (empty($ptns)) {
            $this->command->info('Tidak ada data di MasterPt. Jalankan TopUniversitasSeeder terlebih dahulu.');
            return;
        }

        // Create PersebaranPt data
        $fakultas = ['Teknik', 'Kedokteran', 'Ekonomi', 'Hukum', 'MIPA', 'Sosial Politik'];
        $jurusan = [
            'Informatika', 'Elektro', 'Sipil', 'Manajemen', 'Akuntansi', 'Hukum',
            'Kedokteran', 'Farmasi', 'Keperawatan', 'Gizi', 'Kesehatan Masyarakat',
            'Mesin', 'Industri', 'Kimia', 'Arsitektur', 'Planologi',
            'Ekonomi', 'Bisnis', 'Keuangan', 'Perpajakan', 'Koperasi',
            'Matematika', 'Fisika', 'Biologi', 'Statistika', 'Geografi',
            'Komunikasi', 'Jurnalistik', 'Broadcasting', 'Public Relations',
            'Psikologi', 'Sosiologi', 'Antropologi', 'Politik', 'Administrasi',
            'Pendidikan', 'Bahasa', 'Sastra', 'Sejarah', 'Seni', 'Musik'
        ];
        $program_studi = [
            'Teknik Informatika', 'Sistem Informasi', 'Teknologi Informasi', 'Ilmu Komputer', 'Rekayasa Perangkat Lunak',
            'Teknik Elektro', 'Teknik Sipil', 'Teknik Mesin', 'Teknik Industri', 'Teknik Kimia', 'Arsitektur', 'Planologi',
            'Manajemen', 'Akuntansi', 'Ekonomi Pembangunan', 'Bisnis Digital', 'Manajemen Keuangan', 'Ekonomi Syariah',
            'Ilmu Hukum', 'Hukum Bisnis', 'Hukum Internasional', 'Hukum Pidana', 'Hukum Perdata',
            'Kedokteran', 'Kedokteran Gigi', 'Farmasi', 'Keperawatan', 'Kebidanan', 'Gizi', 'Kesehatan Masyarakat',
            'Matematika', 'Fisika', 'Kimia', 'Biologi', 'Statistika', 'Geografi', 'Geologi', 'Astronomi',
            'Ilmu Komunikasi', 'Jurnalistik', 'Broadcasting', 'Public Relations', 'Hubungan Internasional',
            'Psikologi', 'Sosiologi', 'Antropologi', 'Ilmu Politik', 'Administrasi Publik', 'Administrasi Bisnis',
            'Pendidikan Matematika', 'Pendidikan Bahasa Indonesia', 'Pendidikan Bahasa Inggris', 'PGSD', 'PAUD',
            'Sastra Indonesia', 'Sastra Inggris', 'Bahasa dan Kebudayaan Jepang', 'Sejarah', 'Filsafat',
            'Seni Rupa', 'Desain Grafis', 'Desain Interior', 'Musik', 'Tari', 'Teater', 'Film dan Televisi',
            'Pertanian', 'Peternakan', 'Kehutanan', 'Perikanan', 'Teknologi Pangan', 'Agribisnis'
        ];
        $jalur = ['SNBP', 'SNBT', 'Mandiri'];
        $strata = ['D3', 'D4', 'S1', 'S2', 'S3'];
        $akreditasi = ['A', 'B', 'C'];

        MasterSiswa::where('jenjang', 'SMA')->chunk(100, function ($siswas) use ($ptns) {
            foreach ($siswas as $siswa) {
                $siswa->update(['jurusan' => $ptns[array_rand($ptns)]]);
            }
        });

        $ptnIds = MasterPt::pluck('id')->toArray();

        MasterSiswa::where('jenjang', 'SMA')->chunk(100, function ($siswas) use ($ptnIds, $fakultas, $jurusan, $program_studi, $jalur, $strata, $akreditasi) {
            foreach ($siswas as $siswa) {
                PersebaranPt::create([
                    'pt_id' => $ptnIds[array_rand($ptnIds)],
                    'siswa_id' => $siswa->id,
                    'fakultas' => $fakultas[array_rand($fakultas)],
                    'jurusan' => $jurusan[array_rand($jurusan)],
                    'program_studi' => $program_studi[array_rand($program_studi)],
                    'starta' => $strata[array_rand($strata)],
                    'akreditasi' => $akreditasi[array_rand($akreditasi)],
                    'jalur_masuk' => $jalur[array_rand($jalur)]
                ]);
            }
        });
    }
}
