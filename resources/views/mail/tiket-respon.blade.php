<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Tiket Anda</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; border-radius: 8px; padding: 30px; }
        .header { background: #16a34a; color: #fff; padding: 16px 24px; border-radius: 6px 6px 0 0; }
        table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        th, td { padding: 10px 14px; border: 1px solid #e5e7eb; text-align: left; }
        th { background: #f3f4f6; }
        .respon-box { background: #f0fdf4; border-left: 4px solid #16a34a; padding: 12px 16px; margin: 16px 0; border-radius: 4px; }
        .btn { display: inline-block; background: #16a34a; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none; margin-top: 16px; }
        .footer { color: #6b7280; font-size: 12px; margin-top: 24px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0">✅ Tiket Anda Mendapat Respon</h2>
        </div>
        <p>Halo, <strong>{{ $tiket->nama }}</strong>!</p>
        <p>Tim kami telah memberikan respon terhadap tiket Anda.</p>
        <table>
            <tr><th>No. Tiket</th><td>{{ $tiket->no_tiket }}</td></tr>
            <tr><th>Judul Kendala</th><td>{{ $tiket->judul_kendala }}</td></tr>
            <tr><th>Status</th><td>{{ $tiket->status }}</td></tr>
            <tr><th>Ditangani oleh</th><td>{{ $tiket->pic->name ?? '-' }}</td></tr>
        </table>
        <div class="respon-box">
            <strong>Respon Tim:</strong>
            <p style="margin: 8px 0 0">{{ $penanganan }}</p>
        </div>
        <a href="{{ route('helpdesk.home.tiket-show', ['tiket' => $tiket->no_tiket]) }}" class="btn">Lihat Detail Tiket</a>
        <p class="footer">Terima kasih atas kesabaran Anda. Jika ada pertanyaan, balas email ini.</p>
    </div>
</body>
</html>
