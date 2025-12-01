<?php

namespace App\Http\Controllers\AQR;

use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AQRController extends Controller
{
   public function index()
    {

        // if (!auth()->user()->hasRole('Admin')) {
        //     $tiketNew = Tiket::where('status', 'New')->where('pic_id', auth()->user()->id)->count();
        //     $tiketProses = Tiket::where('status', 'Proses')->where('pic_id', auth()->user()->id)->count();
        //     $tiketClosed = Tiket::where('status', 'Selesai')->where('pic_id', auth()->user()->id)->count();
        //     $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

        //     $latestTiket = Tiket::where('status', 'New')->latest()->limit(5)->where('pic_id', auth()->user()->id)->get();
        //     $latestProses = Tiket::where('status', 'Proses')->where('pic_id', auth()->user()->id)->latest()->limit(5)->get();
        //     $latestSelesai = Tiket::where('status', 'Selesai')->where('pic_id', auth()->user()->id)->latest()->limit(5)->get();
        // } else {
        //     $tiketNew = Tiket::where('status', 'New')->count();
        //     $tiketProses = Tiket::where('status', 'Proses')->count();
        //     $tiketClosed = Tiket::where('status', 'Selesai')->count();
        //     $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

        //     $latestTiket = Tiket::where('status', 'New')->latest()->limit(5)->get();
        //     $latestProses = Tiket::where('status', 'Proses')->latest()->limit(5)->get();
        //     $latestSelesai = Tiket::where('status', 'Selesai')->latest()->limit(5)->get();
        // }

        $tiketNew = Tiket::where('status', 'New')->count();
        $tiketProses = Tiket::where('status', 'Proses')->count();
        $tiketClosed = Tiket::where('status', 'Selesai')->count();
        $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

        $latestTiket = Tiket::where('status', 'New')->latest()->limit(5)->get();
        $latestProses = Tiket::where('status', 'Proses')->latest()->limit(5)->get();
        $latestSelesai = Tiket::where('status', 'Selesai')->latest()->limit(5)->get();


        $data = [
            'tiketNew' => $tiketNew,
            'tiketProses' => $tiketProses,
            'tiketClosed' => $tiketClosed,
            'totalTiket' => $totalTiket,
            'latestTiket' => $latestTiket,
            'latestProses' => $latestProses,
            'latestSelesai' => $latestSelesai
        ];
        return view('dashboard.aqr-dashboard.dashboard', $data);
    }
}
