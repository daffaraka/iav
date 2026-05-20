# 📧 Setup Email & Notifikasi Tiket

## 🔧 Konfigurasi Gmail SMTP

### 1. Aktifkan App Password di Gmail
1. Buka [Google Account Security](https://myaccount.google.com/security)
2. Aktifkan **2-Step Verification**
3. Buka **App passwords** → Generate password untuk "Mail"
4. Copy password yang dihasilkan (16 karakter)

### 2. Update `.env`
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_16_char_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Avicenna Helpdesk"

QUEUE_CONNECTION=database
```

### 3. Jalankan Migration Queue
```bash
php artisan queue:table
php artisan migrate
```

---

## 🚀 Menjalankan Queue Worker

### Development (Windows)
```bash
php artisan queue:work --tries=3
```

### Production (Background Process)
Gunakan **Supervisor** atau **Task Scheduler**:

**Windows Task Scheduler:**
1. Buka Task Scheduler
2. Create Basic Task → Name: "Laravel Queue Worker"
3. Trigger: At startup
4. Action: Start a program
   - Program: `C:\laragon\bin\php\php-8.x\php.exe`
   - Arguments: `artisan queue:work --tries=3 --timeout=90`
   - Start in: `C:\laragon\www\Laravel\iav`

---

## 📬 Alur Email Notifikasi

### 1️⃣ Tiket Baru Dibuat (`store()`)
- ✅ **Pengirim** → Email konfirmasi tiket dibuat
- ✅ **Admin Humas** (admin_humas_id) → Notifikasi tiket baru masuk
- ✅ **Live Notification** → Database notification ke admin humas

### 2️⃣ Admin Humas Disposisi (`update()` - set pic_id)
- ✅ **PIC** (pic_id) → Email tiket didisposisikan
- ✅ **Live Notification** → Database notification ke PIC

### 3️⃣ PIC Beri Respon (`update()` - create ProgresTiket)
- ✅ **Pengirim** (email) → Email update respon tiket
- ✅ **Admin Humas** → Live notification bahwa PIC sudah merespon

---

## 🔔 Live-Time Notification

### Mengambil Notifikasi User
```php
// Di Controller
$notifications = auth()->user()->unreadNotifications;

// Mark as read
auth()->user()->notifications->markAsRead();
```

### Contoh Blade
```blade
@foreach(auth()->user()->unreadNotifications as $notif)
    <div class="notification">
        <strong>{{ $notif->data['no_tiket'] }}</strong>
        <p>{{ $notif->data['pesan'] }}</p>
        <a href="{{ $notif->data['url'] }}">Lihat</a>
    </div>
@endforeach
```

---

## 🧪 Testing Email

```bash
php artisan tinker
```

```php
use App\Models\Tiket;
use App\Mail\TiketCreatedMail;
use Illuminate\Support\Facades\Mail;

$tiket = Tiket::first();
Mail::to('test@example.com')->send(new TiketCreatedMail($tiket));
```

---

## ⚠️ Troubleshooting

### Email tidak terkirim
1. Cek `.env` sudah benar
2. Pastikan App Password Gmail valid
3. Cek `storage/logs/laravel.log`
4. Test koneksi SMTP:
   ```bash
   php artisan tinker
   Mail::raw('Test', fn($m) => $m->to('test@example.com')->subject('Test'));
   ```

### Queue tidak jalan
1. Pastikan `QUEUE_CONNECTION=database` di `.env`
2. Jalankan `php artisan queue:work`
3. Cek tabel `jobs` di database
4. Restart queue worker setelah update code

---

## 📊 Monitoring Queue

```bash
# Lihat failed jobs
php artisan queue:failed

# Retry failed jobs
php artisan queue:retry all

# Clear failed jobs
php artisan queue:flush
```

---

**✅ Fitur Sudah Siap!**
