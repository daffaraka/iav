<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MasterSiswa;
use Illuminate\Http\Request;
// use App\Events\TestNotification; // Enable if events are migrated
use App\Models\PenjemputanHarian;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeGenerator extends Controller
{
    public function qrCodeScan()
    {
        return view('dashboard.qr-scanner');
    }

    public function scanQrCode(Request $request)
    {
        $penjemputan = PenjemputanHarian::whereHas('siswa', function ($query) use ($request) {
            $query->where('nis', $request->data);
        })
            ->whereDate('created_at', Carbon::now()->format('Y-m-d'))
            ->first();


        if ($penjemputan) {
            $penjemputan->waktu_dijemput = now();
            $penjemputan->save();
        }

        event(new TestNotification([
            'notifikasi' => 'Penjemput atas nama ' . $penjemputan->siswa->nama . ' Sudah Datang',
            'kelas' => $penjemputan->siswa->kelas
        ]));




        //akhir proses
        return response()->json([
            'success' => true,
            'data' => $penjemputan->siswa->nama,
            'time' => Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y')
        ]);
    }
}
