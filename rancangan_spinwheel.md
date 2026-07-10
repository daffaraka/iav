# Rancangan Aplikasi Spinwheel (Laravel + Inertia React + MySQL)

Dokumen ini berisi rancangan teknis untuk pembuatan aplikasi Spinwheel pengundian resi yang mendukung multi-platform (TikTok & Shopee) secara zigzag, fitur upload massal, pengaturan pemenang, dan manajemen hadiah.

### 1. Frontend (React.js via Laravel Inertia)
Frontend akan dibangun menggunakan React.js yang diintegrasikan melalui Laravel Inertia. Ini memungkinkan pengalaman pengguna yang sangat cepat tanpa memuat ulang (reload) halaman, namun *deployment*-nya semudah aplikasi Laravel biasa.

**Tech Stack:**
- **Framework:** Laravel Inertia (React.js) + Vite
- **Styling:** Tailwind CSS + Framer Motion (untuk animasi mulus)
- **Library Roda Putar:** `react-custom-roulette` atau implementasi Canvas kustom.
- **State Management:** React Hooks / Zustand.

**Struktur Halaman (Mengacu pada Gambar Referensi):**
1. **Halaman Publik (Live Spin):**
   - **Panel Kiri (Data Peserta):** Terdapat Tab "TIKTOK" (Tema Gelap) dan "SHOPEE" (Tema Oranye Gelap). Di bawahnya ada form Upload File Excel/CSV, informasi "Total Peserta", "Pemenang", dan tombol aksi utama.
   - **Tengah (Spinwheel):** Roda putar besar dengan efek *magnifier* (kaca pembesar) di bagian atas untuk memperjelas resi yang sedang terpilih.
   - **Panel Kanan (Daftar Hadiah):** Daftar list hadiah (iPhone, MacBook, iPad, dll) beserta *radio button* untuk memilih hadiah yang sedang diundi.
2. **Halaman Admin / Fitur Tersembunyi:**
   - **Form Rigging (Setting Pemenang):** Input khusus bagi Admin (dilindungi *password*) untuk memasukkan "Nomor Resi" yang akan dipaksa menang untuk platform & hadiah tertentu.

### 2. Backend (Laravel & MySQL)
Backend akan dibangun menggunakan arsitektur Laravel (PHP) yang sangat stabil untuk *shared hosting* konvensional (cPanel), digabungkan dengan MySQL.

**Tech Stack:**
- **Framework:** Laravel (PHP)
- **Database:** MySQL
- **File Parser:** `maatwebsite/excel` (Package standar industri di Laravel untuk import Excel).

**Alur Logika Spin (Core Logic):**
1. Saat tombol "Spin" ditekan di Frontend (dengan mengirim data platform & hadiah yang dipilih), ia memanggil API internal Laravel.
2. Laravel mengecek di database MySQL apakah ada **Pemenang yang di-setting (Rigged Winner)** untuk platform & hadiah tersebut.
3. **Jika ada:** Laravel mengembalikan data pemenang settingan tersebut dan menandainya sudah terpilih.
4. **Jika tidak ada:** Laravel mengambil semua data peserta platform tersebut dari MySQL, mengacak, dan mengembalikan 1 pemenang.

**API Endpoints Utama:**
- `POST /api/upload`: Menerima file Excel, *truncate* (hapus) data lama platform tersebut, dan *insert* ribuan data baru ke MySQL.
- `GET /api/prizes`: Mengambil daftar hadiah.
- `POST /api/settings/winner`: Endpoint khusus admin untuk mendaftarkan resi *rigging*.
- `GET /api/spin`: Mengeksekusi logika putaran dan mengembalikan 1 resi pemenang.

### 3. Alur Pergantian Zigzag (Tanpa Upload Ulang)
- Di panel kiri, klien mengunggah **File A (TikTok)** dan **File B (Shopee)**.
- Data dari kedua file masuk ke database dalam *table* yang sama namun dibedakan berdasarkan `platform`.
- Saat klien menekan tab **"Switch to Shopee"**, Frontend hanya mengganti warna tema dan menarik data Shopee. Tidak ada *refresh* halaman atau *upload* ulang yang diperlukan.
