<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sekolah;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolah = [
            ['nama_sekolah' => 'Jagakarsa - KB-TK', 'alamat' => 'Jagakarsa', 'unit' => 'Jagakarsa', 'jenjang' => 'KB-TK'],
            ['nama_sekolah' => 'Jagakarsa - SD', 'alamat' => 'Jagakarsa', 'unit' => 'Jagakarsa', 'jenjang' => 'SD'],
            ['nama_sekolah' => 'Jagakarsa - SMP', 'alamat' => 'Jagakarsa', 'unit' => 'Jagakarsa', 'jenjang' => 'SMP'],
            ['nama_sekolah' => 'Jagakarsa - SMA', 'alamat' => 'Jagakarsa', 'unit' => 'Jagakarsa', 'jenjang' => 'SMA'],

            ['nama_sekolah' => 'Cinere - KB-TK', 'alamat' => 'Cinere', 'unit' => 'Cinere', 'jenjang' => 'KB-TK'],
            ['nama_sekolah' => 'Cinere - SD', 'alamat' => 'Cinere', 'unit' => 'Cinere', 'jenjang' => 'SD'],
            ['nama_sekolah' => 'Cinere - SMP', 'alamat' => 'Cinere', 'unit' => 'Cinere', 'jenjang' => 'SMP'],
            ['nama_sekolah' => 'Cinere - SMA', 'alamat' => 'Cinere', 'unit' => 'Cinere', 'jenjang' => 'SMA'],

            ['nama_sekolah' => 'Pamulang - KB-TK', 'alamat' => 'Pamulang', 'unit' => 'Pamulang', 'jenjang' => 'KB-TK'],
        ];
        foreach ($sekolah as $s) {
            Sekolah::create($s);
        }
    }
}
