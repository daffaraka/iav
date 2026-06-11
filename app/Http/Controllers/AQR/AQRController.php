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


            if (Auth::user()->hasRole(['super-admin', 'admin'])) {
                $tiketNew = Tiket::where('status', 'New')->count();
                $tiketProses = Tiket::where('status', 'Proses')->count();
                $tiketClosed = Tiket::where('status', 'Selesai')->count();
                $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

                $latestTiket = Tiket::with('option')->where('status', 'New')->latest()->limit(5)->get();
                $latestProses = Tiket::with('option')->where('status', 'Proses')->latest()->limit(5)->get();
                $latestSelesai = Tiket::with('option')->where('status', 'Selesai')->latest()->limit(5)->get();
            } else {

                $tiketNew = Tiket::where('status', 'New')->where('pengirim','Masyarakat Umum')->count();
                $tiketProses = Tiket::where('status', 'Proses')->where('pengirim','Masyarakat Umum')->count();
                $tiketClosed = Tiket::where('status', 'Selesai')->where('pengirim','Masyarakat Umum')->count();
                $totalTiket = $tiketNew + $tiketProses + $tiketClosed;

                $latestTiket = Tiket::with('option')->where('status', 'New')->where('pengirim','Masyarakat Umum')->latest()->limit(5)->get();
                $latestProses = Tiket::with('option')->where('status', 'Proses')->where('pengirim','Masyarakat Umum')->latest()->limit(5)->get();
                $latestSelesai = Tiket::with('option')->where('status', 'Selesai')->where('pengirim','Masyarakat Umum')->latest()->limit(5)->get();
            }
        } else if (Auth::user()->hasAnyRole(['kepala-tata-usaha', 'kepala-sekolah', 'kepala-psikolog', 'psikolog'])) {


            if (Auth::user()->hasRole('kepala-tata-usaha')) {


                $tiketKTU = Tiket::with('option')->whereHas('option', function ($query) use ($unit) {
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
                $tiketKepsek = Tiket::with('option')->whereHas('option', function ($query) use ($unit) {
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
                $tiketPsikolog = Tiket::with('option')->whereHas('option', function ($query) use ($unit) {
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




        } else {

            $tiketPIC = Tiket::with('option');

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

        // Bar Chart Data - Weekly by Location (PHP-based grouping to prevent misalignment and support dev data)
        $latestTicketDate = Tiket::max('created_at');
        if ($latestTicketDate) {
            $latestCarbon = \Carbon\Carbon::parse($latestTicketDate);
            $startDate = (clone $latestCarbon)->subWeeks(3)->startOfWeek();
            $tickets = Tiket::where('created_at', '>=', $startDate)->get();
            
            $weekLabels = [];
            for ($i = 3; $i >= 0; $i--) {
                $weekLabels[] = (clone $latestCarbon)->subWeeks($i)->weekOfYear;
            }
            $weekLabels = array_values(array_unique($weekLabels));
        } else {
            $tickets = collect();
            $now = \Carbon\Carbon::now();
            $weekLabels = [];
            for ($i = 3; $i >= 0; $i--) {
                $weekLabels[] = (clone $now)->subWeeks($i)->weekOfYear;
            }
        }

        $barChartData = [];
        $locations = $tickets->pluck('lokasi_kendala')->unique()->values();

        foreach ($locations as $location) {
            $data = [];
            foreach ($weekLabels as $week) {
                $count = $tickets->filter(function ($ticket) use ($location, $week) {
                    return $ticket->lokasi_kendala === $location && 
                           \Carbon\Carbon::parse($ticket->created_at)->weekOfYear === $week;
                })->count();
                $data[] = $count;
            }
            $barChartData[] = [
                'name' => $location ?: 'Tidak Diketahui',
                'data' => $data
            ];
        }

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

        return \Inertia\Inertia::render('AQR/dashboard-aqr', [
            'stats' => [
                'new' => $tiketNew,
                'proses' => $tiketProses,
                'closed' => $tiketClosed,
                'total' => $totalTiket,
            ],
            'latestTiket' => $latestTiket,
            'latestProses' => $latestProses,
            'latestSelesai' => $latestSelesai,
            'pieChartData' => $pieChartData,
            'barChartData' => $barChartData,
            'weekLabels' => $weekLabels,
            'lokasiChartData' => $lokasiChartData,
            'typePengirimChart' => $typePengirimChart,
            'listPsikolog' => User::whereHas('roles', function ($q) {
                $q->whereIn('name', ['psikolog', 'kepala-psikolog']);
            })->get(),
            'userRoles' => Auth::user()->getRoleNames()
        ]);
    }
}
