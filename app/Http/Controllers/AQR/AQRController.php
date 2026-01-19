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

        $unit = Auth::user()->unit;
        $jenjang = Auth::user()->jenjang;
        $departemen = Auth::user()->departemen;




        // dd($unit);
        if (Auth::user()->hasAnyRole(['super-admin','humas'])) {

            $tiketNew = Tiket::where('status', 'New')->count();
            $tiketProses = Tiket::where('status', 'Proses')->count();
            $tiketClosed = Tiket::where('status', 'Selesai')->count();
            $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

            $latestTiket = Tiket::where('status', 'New')->latest()->limit(5)->get();
            $latestProses = Tiket::where('status', 'Proses')->latest()->limit(5)->get();
            $latestSelesai = Tiket::where('status', 'Selesai')->latest()->limit(5)->get();
        } else {

            if (Auth::user()->hasRole('tata-usaha')) {
                $tiketNew = Tiket::where('status', 'New')->whereNotNull('admin_humas_id')->where('lokasi_sekolah',$unit)->where('admin_humas_id', auth()->user()->id)->count();
                $tiketProses = Tiket::where('status', 'Proses')->where('lokasi_sekolah',$unit)->where('admin_humas_id', auth()->user()->id)->count();
                $tiketClosed = Tiket::where('status', 'Selesai')->where('lokasi_sekolah',$unit)->where('admin_humas_id', auth()->user()->id)->count();
                $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

                $latestTiket = Tiket::where('status', 'New')->whereNotNull('admin_humas_id')->where('lokasi_sekolah',$unit)->latest()->limit(5)->where('admin_humas_id', auth()->user()->id)->get();
                $latestProses = Tiket::where('status', 'Proses')->where('lokasi_sekolah',$unit)->where('admin_humas_id', auth()->user()->id)->latest()->limit(5)->get();
                $latestSelesai = Tiket::where('status', 'Selesai')->where('lokasi_sekolah',$unit)->where('admin_humas_id', auth()->user()->id)->latest()->limit(5)->get();
            } else {
                $tiketNew = Tiket::where('status', 'New')->where('pic_id', auth()->user()->id)->count();
                $tiketProses = Tiket::where('status', 'Proses')->where('pic_id', auth()->user()->id)->count();
                $tiketClosed = Tiket::where('status', 'Selesai')->where('pic_id', auth()->user()->id)->count();
                $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

                $latestTiket = Tiket::where('status', 'New')->latest()->limit(5)->where('pic_id', auth()->user()->id)->get();
                $latestProses = Tiket::where('status', 'Proses')->where('pic_id', auth()->user()->id)->latest()->limit(5)->get();
                $latestSelesai = Tiket::where('status', 'Selesai')->where('pic_id', auth()->user()->id)->latest()->limit(5)->get();
            }
        }


        // dd(Tiket::where('admin_humas_id',Auth::user()->id)->get());

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

        // Grouping by lokasi_kendala
        $lokasiChartData = Tiket::selectRaw('lokasi_kendala, COUNT(*) as total')
            ->groupBy('lokasi_kendala')
            ->get()
            ->map(fn($item) => ['name' => $item->lokasi_kendala ?: 'Tidak Diketahui', 'y' => $item->total])
            ->toArray();

        $typePengirimChart = Tiket::selectRaw('pengirim, COUNT(*) as total_pengirim')
            ->groupBy('pengirim')
            ->get()
            ->map(fn($item) => ['name' => $item->pengirim ?: 'Tidak Diketahui', 'y' => $item->total_pengirim])
            ->toArray();

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
            'weekLabels' => json_encode($weekLabels),
            'lokasiChartData' => json_encode($lokasiChartData),
            'typePengirimChart' => json_encode($typePengirimChart)
        ];
        return view('dashboard.aqr-dashboard.dashboard', $data);
    }
}
