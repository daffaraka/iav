<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        $karyawan = [
            // =================================================================================================
            // CINERE
            // =================================================================================================

            // --- SD CINERE ---
            ['AVI - 0217', 'Urai Ramadhani', 'Kepala Sekolah', 'urai.ramadhani@sekolah-avicenna.sch.id', 'Cinere', 'SD'],
            ['AVI - 0214', 'Khairunnisa', 'Wakil Kurikulum', '', 'Cinere', 'SD'],
            ['AVI - 0359', 'Indriani Sasmita', 'Wakil Kesiswaan', 'indriani.sasmita@sekolah-avicenna.sch.id', 'Cinere', 'SD'],
            ['AVI - 0139', 'Ade Pifianti', 'Guru Kelas', 'ade.pifianti@sekolah-avicenna.sch.id', 'Cinere', 'SD', '1', 'B'],
            ['AVI - 0161', 'Ayi Ratnawati', 'Guru Kelas', 'ayi.ratnawati@sekolah-avicenna.sch.id', 'Cinere', 'SD', '1', 'A'],
            ['AVI - 0337', 'Dea Aprilia Choraya', 'Guru Pendamping Kelas', 'dea.aprilia@sekolah-avicenna.sch.id', 'Cinere', 'SD'],
            ['AVI - 0402', 'Desnitariang Zagoto', 'Kepala Psikolog', '', 'Cinere', 'SD'],
            ['AVI - 0393', 'Ilham Eka Permana', 'Guru Seni Musik', '', 'Cinere', 'SD', '5', 'B'],
            ['AVI - 0423', 'Indra Kartika Sari', 'Guru Pendamping Kelas', '', 'Cinere', 'SD'],
            ['AVI - 0344', 'Kania Nur Anggraeni', 'Guru Kelas', 'kania.nuranggraeni@sekolah-avicenna.sch.id', 'Cinere', 'SD'],
            ['AVI - 0197', 'Novianti Dwi Pangesti', 'Guru TIK', 'novianti.pangesti@sekolah-avicenna.sch.id', 'Cinere', 'SD', '4', 'A'],
            ['AVI - 0449', 'Mei Nurul Hidayah', 'Guru Bahasa Indonesia', '', 'Cinere', 'SD', '3', 'A'],
            ['AVI - 0405', 'R. Luthfiyyah Eka Augustin', 'Guru IPS', '', 'Cinere', 'SD', '5', 'A'],
            ['AVI - 0314', 'Ria Hartanti Sinaga', 'Guru Matematika', '', 'Cinere', 'SD', '2', 'A'],
            ['AVI - 0429', 'Ryani Andryani', 'Guru Kelas', '', 'Cinere', 'SD'],
            ['AVI - 0218', 'Siti Bagja Muawanah', 'Guru Bahasa Indonesia', 'siti.bagja@sekolah-avicenna.sch.id', 'Cinere', 'SD', '6', 'A'],
            ['AVI - 0455', 'Syahrindra Warid Abdillah', 'Guru Matematika', '', 'Cinere', 'SD'],
            ['AVI - 0426', 'Shafira Aulia Puteri', 'Psikolog Sekolah', '', 'Cinere', 'SD'],
            ['PK - AVI - 0416', 'Chairunissa', 'Guru Pendamping Kelas', '', 'Cinere', 'SD', '2', 'B'],
            ['PK - AVI- 0527', 'Ignasius Dandur Hagul', 'Guru Agama Katolik', '', 'Cinere', 'SD'],
            ['PK - AVI - 0060', 'M.Tomo', 'Guru Agama Islam', '', 'Cinere', 'SD'],
            ['PK - AVI - 0507', 'Maidiati', 'Guru Bahasa Inggris', '', 'Cinere', 'SD'],
            ['PK - AVI- 0524', 'Nanda Mulat Pramesthi', 'Guru Kelas (Infal)', '', 'Cinere', 'SD'],
            ['PK - AVI - 0483', 'Riandi Suhud Rohmatullah', 'Guru Olahraga', '', 'Cinere', 'SD'],
            ['PK - AVI - 0472', 'Rinny Irianti', 'Guru IPA', '', 'Cinere', 'SD', '6', 'B'],
            ['PK - AVI - 0319', 'Sarwati Wagiono', 'Guru Seni Rupa', '', 'Cinere', 'SD'],
            ['PK - AVI - 0498', 'Siti Mutiara', 'Guru Bahasa Indonesia (inval)', '', 'Cinere', 'SD'],
            ['PK - AVI - 0484', 'Setyo Wibowo', 'Guru Bahasa Indonesia', '', 'Cinere', 'SD', '3', 'B'],
            ['AVI - 0091', 'Malakim', 'Pramubakti', '', 'Cinere', 'SD'],
            ['PK - AVI- 0526', 'Santi Wahyuni', 'Staf Admin Tata Usaha SD', '', 'Cinere', 'SD'],
            ['PK - AVI - 0509', 'Fitri Mutiara', 'Staf Sarpra', '', 'Cinere', 'SD'],

            // --- SMP CINERE ---
            ['AVI - 0245', 'Theresa Dwi Utami', 'Kepala Sekolah', 'theresa.azis@sekolah-avicenna.sch.id', 'Cinere', 'SMP'],
            ['AVI - 0400', 'Putra Dwi Utama', 'Wakil Kurikulum', '', 'Cinere', 'SMP'],
            ['AVI - 0304', 'Hikmat Kartobi', 'Wakil Kesiswaan', 'hikmat.kartobi@sekolah-avicenna.sch.id', 'Cinere', 'SMP'],
            ['AVI - 0264', 'Erwin Setyawan', 'Guru Olahraga', 'erwin.setyawan@sekolah-avicenna.sch.id', 'Cinere', 'SMP', '9', 'A'],
            ['AVI - 0043', 'Fitriah Pancawati', 'Guru Bahasa Indonesia', 'fitriah.pancawati@sekolah-avicenna.sch.id', 'Cinere', 'SMP', '9', 'B'],
            ['AVI - 0407', 'Khasbi Abdul Malik', 'Guru Agama Islam', '', 'Cinere', 'SMP', '8', 'B'],
            ['AVI - 0011', 'Kholillah Ilyas', 'Guru BK', 'kholillah.ilyas@sekolah-avicenna.sch.id', 'Cinere', 'SMP', '7', 'C'],
            ['AVI - 0259', 'Laila Tri Nurachma', 'Kepala Psikolog', 'laila.tri@sekolah-avicenna.sch.id', 'Cinere', 'SMP', '8', 'A'],
            ['PK - AVI - 0440', 'Dian Soraya Saputra', 'Guru Bahasa Inggris', '', 'Cinere', 'SMP'],
            ['PK - AVI- 0539', 'Safitri Nuria Mawadah', 'Guru Matematika', '', 'Cinere', 'SMP'],
            ['PK - AVI - 0486', 'Farih Ibnu Iskandar', 'Guru Seni Musik', '', 'Cinere', 'SMP', '7', 'B'],
            ['AVI - 0457', 'Ria Sulistyawati', 'Guru Seni Rupa', '', 'Cinere', 'SMP', '7', 'A'],
            ['AVI - 0137', 'Rhosid Fajar Ismail', 'Guru Biologi', 'rhosid.fajar@sekolah-avicenna.sch.id', 'Cinere', 'SMP'],
            ['PK - AVI- 0533', 'Sinta Kristiani', 'Guru IPS', '', 'Cinere', 'SMP'],
            ['PK - AVI - 0508', 'Alvin Syahrul Fauzan', 'Guru Fisika', '', 'Cinere', 'SMP', '9', 'C'],
            ['PK - AVI- 0537', 'Widodo Herianto', 'Guru TIK', '', 'Cinere', 'SMP'],
            ['PK - AVI- 0536', 'Muhammad Farhan Ramadhan', 'Guru PKn', '', 'Cinere', 'SMP'],
            ['AVI - 0052', 'Ahmad Kamal', 'Staf Admin Tata Usaha SMP', 'ahmad.kamal@sekolah-avicenna.sch.id', 'Cinere', 'SMP'],
            ['AVI - 0085', 'Atih Rismawati', 'Staf Perpustakaan SD & SMP', 'atih.rismawati@sekolah-avicenna.sch.id', 'Cinere', 'SMP'],
            ['AVI - 0013', 'Nurabdillah', 'Pramubakti', '', 'Cinere', 'SMP'],
            ['AVI - 0211', 'Vira Irmaya', 'Staf Keuangan', 'vira.irmaya@sekolah-avicenna.sch.id', 'Cinere', 'SMP'],
            ['PK-AVI - 0489', 'Fatul Umam', 'Teknisi Jaringan', '', 'Cinere', 'SMP'],

            // --- SMA CINERE ---
            ['AVI - 0101', 'Hadi Awalisa', 'Kepala Sekolah', 'hadi.awalisa@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0141', 'Supriyono', 'Wakil Kurikulum', 'supriyono@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0312', 'Yuria Anggela Irianto', 'Kepala Psikolog', 'yuria.anggela@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0062', 'Akhmad Suhaeli', 'Guru Agama Islam', 'akhmad.suhaeli@sekolah-avicenna.sch.id', 'Cinere', 'SMA', '10', 'C'],
            ['AVI - 0034', 'Darmawati', 'Guru Bahasa Indonesia', 'darmawati@sekolah-avicenna.sch.id', 'Cinere', 'SMA', '11', 'B'],
            ['AVI - 0028', 'Dewi Suryana', 'Guru Kimia', 'dewi.suryana@sekolah-avicenna.sch.id', 'Cinere', 'SMA', '12', 'B'],
            ['AVI - 0195', 'Dwi Haryanthi', 'Guru Bahasa Mandarin', 'dwi.haryanthi@sekolah-avicenna.sch.id', 'Cinere', 'SMA', '11', 'A'],
            ['AVI - 0396', 'Ekamara Kinasih', 'Guru Matematika', '', 'Cinere', 'SMA'],
            ['AVI - 0330', 'Firman Riyadi', 'Guru TIK', 'firman.riyadi@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0030', 'Istianah', 'Guru Ekonomi', 'istianah@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0331', 'Khairul Sani', 'Guru Sejarah', 'khairul.sani@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0162', 'Nurmalianis', 'Guru Matematika', 'nurmalianis@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0386', 'Rini Ariesta Mangunsong', 'Guru Bahasa Inggris', 'rini.ariesta@sekolah-avicenna.sch.id', 'Cinere', 'SMA', '11', 'C'],
            ['AVI - 0257', 'Septian Olim', 'Guru Seni Musik', 'septian.olim@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0413', 'Siti Zulaikha', 'Guru Fisika', '', 'Cinere', 'SMA', '10', 'A'],
            ['AVI - 0027', 'Yosita Sisvawaty', 'Guru PKn', 'yosita.sisvawaty@sekolah-avicenna.sch.id', 'Cinere', 'SMA', '11', 'D'],
            ['PK - AVI- 0535', 'Annisa Dwiartha Pangestuti', 'Guru Seni Rupa', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0494', 'Farah Fauzziyyah Isnaeni', 'Guru Geografi', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0451', 'Awlia Dwi Rachma', 'Guru Matematika', '', 'Cinere', 'SMA', '10', 'D'],
            ['PK - AVI- 0532', 'Yosaphat Benny Suryaningpram', 'Guru Bahasa Inggris', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0436', 'Muhamad Feby Ulul Azmi', 'Guru Olahraga', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0473', 'Muhammad Zakaria', 'Guru Bahasa Jepang', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0361', 'Ni Wayan Mega Astini', 'Guru Agama Hindu', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0467', 'Putri Sapitri', 'Guru BK', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0482', 'Rahmat Kusharyadi', 'Guru Matematika', '', 'Cinere', 'SMA', '10', 'B'],
            ['PK - AVI- 0528', 'Faeri Irwan Putra Zega', 'Guru Agama Kristen Protestan', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0496', 'Ainul Mardhiyah', 'Guru Bahasa Indonesia', '', 'Cinere', 'SMA'],
            ['PK - AVI- 0529', 'Raudhatul Aslami', 'Guru Bahasa Indonesia', '', 'Cinere', 'SMA'],
            ['PK - AVI- 0522', 'Wirasturini Tjakrawedaja', 'Guru Biologi', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0460', 'Zefi Khomara', 'Guru Sosiologi', '', 'Cinere', 'SMA'],
            ['AVI - 0380', 'Anita Nurul Syahrudin', 'Kepala Tata Usaha', 'anita.nurul@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0367', 'Dedit Krisdianto', 'Teknisi Kelistrikan', 'dedit.krisdianto@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['AVI - 0410', 'Gita Aulia Darma Putri', 'Staf Keuangan', '', 'Cinere', 'SMA'],
            ['AVI - 0503', 'Hayrunisa', 'Staff Kebersihan & Keamanan', '-', 'Cinere', 'SMA'],
            ['AVI - 0087', 'Yubi Yubaidillah', 'Teknisi Pengelolaan Gedung', 'yubi.yubaidillah@sekolah-avicenna.sch.id', 'Cinere', 'SMA'],
            ['PK - AVI - 0512', 'Melania Gaby Purnamasari', 'Staf Humas', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0511', 'Arsita Dewi Ambarwati', 'Suster', '', 'Cinere', 'SMA'],
            ['PK - AVI - 0464', 'Dwi Andriyan', 'Staf Perpustakaan', '', 'Cinere', 'SMA'],
            ['PK - AVI- 0521', 'Yosa Hilmawan', 'Teknisi Listrik', '', 'Cinere', 'SMA'],

            // =================================================================================================
            // JAGAKARSA
            // =================================================================================================

            // --- TK JAGAKARSA ---
            ['AVI - 0244', 'Disa Chairani', 'Kepala Sekolah', 'disa.chairani@sekolah-avicenna.sch.id', 'Jagakarsa', 'TK'],
            ['AVI - 0409', 'Bella Novita', 'Wakil Kepala Sekolah', '', 'Jagakarsa', 'TK'],
            ['AVI - 0439', 'Asiah Musthofawi', 'Guru TK', 'asiah.musthofawi@sekolah-avicenna.sch.id', 'Jagakarsa', 'TK'],
            ['AVI - 0308', 'Hira Noor Madinah', 'Guru TK', 'hira.noor@sekolah-avicenna.sch.id', 'Jagakarsa', 'TK'],
            ['AVI - 0063', 'Nia Kurnia', 'Guru TK', 'nia.kurnia@sekolah-avicenna.sch.id', 'Jagakarsa', 'TK'],
            ['AVI - 0058', 'Siti Zulaeha', 'Guru TK', 'siti.zulaeha@sekolah-avicenna.sch.id', 'Jagakarsa', 'TK'],
            ['PK - AVI - 0497', 'Caesar Astria Pusphita', 'Kepala Psikolog', '', 'Jagakarsa', 'TK'],
            ['AVI - 0443', 'Amalia Nurlatifah', 'Staf Admin Tata Usaha TK', '', 'Jagakarsa', 'TK'],

            // --- SD JAGAKARSA ---
            ['AVI - 0220', 'Rini Setianingsih', 'Kepala Sekolah', 'rini.setianingsih@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD'],
            ['AVI - 0254', 'Bella Yuliatin Puspita Sari', 'Wakasis', '', 'Jagakarsa', 'SD'],
            ['AVI - 0435', 'Irwanto', 'Wakakur', '', 'Jagakarsa', 'SD'],
            ['AVI - 0339', 'Salma Oktaviama', 'Guru SD', 'salma.oktaviama@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '2', 'A'],
            ['AVI - 0394', 'Rahayu Milasari', 'Guru PKn', '', 'Jagakarsa', 'SD', '5', 'C'],
            ['AVI - 0064', 'Agus B Mamur', 'Guru Matematika', 'agus.bm@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '6', 'A'],
            ['AVI - 0074', 'Agus Purwanto', 'Guru IPS', 'agus.purwanto@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '5', 'B'],
            ['AVI - 0121', 'Ainul Hana', 'Guru Bahasa Inggris', 'ainul.hana@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '6', 'B'],
            ['AVI - 0311', 'Candra Triokayana', 'Guru Seni Musik', 'candra.triokayana@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '4', 'B'],
            ['AVI - 0390', 'Cici Sri Haryani', 'Guru Kelas', '', 'Jagakarsa', 'SD', '2', 'C'],
            ['AVI - 0119', 'Delvina Bidari', 'Guru Kelas', 'vina.bidari@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '1', 'B'],
            ['AVI - 0384', 'Dhimas Risang Bramansya', 'Guru Kelas', '', 'Jagakarsa', 'SD', '2', 'B'],
            ['AVI - 0424', 'Dian Pebriana Silalahi', 'Guru Bahasa Indonesia', '', 'Jagakarsa', 'SD', '6', 'C'],
            ['AVI - 0360', 'Hasanudin', 'Guru Olahraga', '', 'Jagakarsa', 'SD', '3', 'C'],
            ['AVI - 0088', 'Maman', 'Guru Matematika', 'maman.ar@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '3', 'A'],
            ['AVI - 0289', 'Maratus Sholeha', 'Guru Matematika', 'maratus.sholehah@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '3', 'B'],
            ['AVI - 0076', 'Mulyati', 'Guru Kelas', 'mulyati@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '1', 'A'],
            ['AVI - 0167', 'Murniyasih', 'Guru IPA', '#N/A', 'Jagakarsa', 'SD', '5', 'A'],
            ['AVI - 0036', 'Toto Wikarto', 'Guru Bahasa Indonesia', 'toto@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD'],
            ['AVI - 0461', 'Tira Nalvianti Rahmi', 'Psikolog Sekolah', '', 'Jagakarsa', 'SD'],
            ['AVI - 0415', 'Wiwin Widianingsih', 'Guru Olahraga', '', 'Jagakarsa', 'SD', '4', 'C'],
            ['AVI - 0114', 'Yulia Endang Purnamawati', 'Guru Kelas', 'yulia.endang@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD'],
            ['AVI - 0105', 'Zainudin', 'Guru Agama Islam', 'zainudin.alazis@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD', '4', 'A'],
            ['PK - AVI - 0487', 'Adhika Puspitasari', 'Guru Pendamping Kelas', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0476', 'Annisa Gusmianti', 'Guru Pendamping Kelas', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0515', 'Ayu Kartika Sari', 'Guru SD', '', 'Jagakarsa', 'SD'],
            ['PK - AVI- 0519', 'Ayu Kristina S.', 'Guru SD', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0493', 'Fanisa Qorina Zahro', 'Guru Bahasa Indonesia', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0514', 'Galih Priyadi', 'Guru Pendamping Kelas', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0477', 'Kukuh Noor Romadhon', 'Guru PKn', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0516', 'Ulva Nurul Madihah', 'Guru Bahasa Indonesia', '', 'Jagakarsa', 'SD'],
            ['PK - AVI- 0534', 'Egi Yolanda Putri', 'Kepala Psikolog', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0441', 'Ransa Raudatul Wardah', 'Guru Pendamping Kelas', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0459', 'Suhelin Setiyaningsih', 'Guru Pendamping Kelas', '', 'Jagakarsa', 'SD', '1', 'C'],
            ['PK - AVI - 0510', 'Syerin Nur Fadila', 'Inval PGSD', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0480', 'Teguh Iswanto', 'Guru Agama Islam', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0465', 'Twiska Ajeng Maharani', 'Guru TIK', '', 'Jagakarsa', 'SD'],
            ['AVI - 0054', 'Ahmad Nadir', 'Staf Admin Tata Usaha', '', 'Jagakarsa', 'SD'],
            ['AVI - 0158', 'Astuti', 'Staf Keuangan', 'astuti@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD'],
            ['AVI - 0202', 'Heru Pebriyanto', 'Staf Sarpra', 'heru.febriyanto@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD'],
            ['AVI - 0053', 'Jamaludin', 'Kurir & Pramubakti', '', 'Jagakarsa', 'SD'],
            ['AVI - 0047', 'Kriswihari', 'Staf Keuangan', 'kriswihari@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD'],
            ['AVI - 0204', 'Lia Oktafianty', 'Staf Sarpra', 'lia.oktafianty@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD'],
            ['AVI - 0096', 'Royani', 'Pramubakti', '', 'Jagakarsa', 'SD'],
            ['AVI - 0392', 'Fikri Fadlu Rohman Aziz', 'Teknisi Jaringan', '', 'Jagakarsa', 'SD'],
            ['AVI - 0388', 'Novi Anggraeni', 'Staf Perpustakaan', 'novi.anggraeni@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD'],
            ['AVI - 0358', 'Noviana', 'Suster', 'noviana@sekolah-avicenna.sch.id', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0505', 'Rahmat Hidayat', 'Teknisi Jaringan Listrik', '', 'Jagakarsa', 'SD'],
            ['PK - AVI - 0544','Sinta Johan Kartika', 'Staff Humas', '', 'Jagakarsa', 'SMA'],

            // --- SMP JAGAKARSA ---
            ['AVI - 0190', 'Abdul Rahman', 'Kepala Sekolah', 'abdul.rahman@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP'],
            ['AVI - 0044', 'Aat Fahad Dhimni', 'Wakil Kurikulum', 'aat.fahad@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP'],
            ['AVI - 0383', 'Mochammad Nurul Alim', 'Wakil Kesiswaan', 'nurul.alim@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP'],
            ['AVI - 0369', 'Cito Darmawan', 'Guru Olahraga', 'cito.dermawan@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP'],
            ['AVI - 0324', 'Endah Saputri', 'Guru Biologi', 'endah.saputri@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP', '7', 'B'],
            ['AVI - 0037', 'Fianty', 'Guru Bahasa Indonesia', 'fianty@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP', '8', 'C'],
            ['PK - AVI- 0530', 'Arini Soesatyo Putri', 'Guru Matematika', '', 'Jagakarsa', 'SMP'],
            ['AVI - 0333', 'Fitri Handayani', 'Guru TIK', 'fitri.handayani@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP', '9', 'C'],
            ['AVI - 0395', 'Gusti Rama Dwi Putra', 'Guru PKn', '', 'Jagakarsa', 'SMP', '9', 'A'],
            ['AVI - 0171', 'Indra Virsa Permana', 'Guru Seni Rupa', 'indra.virsa@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP', '8', 'B'],
            ['AVI - 0032', 'Kusmayadi Kurniawan', 'Guru Ekonomi', 'kusmayadi@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP'],
            ['AVI - 0125', 'Noto Prayitno', 'Guru Fisika', 'noto.prayitno@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP', '7', 'A'],
            ['AVI - 0288', 'Ryoko Perdana', 'Guru Musik', 'ryoko.perdana@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP'],
            ['AVI - 0365', 'Syifa Fauziah', 'Guru Bahasa Indonesia', 'syifa.fauziah@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP', '7', 'C'],
            ['AVI - 0103', 'Tia Setiawati', 'Guru Matematika', 'tia.setiawati@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP', '9', 'B'],
            ['PK - AVI - 0499', 'Ika Kusumasari', 'Kepala Psikolog', '', 'Jagakarsa', 'SMP'],
            ['PK - AVI - 0466', 'Nindy Pineristya S', 'Guru Bahasa Inggris', '', 'Jagakarsa', 'SMP', '8', 'A'],
            ['PK - AVI - 0452', 'Ratih Ayu Wulandari', 'Guru Bahasa Mandarin', '', 'Jagakarsa', 'SMP'],
            ['PK - AVI - 0462', 'Yerika Arum Pertiwi', 'Guru BK', '', 'Jagakarsa', 'SMP'],
            ['AVI - 0291', 'Rosaulina', 'Kepala Tata Usaha', 'rosaulina@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP'],
            ['AVI - 0186', 'Mitha Yunita', 'Staf Keuangan AP', 'mitha.yunita@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP'],
            ['AVI - 0152', 'Nurjaya Apriyadi', 'Staf Admin Tata Usaha SMP', 'nurjaya.apriyadi@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMP'],
            ['AVI - 0326', 'Wardi Slamet Riyadi', 'Pramubakti', '', 'Jagakarsa', 'SMP'],

            // --- SMA JAGAKARSA ---
            ['AVI - 0133', 'Muqorobin', 'Kepala Sekolah', 'muqorobin@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA'],
            ['AVI - 0135', 'Ahmad Fauzi Ridho', 'Wakil Kurikulum', 'fauzi.ridho@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA', '11', 'A'],
            ['AVI - 0399', 'Qonita Sungsang Berliana', 'Wakil Kesiswaan', '', 'Jagakarsa', 'SMA'],
            ['AVI - 0382', 'Anggun Pertiwi', 'Guru Matematika', '', 'Jagakarsa', 'SMA'],
            ['AVI - 0090', 'Dya Marulina', 'Guru Ekonomi', 'dya.marulina@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA', '12', 'B'],
            ['AVI - 0389', 'Dyah Ayu Dewi Lestari', 'Guru Sosiologi', '', 'Jagakarsa', 'SMA'],
            ['AVI - 0340', 'Eka Juliana Maharani', 'Guru Seni Musik', 'eka.juliana@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA'],
            ['AVI - 0303', 'Elma Rafika', 'Guru Fisika', 'elma.rafika@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA'],
            ['AVI - 0341', 'Iis Ismayati', 'Guru Matematika', 'iis.ismayati@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA', '12', 'D'],
            ['AVI - 0102', 'Irma', 'Guru Biologi', 'irma@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA', '10', 'A'],
            ['AVI - 0187', 'Maulana Rizal', 'Guru Olahraga', 'maulana.rizal@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA'],
            ['AVI - 0364', 'Meta Saputra', 'Guru Agama', 'meta.saputra@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA', '10', 'B'],
            ['AVI - 0432', 'Oki Erfana Sulistyarini', 'Guru Ekonomi', '', 'Jagakarsa', 'SMA', '10', 'D'],
            ['AVI - 0199', 'Parwati Cemplon', 'Guru Bahasa Jepang', 'parwati.cemplon@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA'],
            ['AVI - 0375', 'Romdani Nur Sidiq', 'Guru Antropologi', 'romdani.sidiq@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA', '11', 'C'],
            ['AVI - 0412', 'Rahmawati', 'Guru Bahasa Indonesia', '', 'Jagakarsa', 'SMA', '12', 'A'],
            ['AVI - 0397', 'Ronny Ardianto', 'Guru Bahasa Indonesia', '', 'Jagakarsa', 'SMA'],
            ['AVI - 0009', 'Rusnaini', 'Guru Sejarah', 'rusnaini@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA'],
            ['AVI - 0055', 'Sadelih', 'Guru Geografi', 'sadelih@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA'],
            ['AVI - 0347', 'Setia Lathifah', 'Guru BK', 'setia.lathifah@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA', '11', 'D'],
            ['AVI - 0002', 'Sri Kasmanawati', 'Bahasa Indonesia', 'sri.kasmanawati@sekolah-avicenna.sch.id', 'Jagakarsa', 'SMA'],
            ['AVI - 0401', 'Thania Arista Putri', 'Guru Matematika', '', 'Jagakarsa', 'SMA', '11', 'B'],
            ['PK - AVI- 0525', 'Albertus Bagus Jati Tyasseta', 'Guru Seni Rupa', '', 'Jagakarsa', 'SMA'],
            ['PK - AVI- 0531', 'Rofanny Haznatu Parwa Karunia', 'Kepala Psikolog', '', 'Jagakarsa', 'SMA'],
            ['PK - AVI - 0454', 'Intan Asri Cahyanti', 'Guru Matematika', '', 'Jagakarsa', 'SMA', '10', 'C'],
            ['PK - AVI - 0495', 'Rizka Septin Hidayat', 'Guru Bahasa Inggris', '', 'Jagakarsa', 'SMA'],
            ['PK - AVI - 0500', 'Dwi Putri Anggun Kumala Sari', 'Guru Bahasa Inggris', '', 'Jagakarsa', 'SMA', '12', 'C'],
            ['PK - AVI - 0518', 'Nila Asmila Sari', 'Guru Kimia', '', 'Jagakarsa', 'SMA'],
            ['AVI - 0433', 'Andayani Wisnuwardani', 'Staf Perpustakaan', '', 'Jagakarsa', 'SMA'],
            ['AVI - 0349', 'Arisca Prescilia', 'Staf Admin Tata Usaha SMA', '', 'Jagakarsa', 'SMA'],
            ['AVI - 0045', 'NurSahid', 'Kurir & Pramubakti', '', 'Jagakarsa', 'SMA'],
            ['PK - AVI - 0504', 'Alex Sander', 'SPV Kebersihan dan Keamanan', '', 'Jagakarsa', 'SMA'],
            ['PK - AVI - 0506', 'Tiara Novianti Putri Fadiah', 'Staff Humas', '', 'Jagakarsa', 'SMA'],
            ['PK - AVI - 0513', 'Rafi Fadillah Rachmat', 'Public Relation & Digital Marketing', '', 'Jagakarsa', 'SMA'],

            // =================================================================================================
            // PAMULANG
            // =================================================================================================

            // --- KB PAMULANG ---
            ['AVI - 0012', 'Yanti Fitriyanti', 'Kepala Sekolah', 'fitriyanti.yanti@sekolah-avicenna.sch.id', 'Pamulang', 'KB'],
            ['AVI - 0320', 'Prima Relanda', 'Wakil Kepala Sekolah', 'prima.relanda@sekolah-avicenna.sch.id', 'Pamulang', 'KB'],
            ['AVI - 0111', 'Sri Wahyuni', 'Guru KB', 'wahyuni.sri@sekolah-avicenna.sch.id', 'Pamulang', 'KB'],
            ['AVI - 0398', 'Anggie Riski Pratiwi', 'Guru KB', '', 'Pamulang', 'KB'],
            ['AVI - 0422', 'Dian Kurniasih', 'Guru KB', '', 'Pamulang', 'KB'],
            ['AVI - 0446', 'Meida Dwi Satmanda', 'Guru KB', '', 'Pamulang', 'KB'],
            ['AVI - 0430', 'Rahma Nur Fauziah', 'Guru KB', '', 'Pamulang', 'KB'],
            ['PK - AVI- 0517', 'Hana Sausan Ningrum', 'Guru KB', '', 'Pamulang', 'KB'],
            ['PK - AVI - 0474', 'Niken Rahmita Sari', 'Staf Admin KB', '', 'Pamulang', 'KB'],
            ['AVI - 0019', 'Arafiq', 'Pramubakti', '', 'Pamulang', 'KB'],
            ['AVI - 0427', 'Khofifah Nurul Mustofa', 'Staf Admin TKIA', '', 'Pamulang', 'KB'],

            // --- SD PAMULANG ---
            ['AVI - 0438', 'Raden Windya Afiany', 'Kepala Tata Usaha', 'windya.afiany@sekolah-avicenna.sch.id', 'Pamulang', 'SD'],
            ['AVI - 0015', 'Abdul rohman', 'Teknisi Pengelolaan Gedung', '', 'Pamulang', 'SD'],
            ['AVI - 0184', 'Eni Dwinanti', 'Staf Admin Tata Usaha', 'enidwinanti75@gmail.com', 'Pamulang', 'SD'],
            ['AVI - 0356', 'Ika Nur Hardiani', 'Staf Keuangan AR', 'ika.hardiani@sekolah-avicenna.sch.id', 'Pamulang', 'SD'],
            ['AVI - 0203', 'Maman Fathurohman', 'Staf Admin SDIA', '', 'Pamulang', 'SD'],
            ['AVI - 0293', 'Muzdalifah', 'Staf Sarpra', 'muzdalifah@sekolah-avicenna.sch.id', 'Pamulang', 'SD'],
            ['AVI - 0021', 'Parto', 'Teknisi Kelistrikan', '', 'Pamulang', 'SD'],
            ['AVI - 0251', 'Ridwan Saputra', 'Kurir & Pramubakti', '', 'Pamulang', 'SD'],
            ['AVI - 0110', 'Rika Pamungkas', 'Suster', '', 'Pamulang', 'SD'],
            ['AVI - 0468', 'Reza Muhammad Fiqri', 'Teknisi Jaringan', '', 'Pamulang', 'SD'],
            ['AVI - 0140', 'Tarmizi Tahir', 'Pramubakti', '', 'Pamulang', 'SD'],
            ['AVI - 0108', 'Tanti Dwi Romawati', 'Staf Keuangan AP', 'tanti.romawati@sekolah-avicenna.sch.id', 'Pamulang', 'SD'],

            // =================================================================================================
            // BPS
            // =================================================================================================
            ['BPS - 0001', 'Irama Aboesoemono', 'Ketua BPS', 'irama.aboesoemono@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0004', 'Imam Sukendro', 'Koord. Bid PSDM, PMP, Digital & Brand Strategy', 'imam.sukendro@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0005', 'Trisari Nur Andita', 'Koord. Bid Operasional & Fasilitas', 'trisari.andita@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0039', 'Nurfatma Linda', 'Koord. Bid Business FAT (Finance, Accounting, Tax) Management', '', 'BPS', 'BPS'],
            ['BPS - 0006', 'Ajeng Sekarsari Putri', 'Kepala Unit Audit Internal', 'ajeng.putri@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0059', 'Ajeng Nur Isvianti', 'Staf Dept. Penelitian & Pengembangan Pendidikan Menengah (SMA).', 'ajeng.isvianti@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0058', 'Anisa Nur Rachmawati Suanda', 'Staff People Operation', 'anisa.suanda@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0065', 'Annisa Chandra', 'Staf Dept. Penelitian & Pengembangan Pendidikan Menengah (SMA).', 'annisa.chandra@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0056', 'Ari Adrian', 'Staf Tax Accounting Jagakarsa', 'ari.adrian@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0086', 'Bukhori', 'Driver', '', 'BPS', 'BPS'],
            ['BPS - 0073', 'Charensia Kasitipaty Retno Wardani', 'Kepala Dept. PSDM', 'charensia.kasitipaty@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0074', 'Citra Pertiwi Ilham', 'Staf Dept. Penelitian & Pengembangan Pendidikan (SD)', 'citra.pertiwi@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0022', 'Delly Fahrizon', 'Staf Audit Internal', 'delly.fahrizon@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0078', 'Dinar Nur Syifa', 'Staf Dept. Penelitian & Pengembangan Menengah (SMP)', '', 'BPS', 'BPS'],
            ['BPS - 0016', 'Eldita Sari', 'Kepala Dept. Penelitian & Pengembangan Pendidikan Dasar (DIKDAS)', '', 'BPS', 'BPS'],
            ['BPS - 0076', 'Emma Yulia Sari', 'Staf Pusat Data & Layanan Administrasi Pendidikan Terpadu', '', 'BPS', 'BPS'],
            ['BPS - 0090', 'Fajrul Fithri', 'Staff IT Support & Jaringan', '', 'BPS', 'BPS'],
            ['BPS - 0096', 'Farah Hanifa Purnomo', 'Staf Dept. Penelitian & Pengembangan Pendidikan Usia Dini (PAUD)', '', 'BPS', 'BPS'],
            ['BPS - 0045', 'Inneke Sachico Hening', 'Staf General Affair', 'inneke.sachico@sekolah-avicenna.sch.id,', 'BPS', 'BPS'],
            ['BPS - 0026', 'Lusiani', 'Kepala Dept. Penelitian & Pengembangan Pendidikan Menengah (SMP)', '', 'BPS', 'BPS'],
            ['BPS - 0023', 'Mahesa Bahari', 'Resepsionis & Kurir', '', 'BPS', 'BPS'],
            ['BPS - 0069', 'Makhfudhoh Alfiani Fauziah', 'Staf Dept. Penelitian & Pengembangan Pendidikan Menengah (SMA).', 'makhfudhoh.alfianifauziah@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0081', 'Minal Aidin', 'Driver', '', 'BPS', 'BPS'],
            ['BPS - 0064', 'Nabilah Salsabila', 'Staf Dept. Penelitian & Pengembangan Pendidikan Menengah (SMP)', 'nabilah.salsabila@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0080', 'Natasya Maharani', 'Staff General Affair', '', 'BPS', 'BPS'],
            ['BPS - 0030', 'Noviani', 'Account Payable', '', 'BPS', 'BPS'],
            ['BPS - 0066', 'Nurul Afni Desiliya', 'Staf Tax Accounting Jagakarsa', 'nurulafnidesiliya@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0093', 'Nurul Fathiyyah', 'Kepala Dept. Penelitian & Pengembangan Pendidikan Tingkat KB-TK', '', 'BPS', 'BPS'],
            ['BPS - 0025', 'Pramesti Ayuningtyas', 'Staff Accounting & Tax', '', 'BPS', 'BPS'],
            ['BPS - 0036', 'Prapti Leguminosa', 'Kepala Psikolog , Kepala Dept. Penelitian & Pengembangan Pendidikan Menengah (SMA).', '', 'BPS', 'BPS'],
            ['BPS - 0082', 'Ramadhanti Dwi Lestari', 'Staf Admin Keuangan', '', 'BPS', 'BPS'],
            ['BPS - 0063', 'Ria Dwi Anggraini', 'Staf Perencanaan dan Penganggaran', 'riadwi.anggraini@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0060', 'Rizkyana Hanum', 'Staff Compensation & Benefit', '', 'BPS', 'BPS'],
            ['BPS - 0083', 'Rochmat Fauza Romadhona', 'Staf Dept. Pemeliharaan dan Pembangunan Gedung', '', 'BPS', 'BPS'],
            ['BPS - 0054', 'Salsabila Huwaida Asfiyani', 'Staf Dept. General Affairs', 'salsabila.huwaida@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['BPS - 0085', 'Salsabila Zara Mahasin', 'Staff Training & Development', '', 'BPS', 'BPS'],
            ['BPS - 0035', 'Tommy Hendrawan', 'Kepala Dept. Branding & Transformasi Digital', '', 'BPS', 'BPS'],
            ['BPS - 0088', 'Ulfa Dwiyusridha Hanum', 'Staff Rekruitmen', '', 'BPS', 'BPS'],
            ['BPS - 0041', 'Vera Nopselia', 'Kepala Kesekretariatan', '', 'BPS', 'BPS'],
            ['BPS - 0084', 'Verina Yuliani', 'Kepala Dept. Finance', '', 'BPS', 'BPS'],
            ['BPS - 0057', 'Vian Novianto', 'SPV Branding & Transformasi Digital', '', 'BPS', 'BPS'],
            ['BPS - 0077', 'Vivi Hendryani', 'Kepala Dep. Tax & Accounting', '', 'BPS', 'BPS'],
            ['BPS - 0070', 'Wafi Wafiroh', 'SPV Leader In Me', 'wafi.wafiroh@sekolah-avicenna.sch.id', 'BPS', 'BPS'],
            ['PK - BPS - 0098', 'Ira Ari Nurani', 'Staf Dept. Penelitian & Pengembangan Pendidikan (SD)', '', 'BPS', 'BPS'],
            ['PK - BPS - 0094', 'Fifi Afriani', 'Staf Admin SarPra (Project Based)', '', 'BPS', 'BPS'],
            ['BPS - 0091', 'Daffa Raka Mahendra', 'Staff Programmer', '', 'BPS', 'BPS'],
            ['PK - BPS - 0097', 'Zahra Hilwa Riansyah Gumay', 'Staf Admin SarPra (Project Based)', '', 'BPS', 'BPS'],
            ['BPS - 0092', 'Muhammad Zulfikriansyah', 'Staf Dept. Pemeliharaan dan Pembangunan Gedung', '', 'BPS', 'BPS']
        ];

        $userData = [];
        $password = Hash::make('password');

        foreach ($karyawan as $data) {
            $userData[] = [
                'username' => strtolower(str_replace(' ', '_', $data[1])),
                'kode_karyawan' => $data[0],
                'name' => $data[1],
                'jabatan' => $data[2],
                'email' => $data[3] ?: strtolower(str_replace(' ', '.', $data[1])) . '@sekolah-avicenna.sch.id',
                'unit' => $data[4],
                'jenjang' => $data[5],
                'departemen' => $this->getDepartemen($data[2]),
                'kelas' => $data[6] ?? null,
                'sub_kelas' => $data[7] ?? null,
                'password' => $password,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        User::insert($userData);

        foreach ($karyawan as $data) {
            $user = User::where('kode_karyawan', $data[0])->first();
            if ($user) {
                $roles = $this->getRole($data[2]);
                if (is_array($roles)) {
                    foreach ($roles as $role) {
                        $user->assignRole($role);
                    }
                } else {
                    $user->assignRole($roles);
                }
            }

            if (isset($data[6]) && $data[6] !== null) {
                $user->assignRole($this->getWalikelas($data[6]));
            }
        }
    }

    private function getDepartemen($jabatan)
    {
        if (str_contains($jabatan, 'Kepala Sekolah')) return 'Kepala Sekolah';
        if (str_contains($jabatan, 'Wakil Kurikulum')) return 'Kurikulum';
        if (str_contains($jabatan, 'Wakil Kesiswaan')) return 'Kesiswaan';
        if (str_contains($jabatan, 'Psikolog') || str_contains($jabatan, 'BK')) return 'BK';
        if (str_contains($jabatan, 'Guru')) return 'Guru';
        if (str_contains($jabatan, 'Admin TU') || str_contains($jabatan, 'Tata Usaha')) return 'Tata Usaha';
        if (str_contains($jabatan, 'Humas')) return 'Humas';
        if (str_contains($jabatan, 'Teknisi') || str_contains($jabatan, 'Pramubakti') || str_contains($jabatan, 'Kurir')) return 'Operasional';
        if (str_contains($jabatan, 'Keuangan')) return 'Keuangan';
        if (str_contains($jabatan, 'Perpustakaan')) return 'Perpustakaan';
        if (str_contains($jabatan, 'Suster')) return 'Kesehatan';
        return 'Staff';
    }

    private function getRole($jabatan)
    {
        if (str_contains($jabatan, 'Kepala Sekolah')) return 'kepala-sekolah';
        if (str_contains($jabatan, 'Guru')) return 'guru';
        if (str_contains($jabatan, 'Kepala Tata Usaha')) return 'kepala-tata-usaha';
        if (str_contains($jabatan, 'Admin TU') || str_contains($jabatan, 'Tata Usaha')) return 'tata-usaha';
        if (str_contains($jabatan, 'Humas')) return 'humas';
        if (str_contains($jabatan, 'Kepala Psikolog')) return ['kepala-psikolog', 'psikolog'];
        if (str_contains($jabatan, 'Psikolog')) return 'psikolog';
        if (str_contains($jabatan, 'Wakil Kurikulum')) return 'wakakur';
        if (str_contains($jabatan, 'Wakil Kesiswaan	')) return 'wakasis';

        return 'staff';
    }


    private function getWalikelas($guru)
    {
        if (preg_match('/\b(1[0-2]|[1-9])\b/', $guru)) {
            // mengandung angka 1–12
            return 'wali-kelas';
        } else {
            return null;
        }
    }
}
