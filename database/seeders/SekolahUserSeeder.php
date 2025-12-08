<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SekolahUserSeeder extends Seeder
{
    public function run(): void
    {
        $sekolahUsers = [
            // SD CINERE
            ['AVI-0217', 'Urai Ramadhani', 'Kepala Sekolah', 'urai.ramadhani@sekolah-avicenna.sch.id', 'Cinere', 'kepala-sekolah'],
            ['AVI-0214', 'Khairunnisa', 'Kurikulum', null, 'Cinere', 'staff'],
            ['AVI-0359', 'Indriani Sasmita', 'Kesiswaan', 'indriani.sasmita@sekolah-avicenna.sch.id', 'Cinere', 'staff'],
            ['AVI-0402', 'Desnitariang Zagoto', 'Psikolog', null, 'Cinere', 'staff'],
            ['AVI-0139', 'Ade Pifianti', 'Wali Kelas', 'ade.pifianti@sekolah-avicenna.sch.id', 'Cinere', 'guru'],
            ['PK-AVI-0526', 'Santi Wahyuni', 'TU', null, 'Cinere', 'tata-usaha'],
            ['AVI-0011', 'Kholillah Ilyas', 'BK', 'kholillah.ilyas@sekolah-avicenna.sch.id', 'Cinere', 'guru'],

            // SMP CINERE
            ['AVI-0245', 'Theresa Dwi Utami', 'Kepala Sekolah', 'theresa.azis@sekolah-avicenna.sch.id', 'Cinere', 'kepala-sekolah'],
            ['AVI-0400', 'Putra Dwi Utama', 'Kurikulum', null, 'Cinere', 'staff'],
            ['AVI-0304', 'Hikmat Kartobi', 'Kesiswaan', 'hikmat.kartobi@sekolah-avicenna.sch.id', 'Cinere', 'staff'],
            ['AVI-0259', 'Laila Tri Nurachma', 'Psikolog & BK', 'laila.tri@sekolah-avicenna.sch.id', 'Cinere', 'staff'],
            ['AVI-0043', 'Fitriah Pancawati', 'Wali Kelas', 'fitriah.pancawati@sekolah-avicenna.sch.id', 'Cinere', 'guru'],
            ['AVI-0052', 'Ahmad Kamal', 'TU', 'ahmad.kamal@sekolah-avicenna.sch.id', 'Cinere', 'tata-usaha'],

            // SMA CINERE
            ['AVI-0101', 'Hadi Awalisa', 'Kepala Sekolah', 'hadi.awalisa@sekolah-avicenna.sch.id', 'Cinere', 'kepala-sekolah'],
            ['AVI-0141', 'Supriyono', 'Kurikulum', 'supriyono@sekolah-avicenna.sch.id', 'Cinere', 'staff'],
            ['AVI-0312', 'Yuria Anggela Irianto', 'Kesiswaan', 'yuria.anggela@sekolah-avicenna.sch.id', 'Cinere', 'staff'],
            ['AVI-0034', 'Darmawati', 'Wali Kelas', 'darmawati@sekolah-avicenna.sch.id', 'Cinere', 'guru'],
            ['AVI-0380', 'Anita Nurul Syahrudin', 'TU', 'anita.nurul@sekolah-avicenna.sch.id', 'Cinere', 'tata-usaha'],
            ['PK-AVI-0512', 'Melania Gaby Purnamasari', 'Humas', null, 'Cinere', 'humas'],

            // TK JAGAKARSA
            ['AVI-0244', 'Disa Chairani', 'Kepala Sekolah', 'disa.chairani@sekolah-avicenna.sch.id', 'Jagakarsa', 'kepala-sekolah'],
            ['AVI-0409', 'Bella Novita', 'Kurikulum', null, 'Jagakarsa', 'staff'],
            ['AVI-0063', 'Nia Kurnia', 'Wali Kelas', 'nia.kurnia@sekolah-avicenna.sch.id', 'Jagakarsa', 'guru'],
            ['PK-AVI-0497', 'Caesar Astria Pusphita', 'Psikolog', null, 'Jagakarsa', 'staff'],
            ['AVI-0443', 'Amalia Nurlatifah', 'TU', null, 'Jagakarsa', 'tata-usaha'],

            // SD JAGAKARSA
            ['AVI-0220', 'Rini Setianingsih', 'Kepala Sekolah', 'rini.setianingsih@sekolah-avicenna.sch.id', 'Jagakarsa', 'kepala-sekolah'],
            ['AVI-0435', 'Irwanto', 'Kurikulum', null, 'Jagakarsa', 'staff'],
            ['AVI-0254', 'Bella Yuliatin Puspita Sari', 'Kesiswaan', null, 'Jagakarsa', 'staff'],
            ['AVI-0461', 'Tira Nalvianti Rahmi', 'Psikolog & BK', null, 'Jagakarsa', 'staff'],
            ['AVI-0119', 'Delvina Bidari', 'Wali Kelas', 'vina.bidari@sekolah-avicenna.sch.id', 'Jagakarsa', 'guru'],
            ['AVI-0054', 'Ahmad Nadir', 'TU', null, 'Jagakarsa', 'tata-usaha'],

            // SMP JAGAKARSA
            ['AVI-0190', 'Abdul Rahman', 'Kepala Sekolah', 'abdul.rahman@sekolah-avicenna.sch.id', 'Jagakarsa', 'kepala-sekolah'],
            ['AVI-0044', 'Aat Fahad Dhimni', 'Kurikulum', 'aat.fahad@sekolah-avicenna.sch.id', 'Jagakarsa', 'staff'],
            ['AVI-0383', 'Mochammad Nurul Alim', 'Kesiswaan', 'nurul.alim@sekolah-avicenna.sch.id', 'Jagakarsa', 'staff'],
            ['PK-AVI-0499', 'Ika Kusumasari', 'Psikolog', null, 'Jagakarsa', 'staff'],
            ['AVI-0037', 'Fianty', 'Wali Kelas', 'fianty@sekolah-avicenna.sch.id', 'Jagakarsa', 'guru'],
            ['AVI-0291', 'Rosaulina', 'TU', 'rosaulina@sekolah-avicenna.sch.id', 'Jagakarsa', 'tata-usaha'],

            // SMA JAGAKARSA
            ['AVI-0133', 'Muqorobin', 'Kepala Sekolah', 'muqorobin@sekolah-avicenna.sch.id', 'Jagakarsa', 'kepala-sekolah'],
            ['AVI-0135', 'Ahmad Fauzi Ridho', 'Kurikulum', 'fauzi.ridho@sekolah-avicenna.sch.id', 'Jagakarsa', 'staff'],
            ['AVI-0399', 'Qonita Sungsang Berliana', 'Kesiswaan', null, 'Jagakarsa', 'staff'],
            ['AVI-0347', 'Setia Lathifah', 'BK', 'setia.lathifah@sekolah-avicenna.sch.id', 'Jagakarsa', 'guru'],
            ['AVI-0002', 'Sri Kasmanawati', 'Wali Kelas', 'sri.kasmanawati@sekolah-avicenna.sch.id', 'Jagakarsa', 'guru'],
            ['AVI-0349', 'Arisca Prescilia', 'TU', null, 'Jagakarsa', 'tata-usaha'],
            ['PK-AVI-0506', 'Tiara Novianti Putri Fadiah', 'Humas', null, 'Jagakarsa', 'humas'],

            // KB PAMULANG
            ['AVI-0012', 'Yanti Fitriyanti', 'Kepala Sekolah', 'fitriyanti.yanti@sekolah-avicenna.sch.id', 'Pamulang', 'kepala-sekolah'],
            ['AVI-0320', 'Prima Relanda', 'Kurikulum', 'prima.relanda@sekolah-avicenna.sch.id', 'Pamulang', 'staff'],
            ['AVI-0111', 'Sri Wahyuni', 'Wali Kelas', 'wahyuni.sri@sekolah-avicenna.sch.id', 'Pamulang', 'guru'],
            ['AVI-0427', 'Khofifah Nurul Mustofa', 'TU', null, 'Pamulang', 'tata-usaha'],

            // SD PAMULANG
            ['AVI-0438', 'Raden Windya Afiany', 'TU', 'windya.afiany@sekolah-avicenna.sch.id', 'Pamulang', 'tata-usaha'],
            ['AVI-0184', 'Eni Dwinanti', 'Koperasi', 'enidwinanti75@gmail.com', 'Pamulang', 'staff']
        ];

        foreach ($sekolahUsers as $userData) {
            $email = $userData[3] ?? strtolower(str_replace(' ', '.', $userData[1])) . '@sekolah-avicenna.sch.id';
            $username = strtolower(str_replace(' ', '_', $userData[1]));
            // $nip = substr($userData[0], -4);

            $user = User::create([
                'username' => $username,
                // 'nip' => $nip,
                'name' => $userData[1],
                'email' => $email,
                'password' => Hash::make('password'),
                'kode_karyawan' => $userData[0],
                'jabatan' => $userData[2],
                'departemen' => $userData[2],
                'unit' => $userData[4]
            ]);

            $user->assignRole($userData[5]);
        }
    }
}
