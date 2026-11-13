<?php

namespace App\Support;

class ErrorPageCatalog
{
    /**
     * Supported HTTP error statuses available for dedicated handling and preview.
     *
     * @var array<int, int>
     */
    public const SUPPORTED_STATUSES = [400, 401, 403, 404, 405, 419, 429, 500, 503];

    /**
     * Catalog of HTTP error metadata keyed by status code.
     *
     * @var array<int, array<string, mixed>>
     */
    private const DEFINITIONS = [
        400 => [
            'codeLabel' => 'BAD REQUEST',
            'category' => 'bad_request',
            'title' => 'Permintaan Tidak Valid',
            'description' => 'Permintaan yang dikirim tidak dapat diproses karena format atau parameter tidak sesuai.',
            'suggestions' => [
                'Periksa kembali parameter atau alamat URL yang Anda masukkan.',
                'Muat ulang halaman dan ulangi tindakan dari formulir sebelumnya.',
            ],
            'primaryAction' => 'back',
        ],
        401 => [
            'codeLabel' => 'UNAUTHORIZED',
            'category' => 'unauthorized',
            'title' => 'Autentikasi Diperlukan',
            'description' => 'Anda perlu masuk menggunakan akun terdaftar terlebih dahulu untuk mengakses halaman ini.',
            'suggestions' => [
                'Masuk kembali menggunakan akun resmi Avicenna School System Anda.',
                'Pastikan sesi login Anda belum berakhir.',
            ],
            'primaryAction' => 'login',
        ],
        403 => [
            'codeLabel' => 'FORBIDDEN',
            'category' => 'forbidden',
            'title' => 'Akses Ditolak',
            'description' => 'Anda tidak memiliki izin atau peran yang diperlukan untuk membuka halaman maupun fitur ini.',
            'suggestions' => [
                'Pastikan akun Anda memiliki hak akses untuk modul atau departemen terkait.',
                'Hubungi administrator sistem atau Helpdesk AQR jika Anda membutuhkan akses tambahan.',
            ],
            'primaryAction' => 'home',
        ],
        404 => [
            'codeLabel' => 'NOT FOUND',
            'category' => 'not_found',
            'title' => 'Halaman Tidak Ditemukan',
            'description' => 'Halaman, data, atau tautan yang Anda cari tidak tersedia, telah dipindahkan, atau dihapus.',
            'suggestions' => [
                'Periksa kembali ejaan alamat URL pada bilah alamat peramban Anda.',
                'Gunakan menu navigasi utama atau kembali ke halaman beranda sistem.',
            ],
            'primaryAction' => 'home',
        ],
        405 => [
            'codeLabel' => 'METHOD NOT ALLOWED',
            'category' => 'bad_request',
            'title' => 'Metode Tidak Diizinkan',
            'description' => 'Metode permintaan HTTP yang digunakan tidak didukung oleh rute tujuan ini.',
            'suggestions' => [
                'Akses halaman ini melalui tombol atau tautan resmi di dalam aplikasi.',
                'Hindari mengakses rute pemrosesan formulir secara langsung melalui URL.',
            ],
            'primaryAction' => 'home',
        ],
        419 => [
            'codeLabel' => 'PAGE EXPIRED',
            'category' => 'expired',
            'title' => 'Sesi Halaman Kedaluwarsa',
            'description' => 'Token keamanan halaman telah habis masa berlakunya karena halaman terlalu lama tidak aktif.',
            'suggestions' => [
                'Muat ulang halaman untuk memperbarui token keamanan sesi Anda.',
                'Setelah memuat ulang, silakan kirim ulang formulir atau aksi Anda.',
            ],
            'primaryAction' => 'reload',
        ],
        429 => [
            'codeLabel' => 'TOO MANY REQUESTS',
            'category' => 'rate_limit',
            'title' => 'Terlalu Banyak Permintaan',
            'description' => 'Sistem mendeteksi terlalu banyak permintaan dalam waktu singkat. Mohon tunggu sejenak sebelum mencoba lagi.',
            'suggestions' => [
                'Tunggu beberapa detik sesuai batas waktu sebelum mengirim permintaan baru.',
                'Hindari menekan tombol kirim berulang kali saat proses sedang berlangsung.',
            ],
            'primaryAction' => 'reload',
        ],
        500 => [
            'codeLabel' => 'INTERNAL SERVER ERROR',
            'category' => 'server',
            'title' => 'Terjadi Kesalahan pada Server',
            'description' => 'Sistem mengalami kendala internal yang tidak terduga saat memproses permintaan Anda.',
            'suggestions' => [
                'Tunggu beberapa saat lalu muat ulang halaman ini.',
                'Jika kendala berlanjut, salin detail referensi di bawah dan laporkan ke tim IT melalui Helpdesk.',
            ],
            'primaryAction' => 'reload',
        ],
        503 => [
            'codeLabel' => 'SERVICE UNAVAILABLE',
            'category' => 'maintenance',
            'title' => 'Layanan Sedang Pemeliharaan',
            'description' => 'Sistem sedang menjalani pemeliharaan terjadwal atau peningkatan layanan agar tetap optimal.',
            'suggestions' => [
                'Silakan tunggu beberapa menit hingga pemeliharaan selesai.',
                'Muat ulang halaman ini secara berkala untuk memeriksa ketersediaan sistem.',
            ],
            'primaryAction' => 'reload',
        ],
    ];

    /**
     * Resolve metadata for a given HTTP status code with a safe fallback.
     *
     * @return array<string, mixed>
     */
    public static function resolve(int $status): array
    {
        if (isset(self::DEFINITIONS[$status])) {
            return array_merge(['status' => $status], self::DEFINITIONS[$status]);
        }

        if ($status >= 500) {
            return [
                'status' => $status,
                'codeLabel' => 'SERVER ERROR',
                'category' => 'server',
                'title' => 'Gangguan Layanan Server',
                'description' => 'Server sementara tidak dapat menyelesaikan permintaan Anda karena gangguan layanan.',
                'suggestions' => [
                    'Muat ulang halaman beberapa saat lagi.',
                    'Laporkan kendala ke tim IT melalui Helpdesk apabila masalah terus muncul.',
                ],
                'primaryAction' => 'reload',
            ];
        }

        return [
            'status' => $status,
            'codeLabel' => 'CLIENT ERROR',
            'category' => 'bad_request',
            'title' => 'Permintaan Tidak Dapat Diproses',
            'description' => 'Terjadi kendala pada permintaan halaman yang Anda akses.',
            'suggestions' => [
                'Periksa kembali tautan yang Anda buka.',
                'Kembali ke halaman sebelumnya atau menuju halaman utama.',
            ],
            'primaryAction' => 'home',
        ];
    }

    /**
     * Check whether the status code is explicitly listed for preview.
     */
    public static function isSupported(int $status): bool
    {
        return in_array($status, self::SUPPORTED_STATUSES, true);
    }

    /**
     * Return compact metadata list for the error preview switcher.
     *
     * @return array<int, array{status: int, codeLabel: string, title: string}>
     */
    public static function previewOptions(): array
    {
        return array_map(static function (int $status): array {
            $meta = self::DEFINITIONS[$status];

            return [
                'status' => $status,
                'codeLabel' => $meta['codeLabel'],
                'title' => $meta['title'],
            ];
        }, self::SUPPORTED_STATUSES);
    }
}
