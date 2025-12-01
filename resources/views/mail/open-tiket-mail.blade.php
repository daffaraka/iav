<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Open Tiket ID {{ $data['id'] ?? '1' }}</title>
    <style>
        @import url('https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css');
    </style>
</head>

<body class="bg-gray-400 py-20">
    <div class="max-w-2xl  mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-700">Hello, {{ $data['name'] ?? 'User' }}!</h2>
        <p class="text-gray-600 mt-2">Proses penyelesaian tiket aduan Anda sedang berlangsung. Tim kami sedang bekerja
            untuk menyelesaikan masalah yang Anda laporkan sesegera mungkin.
            Kami akan memberikan pembaruan lebih lanjut segera setelah ada perkembangan terbaru. </p>


        <table class="min-w-full bg-white border border-gray-400 my-3">
            <tbody>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 text-left">No Tiket</th>
                    <td class="py-2 px-4">: {{ $data['no_tiket'] ?? '' }}</td>
                </tr>
                <tr>
                    <th class="py-2 px-4 text-left">Tanggal</th>
                    <td class="py-2 px-4">: {{ $data['tanggal'] ?? '' }}</td>
                </tr>

                <tr>
                    <th class="py-2 px-4 text-left">Lokasi Kendala</th>
                    <td class="py-2 px-4">: {{ $data['lokasi_kendala'] ?? '' }}</td>
                </tr>
                <tr class="bg-gray-200">
                    <th class="py-2 px-4 text-left">Detail Kendala</th>
                    <td class="py-2 px-4">: {{ $data['detail_kendala'] ?? '' }}</td>
                </tr>
            </tbody>
        </table>

        <div class="my-4">
            <p class="text-gray-600 mt-2 mb-4">Untuk melihat progress
                terkait tiket anda, silahkan klik link dibawah.</p>
            <a href="{{route('helpdesk.home.tiket-show', ['tiket' => $data['no_tiket']])}}"
                class="bg-blue-500 text-white px-4 py-2 shadow-lg border rounded-lg text-sm font-medium hover:bg-blue-600">Click
                Here</a>
        </div>


        <p class="text-gray-600 mt-2">
            Terima kasih atas kesabaran dan pengertiannya.</p>

        <p class="text-gray-500 text-sm mt-6">Jika ada pertanyaan lebih, silahkan kontak kami.</p>
    </div>
</body>

</html>
