# 🤖 AI Analytics untuk Modul AQR (Tiket Kritik & Saran)

## 📋 Fitur yang Diimplementasikan

### ✅ 1. Kategorisasi Otomatis
AI menganalisis tiket dan memberikan kategori otomatis:
- Fasilitas
- Akademik
- Administrasi
- Kebersihan
- Keamanan
- Pelayanan
- Teknologi
- Lainnya

### ✅ 2. Trend Analysis
Analisis trend tiket berdasarkan:
- Periode (7 hari, 30 hari, 1 tahun)
- Lokasi sekolah (Cinere, Jagakarsa, Pamulang)
- Status tiket
- Sentiment (Positif, Netral, Negatif)
- Prioritas (Rendah, Sedang, Tinggi, Urgent)

### ✅ 3. Summary & Insight AI
AI memberikan:
- Trend utama periode tersebut
- Masalah yang paling sering muncul
- Rekomendasi action plan
- Insight untuk management

---

## 🚀 Cara Setup

### 1. Dapatkan API Key Google Gemini (GRATIS)

1. Buka: https://aistudio.google.com/app/apikey
2. Login dengan akun Google
3. Klik "Create API Key"
4. Copy API Key yang didapat

### 2. Konfigurasi Laravel

Tambahkan ke file `.env`:
```env
GEMINI_API_KEY=your_api_key_here
```

### 3. Jalankan Migration

```bash
php artisan migrate
```

Migration akan menambahkan kolom:
- `ai_kategori`
- `ai_sub_kategori`
- `ai_prioritas`
- `ai_sentiment`
- `ai_ringkasan`
- `ai_analyzed_at`

---

## 📊 Cara Menggunakan

### 1. Akses Dashboard Analytics

```
URL: /dashboard/aqr/analytics
```

### 2. Analisis Tiket Otomatis

**Analisis 1 Tiket:**
- Buka detail tiket
- Klik tombol "Analisis dengan AI"

**Analisis Bulk (10 Tiket):**
- Di halaman analytics
- Klik tombol "🤖 Analisis 10 Tiket Terbaru"

### 3. Filter Analytics

- **Periode**: 7 hari, 30 hari, 1 tahun
- **Lokasi**: Cinere, Jagakarsa, Pamulang, atau Semua

---

## 💰 Biaya & Limit

### Google Gemini 1.5 Flash (GRATIS)

**Free Tier:**
- ✅ 15 requests per menit
- ✅ 1,500 requests per hari
- ✅ 1 juta requests per bulan

**Estimasi Penggunaan:**
- 1 analisis tiket = 1 request
- 1 trend summary = 1 request
- **Total: GRATIS untuk penggunaan normal sekolah**

**Jika Melebihi Limit:**
- Upgrade ke paid tier: $0.075 per 1M tokens
- Estimasi: Rp 30-100rb/bulan untuk 1000 tiket

---

## 📁 File yang Dibuat

```
app/
├── Services/
│   └── GeminiService.php          # Service untuk integrasi AI
├── Http/Controllers/AQR/
│   └── AnalyticsController.php    # Controller analytics
└── Models/
    └── Tiket.php                  # Updated model

database/migrations/
└── xxxx_add_ai_analysis_to_tikets_table.php

resources/views/dashboard/aqr-dashboard/
└── analytics.blade.php            # Dashboard analytics

routes/
└── aqr.php                        # Updated routes

config/
└── services.php                   # Gemini config
```

---

## 🎯 Endpoint API

### Analytics Dashboard
```
GET /dashboard/aqr/analytics
Query params:
- period: week|month|year
- lokasi: Cinere|Jagakarsa|Pamulang
```

### Analisis Single Tiket
```
POST /dashboard/aqr/analytics/analyze/{id}
```

### Analisis Bulk
```
POST /dashboard/aqr/analytics/bulk-analyze
Body:
- limit: jumlah tiket (default: 10)
```

---

## 📈 Contoh Output AI

### Kategorisasi Otomatis
```json
{
  "kategori": "Fasilitas",
  "sub_kategori": "AC Rusak",
  "prioritas": "Tinggi",
  "sentiment": "Negatif",
  "ringkasan": "Pengirim melaporkan AC di ruang kelas rusak dan perlu perbaikan segera"
}
```

### Trend Summary
```json
{
  "trend_utama": "Peningkatan keluhan fasilitas di bulan ini, terutama terkait AC dan kebersihan toilet",
  "masalah_terbanyak": "Fasilitas AC rusak di berbagai ruang kelas",
  "rekomendasi": [
    "Lakukan maintenance rutin AC setiap bulan",
    "Tambah petugas kebersihan untuk toilet",
    "Buat sistem pelaporan kerusakan yang lebih cepat"
  ],
  "insight": "Terdapat korelasi antara musim panas dengan peningkatan keluhan AC. Perlu antisipasi sebelum musim panas tiba."
}
```

---

## 🔧 Troubleshooting

### Error: "API Key tidak valid"
- Pastikan API key sudah benar di `.env`
- Cek apakah API key sudah aktif di Google AI Studio

### Error: "Rate limit exceeded"
- Tunggu 1 menit (free tier: 15 req/menit)
- Atau upgrade ke paid tier

### Analisis tidak akurat
- AI menggunakan bahasa Indonesia, hasil bisa bervariasi
- Untuk hasil lebih akurat, pastikan detail tiket lengkap

---

## 🎨 Customisasi

### Ubah Kategori
Edit di `GeminiService.php` line 20:
```php
\"kategori\": \"pilih salah satu: Fasilitas, Akademik, ...\"
```

### Ubah Limit Bulk Analyze
Edit di `AnalyticsController.php` line 95:
```php
$limit = $request->get('limit', 10); // ubah 10 ke angka lain
```

---

## 📞 Support

Jika ada pertanyaan atau issue:
1. Cek log Laravel: `storage/logs/laravel.log`
2. Cek dokumentasi Gemini: https://ai.google.dev/docs
3. Contact: Daffa Rakah (Backend Developer)

---

## 🚀 Next Features (Opsional)

- [ ] Auto-assign tiket berdasarkan kategori AI
- [ ] Email notification untuk tiket prioritas urgent
- [ ] Export analytics ke PDF/Excel
- [ ] Chatbot untuk FAQ tiket
- [ ] Prediksi waktu penyelesaian tiket

---

**Dibuat dengan ❤️ menggunakan Google Gemini AI (Free Tier)**
