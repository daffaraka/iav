<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tiket;
use App\Models\AqrOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TiketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departemen = ['Humas', 'Tata-Usaha', 'Wakakur', 'Wakasis', 'Psikolog', 'BK'];
        $status = ['New', 'Proses', 'Selesai'];

        $jenisKendala = [
            'BK - Layanan BK (Konseling Karir, Pemilihan Jurusan)',
            'Humas - PPDB',
            'Humas - Promosi dan Marketing',
            'Kepala Sekolah - Kedisiplinan Karakter Sikap, Karakter dan Perilaku Guru',
            'Kesiswaan - Kedisiplinan, Karakter, Sikap dan Perilaku',
            'Kesiswaan - Kegiatan Ekstrakurikuler dan Club',
            'Kesiswaan - Kegiatan Organisasi',
            'Kesiswaan - Layanan Kesehatan (UKS)',
            'Kesiswaan - Layanan Perpustakaan',
            'Koperasi - Antar Jemput',
            'Koperasi - Pembelian Seragam dan Buku',
            'Kurikulum - Akademik',
            'Kurikulum - Jadwal Belajar',
            'Kurikulum - Kegiatan Belajar Mengajar (Mutu Pembelajaran)',
            'Kurikulum - Kurikulum',
            'Kurikulum - Laboratorium',
            'Psikolog & BK - Motivasi, Kepercayaan Diri & Komunikasi',
            'Psikolog & BK - Perundungan, kekerasan dan pelecehan seksual',
            'Psikolog - Layanan Psikologi (Tumbuh Kembang Anak & Parenting, Masalah Kepribadian, Permasalah psikologis, kesulitan belajar spesifik dan permasalahan psikologis lainnya)',
            'Tata Usaha - Keuangan',
            'Tata Usaha - Administrasi (Rapot, Ijazah dan sejenisnya)',
            'Tata Usaha - Kebersihan',
            'Tata Usaha - Keamanan',
            'Tata Usaha - Pemeliharaan Gedung (Maintenance, Internet, Mekanikal, Elektrikal, dan Plumbing (Saluran Air))',
            'Tata Usaha - Sarana dan Prasarana (Fasilitas Umum & Fasilitas Ruangan)',
            'Wali Kelas - Motivasi Belajar, Sikap Guru, Layanan Pembelajaran, Pengawasan Perkembangan Siswa, Kegiatan Kelas dan Pengelolaan Kelas'
        ];

        $lokasiKendala = [
            'KB Avicenna Pamulang',
            'TK Avicenna Jagakarsa',
            'SD Avicenna Jagakarsa',
            'SMP Avicenna Jagakarsa',
            'SMA Avicenna Jagakarsa',
            'SD Avicenna Cinere',
            'SMP Avicenna Cinere',
            'SMA Avicenna Cinere'
        ];



        $detailKendala = [
            'Koneksi internet lambat di ruang kelas',
            'Perundungan antar siswa di area kantin',
            'Kebocoran air di atap gedung',
            'Guru tidak hadir tanpa keterangan',
            'Siswa tidak mengikuti protokol kesehatan',
            'Komputer rusak di laboratorium',
            'Printer tidak berfungsi di ruang guru',
            'Listrik padam saat jam pelajaran',
            'Tidak ada air di toilet siswa',
            'Lampu tidak berfungsi di koridor',
            'AC tidak dingin di ruang kelas',
            'Proyektor rusak saat presentasi',
            'Siswa tidak mengikuti aturan seragam',
            'Guru terlambat masuk kelas',
            'Fasilitas olahraga tidak memadai',
            'Buku pelajaran tidak tersedia',
            'Kantin tidak bersih',
            'Parkiran tidak tertata rapi',
            'Suara bising dari konstruksi',
            'Ventilasi ruangan kurang baik'
        ];




        for ($i = 0; $i < 200; $i++) {
            $selectedStatus = $status[array_rand($status)];
            $aqrOptions = AqrOption::inRandomOrder()->first();
            Tiket::create([
                'no_tiket' => 'AQR-' . date('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'waktu_proses' => $selectedStatus != 'New' ? now()->subDays(rand(1, 7))->format('Y-m-d H:i:s') : null,
                'waktu_close' => $selectedStatus == 'Selesai' ? now()->subDays(rand(0, 3))->format('Y-m-d H:i:s') : null,
                'no_hp' => '08123456789' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'nama' => 'User Test ' . ($i + 1),
                'email' => 'user' . ($i + 1) . '@test.com',
                'judul_kendala' => $jenisKendala[array_rand($jenisKendala)],
                'lokasi_kendala' => $selectedLokasi = $lokasiKendala[array_rand($lokasiKendala)],
                'detail_kendala' => $detailKendala[array_rand($detailKendala)],
                'status' => $selectedStatus,
                'pengirim' => $selectedPengirim = ['Masyarakat Umum', 'Warga Sekolah'][array_rand(['Masyarakat Umum', 'Warga Sekolah'])],
                'departemen' => $departemen[array_rand($departemen)],
                'jenjang' => explode(' ', $selectedLokasi)[0],
                'lokasi_sekolah' => $lokasiSekolah = explode(' ', $selectedLokasi)[2],
                'rating' => $selectedStatus == 'Selesai' ? rand(3, 5) : null,
                'deskripsi_penilaian' => $selectedStatus == 'Selesai' ? 'Pelayanan memuaskan' : null,
                'created_at' => now()->subDays(rand(0, 28)),
                'admin_humas_id' => $selectedPengirim == 'Masyarakat Umum' && $selectedStatus == 'Proses' ? User::where('jabatan', 'LIKE', '%Humas%')->inRandomOrder()->first()?->id : null,
                'pic_id' => null,
                'masalah_dept' => $aqrOptions->nama_option,
                'option_id' => $selectedPengirim == 'Warga Sekolah' ? $aqrOptions->id : null,
            ]);
        }
    }
}
