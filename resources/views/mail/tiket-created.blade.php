<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Berhasil Dibuat</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; border-radius: 8px; padding: 30px; }
        .header { background: #2563eb; color: #fff; padding: 16px 24px; border-radius: 6px 6px 0 0; }
        table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        th, td { padding: 10px 14px; border: 1px solid #e5e7eb; text-align: left; }
        th { background: #f3f4f6; }
        .btn { display: inline-block; background: #2563eb; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none; margin-top: 16px; }
        .footer { color: #6b7280; font-size: 12px; margin-top: 24px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0">Tiket Berhasil Dibuat</h2>
        </div>
        <p>Halo, <strong>{{ $tiket->nama }}</strong>!</p>
        <p>Tiket aduan Anda telah berhasil diterima. Tim kami akan segera menindaklanjuti.</p>
        <table>
            <tr><th>No. Tiket</th><td>{{ $tiket->no_tiket }}</td></tr>
            <tr><th>Judul Kendala</th><td>{{ $tiket->judul_kendala }}</td></tr>
            <tr><th>Lokasi</th><td>{{ $tiket->lokasi_sekolah ?? $tiket->lokasi_kendala }}</td></tr>
            <tr><th>Status</th><td>{{ $tiket->status }}</td></tr>
            <tr><th>Tanggal</th><td>{{ $tiket->created_at->format('d M Y H:i') }}</td></tr>
        </table>
        <a href="{{ route('helpdesk.home.tiket-show', ['tiket' => $tiket->no_tiket]) }}" class="btn">Lihat Status Tiket</a>
        <p class="footer">Terima kasih telah menghubungi kami. Jika ada pertanyaan, balas email ini.</p>
    </div>
</body>
</html>
