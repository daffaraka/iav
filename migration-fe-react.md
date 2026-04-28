# 🔄 Panduan Migrasi Frontend ke React JS

> Laravel 11 Blade → Laravel 11 REST API + React 18 SPA

**Project:** Sistem Manajemen Sekolah Avicenna  
**Kontributor:** Daffa Rakah | Backend Developer | Laravel 11

---

## 📋 Identifikasi Fitur Lengkap

| No | Modul | Deskripsi | Route Saat Ini |
|----|-------|-----------|----------------|
| 1 | **Auth** | Login, Register, Forgot/Reset Password, Verify Email | `/login`, `/register` |
| 2 | **Dashboard** | Overview statistik utama | `/dashboard` |
| 3 | **Master Sekolah** | CRUD 3 unit (Jagakarsa, Cinere, Pamulang) | `/sekolah` |
| 4 | **Master Siswa** | Data siswa lengkap (NISN, NIS, kelas, jenjang, foto) | `/master-siswa` |
| 5 | **Data Prestasi** | CRUD prestasi, filter per sekolah, terkurasi/tidak | `/data-prestasi` |
| 6 | **Master PTN/PTS** | CRUD data perguruan tinggi | `/master-ptn` |
| 7 | **Persebaran PTN** | Tracking siswa masuk PT | `/persebaran-ptn` |
| 8 | **WIG** | Wildly Important Goals + Lead Measure + Task Process + Progress + Chart | `/wig` |
| 9 | **Departemen** | CRUD departemen, view WIG per departemen | `/departement` |
| 10 | **AQR Tiket** | Buat/proses/selesai/rating/forward tiket, delete all | `/dashboard/aqr/tiket` |
| 11 | **Aduan** | CRUD aduan masyarakat | `/dashboard/aqr/aduan` |
| 12 | **Progres Tiket** | Tracking progres penanganan tiket | `/dashboard/aqr/progres-tiket` |
| 13 | **AI Analytics** | Analisis tiket via Gemini 2.5 Flash (per-tiket & bulk) | `/dashboard/aqr/analytics` |
| 14 | **Lowongan Pekerjaan** | CRUD lowongan kerja | `/lowongan-pekerjaan` |
| 15 | **Lowongan Apply** | CRUD data pelamar | `/lowongan-apply` |
| 16 | **Lowongan Progress** | Tracking progress rekrutmen | `/lowongan-progress` |
| 17 | **AQR Option** | Konfigurasi kategori tiket | `/aqr-option` |
| 18 | **Role & Permission** | CRUD role, assign permission (Spatie) | `/role` |
| 19 | **User Management** | CRUD user, assign role | `/user` |
| 20 | **Profile** | Edit profil, ganti password, hapus akun | `/profile` |
| 21 | **Helpdesk Publik** | Open tiket tanpa login, tracking, kepuasan | `/helpdesk` |
| 22 | **Email Notifikasi** | Kirim email otomatis saat tiket dibuat | (background) |

---

## 🗺️ Arsitektur Target

```
iav-backend/   → Laravel 11 (Pure REST API + Sanctum)
iav-frontend/  → React 18 + Vite (SPA)
```

**Prinsip utama:**
- Laravel hanya return `response()->json()` — tidak ada Blade view
- Auth via **Laravel Sanctum** (cookie-based untuk SPA)
- Spatie Permission tetap 100% di backend — frontend hanya consume `permissions[]`
- Semua halaman list **wajib** menggunakan DataTables (`@tanstack/react-table`)

---

## 🪜 Step-by-Step Migrasi

### Phase 1 — Siapkan Backend API

```bash
# 1. Install Sanctum
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate

# 2. Aktifkan CORS
# config/cors.php → allowed_origins: ['http://localhost:5173']

# 3. Tambahkan HasApiTokens di User model
# 4. Buat routes/api.php dengan prefix /api/v1
# 5. Ubah semua controller return response()->json()
# 6. Buat API Resource classes (UserResource, TiketResource, dll)
# 7. Buat AuthController (login/logout/me)
```

Endpoint `/api/me` **wajib** return:
```json
{
  "user": { "id": 1, "name": "Daffa", "unit": "Jagakarsa", "jabatan": "Tata Usaha" },
  "roles": ["tata-usaha"],
  "permissions": ["view-tiket", "create-tiket", "tiket-finish", "export-data"]
}
```

### Phase 2 — Setup React Project

```bash
npm create vite@latest iav-frontend -- --template react
cd iav-frontend
npm install
```

### Phase 3 — Urutan Migrasi Modul

```
1.  Auth (Login/Logout)            ← fondasi semua fitur
2.  Dashboard
3.  Role & Permission + User       ← mempengaruhi semua modul lain
4.  Master Sekolah + Master Siswa
5.  Data Prestasi
6.  WIG + Departemen + Lead Measure + Task Process
7.  AQR Tiket + Aduan + Progres Tiket
8.  Lowongan (Pekerjaan + Apply + Progress)
9.  AI Analytics (Gemini)
10. Helpdesk Publik (/helpdesk)
```

### Phase 4 — Finalisasi

```
- Route guard berdasarkan permissions
- DataTables server-side di semua halaman list
- Testing end-to-end
- Build & deploy
```

---

## ⚠️ Catatan Penting

### 🔐 Role & Permission (KRITIS)

- **Jangan pindahkan logic permission ke React** — Spatie tetap di backend
- React hanya render/hide UI berdasarkan `permissions[]` dari `/api/me`
- Backend **wajib** tetap cek permission di setiap endpoint API via middleware
- Buat hook `usePermission()` untuk conditional render tombol/halaman

```jsx
// Contoh penggunaan
const { hasPermission } = usePermission()

{hasPermission('delete-data-prestasi') && (
  <button onClick={handleDelete}>Hapus</button>
)}
```

**Daftar 16 Role:**
```
super-admin · humas · direktur · koordinator · kadept
staff · guru · kepala-tata-usaha · tata-usaha · kepala-sekolah
admin-unit · wali-kelas · wakakur · wakasis · psikolog · kepala-psikolog
```

**Matriks akses utama:**

| Permission | super-admin | humas | staff | guru | tata-usaha | kepala-sekolah |
|-----------|:-----------:|:-----:|:-----:|:----:|:----------:|:--------------:|
| Semua akses | ✅ | ✅ | — | — | — | — |
| Data Prestasi | ✅ | ✅ | ✅ | ✅ | ✅ | 👁️ |
| Tiket (full) | ✅ | ✅ | 👁️✏️ | 👁️➕ | ✅ | 👁️ |
| WIG | ✅ | ✅ | — | 👁️ | — | ✅ |
| User Management | ✅ | ✅ | — | — | ✅ | — |
| Export Data | ✅ | ✅ | — | — | ✅ | ✅ |
| View Analytics | ✅ | ✅ | — | — | — | ✅ |

**Permission spesifik yang perlu diperhatikan:**
```
tiket-finish        → hanya role tertentu bisa selesaikan tiket
tiket-pilih-pic     → assign PIC tiket
monitor-all-tiket   → lihat semua tiket lintas lokasi
view-all-locations  → akses data semua sekolah
assign-roles        → kelola role user
manage-all-data     → akses penuh semua data
```

---

### 🎫 Tiket — State Machine

```
New → Proses → Selesai → (Rating opsional)
```

- Tiket **Masyarakat Umum**: PIC otomatis = user yang pertama memproses
- Tiket **Warga Sekolah**: PIC otomatis = TU sesuai mapping lokasi sekolah
  - Cinere → `AVI-0052`, `AVI-0085`
  - Jagakarsa → `AVI-0054`, `AVI-0291`
  - Pamulang → `AVI-0438`, `AVI-0184`
- Forward tiket: pindah PIC ke Kepala Sekolah / Kepala TU
- Tombol aksi **conditional** berdasarkan status tiket + permission user
- Filter tiket berdasarkan `unit` user — kecuali `super-admin` & `humas` lihat semua
- Nomor tiket format: `AQR-YYYYMMDD-XXXXXX`

---

### 📊 WIG Chart

- Saat ini `chart-wig.js` di `public/` — di React gunakan `recharts`
- Data chart di-fetch via API endpoint khusus, bukan embed di view
- Relasi data: `WIG → LeadMeasure → TaskProcess → WigProgress`
- WIG punya field `from_x` dan `to_y` untuk target progress

---

### 🤖 AI Analytics (Gemini 2.5 Flash)

- `GeminiService.php` memanggil Gemini API — **tetap di backend**
- React hanya trigger (POST) dan tampilkan hasil JSON
- Bulk analyze bisa lambat — gunakan loading state / skeleton
- Hasil analisis per tiket:
  ```json
  {
    "kategori": "Fasilitas | Akademik | Administrasi | ...",
    "sub_kategori": "lebih spesifik",
    "prioritas": "Rendah | Sedang | Tinggi | Urgent",
    "sentiment": "Positif | Netral | Negatif",
    "ringkasan": "ringkasan 1-2 kalimat"
  }
  ```
- Trend summary: `trend_utama`, `masalah_terbanyak`, `rekomendasi[]`, `insight`

---

### 🌐 Helpdesk Publik

- Route `/helpdesk` adalah halaman **tanpa auth** (guest)
- Di React buat route publik yang **tidak** memerlukan Sanctum token
- Fitur: open tiket (warga sekolah / masyarakat umum), tracking via nomor tiket, isi kepuasan
- Pisahkan layout publik dari layout dashboard admin

---

### 👤 User — Field Penting untuk Filter Data

```
unit       → Jagakarsa / Cinere / Pamulang  (filter tiket & data per lokasi)
jenjang    → KB/TK / SD / SMP / SMA
departemen → nama departemen
jabatan    → jabatan struktural
kelas      → untuk wali kelas
sub_kelas  → sub kelas
```

Field `unit` digunakan untuk filter otomatis data tiket per lokasi sekolah.

---

### 📧 Email Notifikasi

- Tetap di backend (Laravel Mail) — React tidak perlu tahu detail ini
- Tampilkan toast notifikasi sukses setelah tiket dibuat di frontend

---

## 📦 Package React

```bash
# Core Routing & HTTP
npm install react-router-dom axios

# Server State (fetch, cache, refetch otomatis)
npm install @tanstack/react-query

# DataTables — WAJIB di semua halaman list
npm install @tanstack/react-table

# Form & Validasi
npm install react-hook-form zod @hookform/resolvers

# Global State (simpan user, roles, permissions)
npm install zustand

# UI Components
npm install @headlessui/react lucide-react

# Chart (WIG goals & progress)
npm install recharts

# Notifikasi Toast
npm install react-hot-toast

# Format Tanggal
npm install date-fns

# Upload File (attachment tiket)
npm install react-dropzone

# Export Data (laporan manajemen)
npm install xlsx file-saver
```

> TailwindCSS sudah ada di project Laravel — lanjutkan penggunaannya di React.

---

## 📁 Struktur Folder React

```
iav-frontend/
└── src/
    ├── api/
    │   ├── auth.js
    │   ├── prestasi.js
    │   ├── tiket.js
    │   ├── wig.js
    │   ├── lowongan.js
    │   ├── user.js
    │   └── ...
    ├── components/
    │   ├── DataTable.jsx        ← reusable @tanstack/react-table
    │   ├── Modal.jsx
    │   ├── PermissionGuard.jsx  ← wrapper conditional render
    │   ├── Toast.jsx
    │   └── ...
    ├── context/
    │   └── AuthContext.jsx      ← simpan user + roles + permissions
    ├── hooks/
    │   ├── useAuth.js
    │   ├── usePermission.js     ← hasPermission(), hasRole()
    │   └── useRole.js
    ├── pages/
    │   ├── auth/                ← Login, Register, ForgotPassword
    │   ├── dashboard/
    │   ├── prestasi/
    │   ├── wig/                 ← WIG, LeadMeasure, TaskProcess, Progress
    │   ├── aqr/                 ← Tiket, Aduan, Progres, Analytics
    │   ├── lowongan/            ← Pekerjaan, Apply, Progress
    │   ├── user/                ← User, Role, Permission
    │   └── public/              ← Helpdesk publik (tanpa auth)
    ├── routes/
    │   ├── index.jsx
    │   ├── ProtectedRoute.jsx   ← cek auth + permission
    │   └── PublicRoute.jsx      ← untuk /helpdesk
    └── utils/
        ├── axios.js             ← instance axios + interceptor Sanctum
        └── constants.js
```

---

## 📊 DataTables — Standar Implementasi

Semua halaman list **wajib** menggunakan `@tanstack/react-table` dengan fitur:

| Fitur | Keterangan |
|-------|-----------|
| Server-side pagination | Untuk data besar (tiket, prestasi, user) |
| Search & filter | Filter per kolom |
| Sort per kolom | Ascending / descending |
| Action buttons | Conditional berdasarkan permission |
| Export xlsx | Untuk laporan manajemen |

Buat **satu** komponen `<DataTable />` reusable yang dipakai di semua halaman — jangan buat ulang per halaman.

---

## 🗄️ Relasi Database Penting

```
users               → karyawan/guru/staff (HasRoles via Spatie)
sekolahs            → 3 unit sekolah
  └── master_siswas → data siswa per sekolah
      └── data_prestasis → prestasi siswa

departements        → departemen sekolah
  └── wigs          → WIG goals per departemen
      └── lead_measures    → lead measure per WIG
          └── task_processes → task per lead measure
      └── wig_progresses   → progress WIG

tikets              → tiket helpdesk AQR
  └── progres_tikets → log progres penanganan
  └── aqr_options    → kategori & PIC tiket

lowongan_pekerjaans → lowongan kerja
  └── lowongan_applies    → pelamar
  └── lowongan_progresses → progress rekrutmen

roles               → role (Spatie)
permissions         → permission (Spatie)
model_has_roles     → pivot user ↔ role
role_has_permissions → pivot role ↔ permission
```

---

## 🛠️ Tech Stack Lengkap

### Backend (Laravel — tetap)

| Package | Versi | Fungsi |
|---------|-------|--------|
| Laravel Framework | ^11.0 | Core framework |
| PHP | ^8.2 | Runtime |
| Spatie Laravel Permission | ^6.10 | Role & Permission |
| Laravel Sanctum | — | SPA Authentication |
| Laravel Breeze | ^2.3 | Auth scaffolding |
| Gemini 2.5 Flash API | — | AI Analytics tiket |
| Laravel Mail | — | Email notifikasi |

### Frontend (React — target)

| Package | Fungsi |
|---------|--------|
| React 18 + Vite | Core SPA |
| TailwindCSS | Styling |
| react-router-dom | Routing SPA |
| axios | HTTP client ke Laravel API |
| @tanstack/react-query | Server state management |
| @tanstack/react-table | DataTables (wajib semua list) |
| react-hook-form + zod | Form & validasi |
| zustand | Global state (user, permissions) |
| recharts | Chart WIG |
| react-hot-toast | Notifikasi toast |
| @headlessui/react | Komponen UI accessible |
| lucide-react | Icons |
| react-dropzone | Upload file attachment tiket |
| date-fns | Format tanggal |
| xlsx + file-saver | Export data laporan |
