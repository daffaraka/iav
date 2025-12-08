<?php

namespace App\Http\Controllers\AQR;

use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AQRController extends Controller
{
    public function index()
    {

        if (Auth::user()->hasAnyRole('super-admin')) {

            $tiketNew = Tiket::where('status', 'New')->count();
            $tiketProses = Tiket::where('status', 'Proses')->count();
            $tiketClosed = Tiket::where('status', 'Selesai')->count();
            $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

            $latestTiket = Tiket::where('status', 'New')->latest()->limit(5)->get();
            $latestProses = Tiket::where('status', 'Proses')->latest()->limit(5)->get();
            $latestSelesai = Tiket::where('status', 'Selesai')->latest()->limit(5)->get();
        } else {

            $tiketNew = Tiket::where('status', 'New')->where('pic_id', auth()->user()->id)->count();
            $tiketProses = Tiket::where('status', 'Proses')->where('pic_id', auth()->user()->id)->count();
            $tiketClosed = Tiket::where('status', 'Selesai')->where('pic_id', auth()->user()->id)->count();
            $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

            $latestTiket = Tiket::where('status', 'New')->latest()->limit(5)->where('pic_id', auth()->user()->id)->get();
            $latestProses = Tiket::where('status', 'Proses')->where('pic_id', auth()->user()->id)->latest()->limit(5)->get();
            $latestSelesai = Tiket::where('status', 'Selesai')->where('pic_id', auth()->user()->id)->latest()->limit(5)->get();
        }

        // Chart Data
        $pieChartData = [
            ['name' => 'Baru', 'y' => $tiketNew],
            ['name' => 'Proses', 'y' => $tiketProses],
            ['name' => 'Selesai', 'y' => $tiketClosed]
        ];

        // Bar Chart Data - Weekly by Location
        $weeklyData = Tiket::selectRaw('WEEK(created_at) as week, lokasi_kendala, COUNT(*) as total')
            ->whereRaw('created_at >= DATE_SUB(NOW(), INTERVAL 4 WEEK)')
            ->groupBy('week', 'lokasi_kendala')
            ->orderBy('week')
            ->get();

        $barChartData = [];
        $locations = $weeklyData->pluck('lokasi_kendala')->unique()->values();
        
        foreach ($locations as $location) {
            $barChartData[] = [
                'name' => $location ?: 'Tidak Diketahui',
                'data' => $weeklyData->where('lokasi_kendala', $location)->pluck('total')->toArray()
            ];
        }

        $weekLabels = $weeklyData->pluck('week')->unique()->sort()->values()->toArray();

        // $tiketNew = Tiket::where('status', 'New')->count();
        // $tiketProses = Tiket::where('status', 'Proses')->count();
        // $tiketClosed = Tiket::where('status', 'Selesai')->count();
        // $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

        // $latestTiket = Tiket::where('status', 'New')->latest()->limit(5)->get();
        // $latestProses = Tiket::where('status', 'Proses')->latest()->limit(5)->get();
        // $latestSelesai = Tiket::where('status', 'Selesai')->latest()->limit(5)->get();


        $data = [
            'tiketNew' => $tiketNew,
            'tiketProses' => $tiketProses,
            'tiketClosed' => $tiketClosed,
            'totalTiket' => $totalTiket,
            'latestTiket' => $latestTiket,
            'latestProses' => $latestProses,
            'latestSelesai' => $latestSelesai,
            'pieChartData' => json_encode($pieChartData),
            'barChartData' => json_encode($barChartData),
            'weekLabels' => json_encode($weekLabels)
        ];
        return view('dashboard.aqr-dashboard.dashboard', $data);
    }
}
