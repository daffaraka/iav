<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Sekolah;
use App\Models\MasterSiswa;
use App\Models\DataPrestasi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DataPrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolah = Sekolah::all()->pluck('id')->toArray();
        $siswa = MasterSiswa::all()->pluck('id')->toArray();
        $faker = Factory::create('id_ID');
        for ($i=1; $i < 100; $i++) {
            $year = $faker->numberBetween(2015, (int) date('Y'));
            DataPrestasi::create([
                'master_siswa_id' => $faker->randomElement($siswa),
                'sekolah_id' => $faker->randomElement($sekolah),
                'nama_lomba' => $faker->company,
                'tingkat_lomba' => $faker->randomElement(['Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional']),
                'status_lomba' => $faker->randomElement(['Terkurasi', 'Tidak terkurasi']),
                'tahun_pelajaran' => $year . '-' . ($year + 1),
                'lokasi' => $faker->city,
                'tanggal_pelaksanaan' => $faker->date('Y-m-d'),
                'keterangan' => $faker->paragraph,
            ]);
        }
    }
}
