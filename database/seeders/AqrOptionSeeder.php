<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AqrOption;

class AqrOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            // Kepsek
            ['nama_option' => 'Karakter, Sikap dan Perilaku Guru', 'kategori_pic' => 'Kepala Sekolah'],
            ['nama_option' => 'Karakter, Sikap dan Perilaku Siswa', 'kategori_pic' => 'Kepala Sekolah'],
            ['nama_option' => 'Kedisiplinan Peraturan Kepegawaian Guru', 'kategori_pic' => 'Kepala Sekolah'],
            ['nama_option' => 'Kedisiplinan dan Tata Tertib Siswa', 'kategori_pic' => 'Kepala Sekolah'],
            ['nama_option' => 'Layanan dan Komunikasi Guru', 'kategori_pic' => 'Kepala Sekolah'],
            ['nama_option' => 'Layanan Perpustakaan dan Laboratorium', 'kategori_pic' => 'Kepala Sekolah'],
            ['nama_option' => 'Layanan UKS & Kantin', 'kategori_pic' => 'Kepala Sekolah'],
            ['nama_option' => 'Perundungan (Bullying) , kekerasan dan pelecehan seksual', 'kategori_pic' => 'Psikolog'],
            ['nama_option' => 'Proses Kegiatan Belajar Mengajar', 'kategori_pic' => 'Kepala Sekolah'],
            ['nama_option' => 'Kegiatan Sekolah', 'kategori_pic' => 'Kepala Sekolah'],

            // TU
            ['nama_option' => 'Kendala Internet', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Karakter, sikap dan perilaku security dan cleaning servis', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Karakter, sikap dan perilaku supir antar jemput', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Karakter, sikap dan perilaku tenaga kependidikan', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Layanan komunikasi security dan cleaning servis', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Komunikasi tenaga kependidikan', 'kategori_pic' => 'Kepala TU'],
            // ['nama_option' => 'Layanan Antar jemput ', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Layanan keamanan dan keselematan Siswa', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Layanan kebersihan dan Kerapihan Gedung Sekolah', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Layanan Ketertiban Sekolah', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Layanan penyediaan seragam dan buku sekolah', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Saran dan Prasarana', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Keuangan dan Administrasi', 'kategori_pic' => 'Kepala TU'],

            // Keuangan
            ['nama_option' => 'Informasi Biaya Pendaftaran / Uang Pangkal / Kegiatan Sekolah', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Informasi Tagihan SPP/ Biaya Sekolah', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Konfirmasi Pembayaran', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Klarifikasi atau Koreksi Tagihan', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Informasi Tunggakan Pembayaran', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Permohonan Cicilan / Keringanan Pembayaran', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Permintaan Bukti Pembayaran / Kwitansi', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Pengajuan Pengembalian Dana (Refund)', 'kategori_pic' => 'Kepala TU'],

            // GA
            ['nama_option' => 'Kebersihan Gedung', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Kerusakan Fasilitas', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Jaringan Internet / WiFi', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Keamanan Sekolah', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Sikap & Perilaku Tenaga Kependidikan', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Layanan Antar Jemput', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Layanan Kantin & Catering', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Parkir & Ketertiban', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Ketersediaan Air & Listrik', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Penyediaan Seragam', 'kategori_pic' => 'Kepala TU'],
            ['nama_option' => 'Penyediaan Buku Sekolah', 'kategori_pic' => 'Kepala TU'],
        ];

        foreach ($options as $option) {
            AqrOption::create($option);
        }
    }
}
