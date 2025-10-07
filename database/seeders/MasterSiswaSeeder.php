<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MasterSiswa;
use App\Models\Sekolah;
use Faker\Factory as Faker;

class MasterSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $kelas = [
            'I',
            'II',
            'III',
            'IV',
            'V',
            'VI',
            'VII',
            'VIII',
            'IX',
            'X',
            'XI',
            'XII'
        ];
        $sekolah = Sekolah::all()->pluck('id')->toArray();
        $jenjang = ['KB', 'TK', 'SD', 'SMP', 'SMA'];
        $tahunAjaran = ['2022/2023', '2023/2024', '2024/2025'];
        $unit = ['Jagakarsa', 'Cinere', 'Pamulang'];
        $angkatan = ['2022', '2023', '2024', '2025'];
        $subKelas = ['A', 'B', 'C'];
        $asalSekolah = ['SMPN A Bandung', 'SMPN B Bandung', 'SMPN C Bandung'];
        $agama = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha'];

        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            MasterSiswa::create([
                'nama'          => $faker->name,
                'nik'           => $faker->unique()->numerify('################'), // 16 digit
                'tempat_lahir'  => 'Bandung',
                'tanggal_lahir' => $faker->date('Y-m-d', '2010-12-31'), // tanggal random sampai 2010
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama'         => $faker->randomElement($agama),
                'alamat'        => 'Jl. ' . $faker->streetName,
                'no_hp'         => '08' . $faker->numerify('##########'),
                'email'         => 'siswa_' . $i . '@example.com',
                'tahun_ajaran'  => $faker->randomElement($tahunAjaran),
                'nisn'          => $faker->unique()->numerify('##########'), // 10 digit
                'nis'           => $faker->unique()->numerify('########'),   // 8 digit
                'jenjang'       => $faker->randomElement($jenjang),
                'kelas'         => $faker->randomElement($kelas),
                'sub_kelas'     => $faker->randomElement($subKelas),
                'angkatan'      => $faker->randomElement($angkatan),
                'jurusan'       => $faker->randomElement($unit),
                'sekolah_id'    => $faker->randomElement($sekolah),
                'status'        => 'Aktif',
                'foto'          => 'siswa' . rand(1, 100) . '.jpg',
                'asal_sekolah'  => $faker->randomElement($asalSekolah)
            ]);
        }
    }
}
