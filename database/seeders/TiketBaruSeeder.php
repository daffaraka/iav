<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tiket;
use App\Models\AqrOption;
use Illuminate\Database\Seeder;

class TiketBaruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori PIC sesuai dengan request: Kepala Sekolah, Kepala TU, dan Kepala Psikolog (di table Psikolog)
        $kategoriPics = ['Kepala Sekolah', 'Kepala TU', 'Psikolog'];

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
            'Membutuhkan tindak lanjut segera terkait hal ini.',
            'Mohon dicek kembali kondisinya.',
            'Kendala terjadi sejak pagi ini, mohon bantuannya.',
            'Tolong segera ditangani agar tidak menghambat.'
        ];

        $pengirimOptions = ['Warga Sekolah'];

        $deptMap = [
            'Kepala Sekolah' => 'Kepala Sekolah',
            'Kepala TU' => 'Tata-Usaha',
            'Psikolog' => 'Psikolog'
        ];

        $count = 1;
        foreach ($kategoriPics as $kategori) {
            // Masing-masing kategori dibuatkan 3 tiket baru
            for ($i = 0; $i < 10; $i++) {
                $aqrOption = AqrOption::query()->where('kategori_pic', $kategori)->inRandomOrder()->first();
                $selectedLokasi = $lokasiKendala[array_rand($lokasiKendala)];
                $selectedPengirim = 'Warga Sekolah';

                Tiket::create([
                    'no_tiket' => 'AQR-NEW-' . date('Ymd') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT),
                    'no_hp' => '081234567' . str_pad($count, 3, '0', STR_PAD_LEFT),
                    'nama' => 'User Baru Test ' . $count,
                    'email' => 'user_baru' . $count . '@test.com',
                    'judul_kendala' => $aqrOption ? $aqrOption->nama_option : 'Kendala ' . $kategori,
                    'lokasi_kendala' => $selectedLokasi,
                    'detail_kendala' => $detailKendala[array_rand($detailKendala)],
                    'status' => 'New',
                    'pengirim' => $selectedPengirim,
                    'departemen' => $deptMap[$kategori],
                    'jenjang' => explode(' ', $selectedLokasi)[0],
                    'lokasi_sekolah' => explode(' ', $selectedLokasi)[2],
                    'created_at' => now(),
                    'waktu_proses' => null,
                    'waktu_close' => null,
                    'admin_humas_id' => null,
                    'pic_id' => null,
                    'masalah_dept' => $aqrOption ? $aqrOption->nama_option : null,
                    'option_id' => $selectedPengirim == 'Warga Sekolah' && $aqrOption ? $aqrOption->id : null,
                ]);

                $count++;
            }
        }
    }
}
