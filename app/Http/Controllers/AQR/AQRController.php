<?php

namespace App\Http\Controllers\AQR;

use App\Models\User;
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
        if (Auth::user()->hasAnyRole(['super-admin', 'humas'])) {

            $tiketNew = Tiket::where('status', 'New')->count();
            $tiketProses = Tiket::where('status', 'Proses')->count();
            $tiketClosed = Tiket::where('status', 'Selesai')->count();
            $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

            $latestTiket = Tiket::where('status', 'New')->latest()->limit(5)->get();
            $latestProses = Tiket::where('status', 'Proses')->latest()->limit(5)->get();
            $latestSelesai = Tiket::where('status', 'Selesai')->latest()->limit(5)->get();
        } else if (Auth::user()->hasAnyRole(['kepala-tata-usaha', 'kepala-sekolah', 'kepala-psikolog', 'psikolog'])) {


            if (Auth::user()->hasRole('kepala-tata-usaha')) {


                $tiketKTU = Tiket::whereHas('option', function ($query) use ($unit) {
                    $query->where('kategori_pic', 'Kepala TU');
                });

                $tiketNew =  (clone $tiketKTU)->where('status', 'New')
                    ->where('lokasi_sekolah', $unit)->count();
                $tiketProses = (clone $tiketKTU)->where('status', 'Proses')
                    ->where('lokasi_sekolah', $unit)->count();
                $tiketClosed = (clone $tiketKTU)->where('status', 'Selesai')
                    ->where('lokasi_sekolah', $unit)->count();
                $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

                $latestTiket = (clone $tiketKTU)->where('status', 'New')
                    ->where('lokasi_sekolah', $unit)->latest()->limit(5)->get();
                $latestProses = (clone $tiketKTU)->where('status', 'Proses')
                    ->where('lokasi_sekolah', $unit)->latest()->limit(5)->get();
                $latestSelesai = (clone $tiketKTU)->where('status', 'Selesai')
                    ->where('lokasi_sekolah', $unit)->latest()->limit(5)->get();
            }

            if (Auth::user()->hasRole('kepala-sekolah')) {
                $tiketKepsek = Tiket::whereHas('option', function ($query) use ($unit) {
                    $query->where('kategori_pic', 'Kepala Sekolah');
                });



                $tiketNew = (clone $tiketKepsek)->where('status', 'New')->where('lokasi_sekolah', $unit)->count();
                $tiketProses =  (clone $tiketKepsek)->where('status', 'Proses')->where('lokasi_sekolah', $unit)->count();
                $tiketClosed =  (clone $tiketKepsek)->where('status', 'Selesai')->where('lokasi_sekolah', $unit)->count();
                $totalTiket =  $tiketProses + $tiketClosed;


                // dd($tiketProses);

                $latestTiket =  (clone $tiketKepsek)->where('status', 'New')->where('lokasi_sekolah', $unit)->latest()->limit(5)->get();
                $latestProses =  (clone $tiketKepsek)->where('status', 'Proses')->where('lokasi_sekolah', $unit)->latest()->limit(5)->get();
                $latestSelesai =  (clone $tiketKepsek)->where('status', 'Selesai')->where('lokasi_sekolah', $unit)->latest()->limit(5)->get();
            }

            if (Auth::user()->hasRole('kepala-psikolog') || Auth::user()->hasRole('psikolog')) {
                $tiketPsikolog = Tiket::whereHas('option', function ($query) use ($unit) {
                    $query->where('kategori_pic', 'Psikolog');
                });

                $tiketNew = (clone $tiketPsikolog)->where('jenjang', $jenjang)->where('lokasi_sekolah', $unit)->where('status', 'New')->count();
                $tiketProses =  (clone $tiketPsikolog)->where('jenjang', $jenjang)->where('status', 'Proses')->where('lokasi_sekolah', $unit)->count();
                $tiketClosed =  (clone $tiketPsikolog)->where('jenjang', $jenjang)->where('status', 'Selesai')->where('lokasi_sekolah', $unit)->count();
                $totalTiket =  $tiketProses + $tiketClosed;
                // dd($tiketProses);

                $latestTiket =  (clone $tiketPsikolog)->where('jenjang', $jenjang)->where('status', 'New')->where('lokasi_sekolah', $unit)->latest()->limit(5)->get();
                $latestProses =  (clone $tiketPsikolog)->where('jenjang', $jenjang)->where('jenjang', $jenjang)->where('status', 'Proses')->where('lokasi_sekolah', $unit)->latest()->limit(5)->get();
                $latestSelesai =  (clone $tiketPsikolog)->where('jenjang', $jenjang)->where('status', 'Selesai')->where('lokasi_sekolah', $unit)->latest()->limit(5)->get();
            }


            // dd($tiketNew);



        } else {

            $tiketPIC = Tiket::query();

            $tiketNew =  (clone $tiketPIC)->where('status', 'New')->where('lokasi_sekolah', $unit)->where('pic_id', auth()->user()->id)->count();
            $tiketProses = (clone $tiketPIC)->where('status', 'Proses')->where('lokasi_sekolah', $unit)->where('pic_id', auth()->user()->id)->count();
            $tiketClosed = (clone $tiketPIC)->where('status', 'Selesai')->where('lokasi_sekolah', $unit)->where('pic_id', auth()->user()->id)->count();
            $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

            $latestTiket = (clone $tiketPIC)->where('status', 'New')->where('lokasi_sekolah', $unit)->latest()->limit(5)->where('pic_id', auth()->user()->id)->get();
            $latestProses = (clone $tiketPIC)->where('status', 'Proses')->where('lokasi_sekolah', $unit)->where('pic_id', auth()->user()->id)->latest()->limit(5)->get();
            $latestSelesai = (clone $tiketPIC)->where('status', 'Selesai')->where('lokasi_sekolah', $unit)->where('pic_id', auth()->user()->id)->latest()->limit(5)->get();
        }



        // dd($totalTiket);


        // dd(str_contains(Tiket::first()->lokasi_kendala,'TK'));



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


        // dd($barChartData);

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
            'typePengirimChart' => json_encode($typePengirimChart),
            'listPsikolog' => User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['psikolog', 'kepala-psikolog']);
            })->get()
        ];
        return view('dashboard.aqr-dashboard.dashboard', $data);
    }
}
