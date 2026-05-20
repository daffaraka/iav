<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Didisposisikan ke Anda</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; border-radius: 8px; padding: 30px; }
        .header { background: #d97706; color: #fff; padding: 16px 24px; border-radius: 6px 6px 0 0; }
        table { width: 100%; border-collapse: collapse; margin: 16px 0; }
        th, td { padding: 10px 14px; border: 1px solid #e5e7eb; text-align: left; }
        th { background: #f3f4f6; }
        .btn { display: inline-block; background: #d97706; color: #fff; padding: 10px 20px; border-radius: 6px; text-decoration: none; margin-top: 16px; }
        .footer { color: #6b7280; font-size: 12px; margin-top: 24px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0">📋 Tiket Didisposisikan ke Anda</h2>
        </div>
        <p>Halo, sebuah tiket telah didisposisikan kepada Anda untuk ditindaklanjuti.</p>
        <table>
            <tr><th>No. Tiket</th><td>{{ $tiket->no_tiket }}</td></tr>
            <tr><th>Nama Pelapor</th><td>{{ $tiket->nama }}</td></tr>
            <tr><th>Judul Kendala</th><td>{{ $tiket->judul_kendala }}</td></tr>
            <tr><th>Detail</th><td>{{ $tiket->detail_kendala }}</td></tr>
            <tr><th>Lokasi</th><td>{{ $tiket->lokasi_sekolah ?? $tiket->lokasi_kendala }}</td></tr>
            <tr><th>Diproses oleh</th><td>{{ $tiket->first_pic->name ?? '-' }}</td></tr>
            <tr><th>Tanggal</th><td>{{ now()->format('d M Y H:i') }}</td></tr>
        </table>
        <a href="{{ url('/dashboard/aqr/tiket/' . $tiket->id . '/edit') }}" class="btn">Beri Respon Sekarang</a>
        <p class="footer">Email ini dikirim otomatis oleh sistem Avicenna Helpdesk.</p>
    </div>
</body>
</html>
