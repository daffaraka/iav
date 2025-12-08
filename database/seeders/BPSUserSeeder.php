<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BPSUserSeeder extends Seeder
{
    public function run(): void
    {
        $bpsUsers = [
            ['BPS-0001', 'Irama Aboesoemono', 'Ketua BPS', 'irama.aboesoemono@sekolah-avicenna.sch.id', 'super-admin'],
            ['BPS-0004', 'Imam Sukendro', 'Koord. Bid PSDM, PMP, Digital & Brand Strategy', 'imam.sukendro@sekolah-avicenna.sch.id', 'koordinator'],
            ['BPS-0005', 'Trisari Nur Andita', 'Koord. Bid Operasional & Fasilitas', 'trisari.andita@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0039', 'Nurfatma Linda', 'Koord. Bid Business FAT Management', null, 'staff'],
            ['BPS-0006', 'Ajeng Sekarsari Putri', 'Kepala Unit Audit Internal', 'ajeng.putri@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0059', 'Ajeng Nur Isvianti', 'Staf Dept. Penelitian & Pengembangan Pendidikan Menengah (SMA)', 'ajeng.isvianti@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0058', 'Anisa Nur Rachmawati Suanda', 'Staff People Operation', 'anisa.suanda@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0065', 'Annisa Chandra', 'Staf Dept. Penelitian & Pengembangan Pendidikan Menengah (SMA)', 'annisa.chandra@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0056', 'Ari Adrian', 'Staf Tax Accounting Jagakarsa', 'ari.adrian@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0086', 'Bukhori', 'Driver', null, 'staff'],
            ['BPS-0073', 'Charensia Kasitipaty Retno Wardani', 'Kepala Dept. PSDM', 'charensia.kasitipaty@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0074', 'Citra Pertiwi Ilham', 'Staf Dept. Penelitian & Pengembangan Pendidikan (SD)', 'citra.pertiwi@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0022', 'Delly Fahrizon', 'Staf Audit Internal', 'delly.fahrizon@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0078', 'Dinar Nur Syifa', 'Staf Dept. Penelitian & Pengembangan Menengah (SMP)', null, 'staff'],
            ['BPS-0016', 'Eldita Sari', 'Kepala Dept. Penelitian & Pengembangan Pendidikan Dasar (DIKDAS)', null, 'staff'],
            ['BPS-0076', 'Emma Yulia Sari', 'Staf Pusat Data & Layanan Administrasi Pendidikan Terpadu', null, 'staff'],
            ['BPS-0090', 'Fajrul Fithri', 'Staff IT Support & Jaringan', null, 'super-admin'],
            ['BPS-0096', 'Farah Hanifa Purnomo', 'Staf Dept. Penelitian & Pengembangan Pendidikan Usia Dini (PAUD)', null, 'staff'],
            ['BPS-0045', 'Inneke Sachico Hening', 'Staf General Affair', 'inneke.sachico@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0026', 'Lusiani', 'Kepala Dept. Penelitian & Pengembangan Pendidikan Menengah (SMP)', null, 'staff'],
            ['BPS-0023', 'Mahesa Bahari', 'Resepsionis & Kurir', null, 'staff'],
            ['BPS-0069', 'Makhfudhoh Alfiani Fauziah', 'Staf Dept. Penelitian & Pengembangan Pendidikan Menengah (SMA)', 'makhfudhoh.alfianifauziah@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0081', 'Minal Aidin', 'Driver', null, 'staff'],
            ['BPS-0064', 'Nabilah Salsabila', 'Staf Dept. Penelitian & Pengembangan Pendidikan Menengah (SMP)', 'nabilah.salsabila@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0080', 'Natasya Maharani', 'Staff General Affair', null, 'staff'],
            ['BPS-0030', 'Noviani', 'Account Payable', null, 'staff'],
            ['BPS-0066', 'Nurul Afni Desiliya', 'Staf Tax Accounting Jagakarsa', 'nurulafnidesiliya@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0093', 'Nurul Fathiyyah', 'Kepala Dept. Penelitian & Pengembangan Pendidikan Tingkat KB-TK', null, 'staff'],
            ['BPS-0025', 'Pramesti Ayuningtyas', 'Staff Accounting & Tax', null, 'staff'],
            ['BPS-0036', 'Prapti Leguminosa', 'Kepala Dept. Penelitian & Pengembangan Pendidikan Menengah (SMA)', null, 'staff'],
            ['BPS-0082', 'Ramadhanti Dwi Lestari', 'Staf Admin Keuangan', null, 'staff'],
            ['BPS-0063', 'Ria Dwi Anggraini', 'Staf Perencanaan dan Penganggaran', 'riadwi.anggraini@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0060', 'Rizkyana Hanum', 'Staff Compensation & Benefit', null, 'staff'],
            ['BPS-0083', 'Rochmat Fauza Romadhona', 'Staf Dept. Pemeliharaan dan Pembangunan Gedung', null, 'staff'],
            ['BPS-0054', 'Salsabila Huwaida Asfiyani', 'Staf Dept. General Affairs', 'salsabila.huwaida@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0085', 'Salsabila Zara Mahasin', 'Staff Training & Development', null, 'staff'],
            ['BPS-0035', 'Tommy Hendrawan', 'Kepala Dept. Branding & Transformasi Digital', null, 'super-admin'],
            ['BPS-0088', 'Ulfa Dwiyusridha Hanum', 'Staff Rekruitmen', null, 'staff'],
            ['BPS-0041', 'Vera Nopselia', 'Kepala Kesekretariatan', null, 'staff'],
            ['BPS-0084', 'Verina Yuliani', 'Kepala Dept. Finance', null, 'staff'],
            ['BPS-0057', 'Vian Novianto', 'SPV Branding & Transformasi Digital', null, 'super-admin'],
            ['BPS-0077', 'Vivi Hendryani', 'Kepala Dep. Tax & Accounting', null, 'staff'],
            ['BPS-0070', 'Wafi Wafiroh', 'SPV Leader In Me', 'wafi.wafiroh@sekolah-avicenna.sch.id', 'staff'],
            ['BPS-0091', 'Daffa Raka Mahendra', 'Staff Programmer', null, 'super-admin'],
            ['BPS-0092', 'Muhammad Zulfikriansyah', 'Staf Dept. Pemeliharaan dan Pembangunan Gedung', null, 'staff'],
            ['PK-BPS-0098', 'Ira Ari Nurani', 'Staf Dept. Penelitian & Pengembangan Pendidikan (SD)', null, 'staff'],
            ['PK-BPS-0094', 'Fifi Afriani', 'Staf Admin SarPra (Project Based)', null, 'staff'],
            ['PK-BPS-0097', 'Zahra Hilwa Riansyah Gumay', 'Staf Admin SarPra (Project Based)', null, 'staff']
        ];

        foreach ($bpsUsers as $userData) {
            $email = $userData[3] ?? strtolower(str_replace(' ', '.', $userData[1])) . '@sekolah-avicenna.sch.id';
            $username = strtolower(str_replace(' ', '_', $userData[1]));
            // $nip = substr($userData[0], -4);

            $user = User::create([
                'username' => $username,
                'name' => $userData[1],
                'email' => $email,
                // 'nip' => $nip,
                'password' => Hash::make('password'),
                'kode_karyawan' => $userData[0],
                'jabatan' => $userData[2],
                'departemen' => 'BPS',
                'unit' => 'BPS'
            ]);

            $user->assignRole($userData[4]);
        }
    }
}
