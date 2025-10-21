<?php

namespace App\Http\Controllers;


use Exception;
use Carbon\Carbon;
use App\Models\Wig;
use App\Models\Departement;
use App\Models\LeadMeasure;
use App\Models\TaskProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Departement';
        $departement = Departement::all();




        $data = [
            'title' => $title,
            'departement' => $departement
        ];
        return view('dashboard.departement.dept-index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Departement $departement)
    {

        $title = $departement->nama_dept;


        $chartPerWig = [];

        foreach ((clone $departement)->wigs as $index => $wig) {

            $chartWig = (clone $wig)->load('wig_progresses')->wig_progresses->groupBy('bulan')->map(function ($progress, $bulan) use ($wig) {
                return [
                    'judul_wig' => $wig->judul_wig,
                    'bulan' => Carbon::create()->month($bulan)->locale('id')->translatedFormat('F'),
                    'progress' => $progress->sum('progress_wig')
                ];
            })->sortKeys()->toArray();

            // dd($chartWig);
            $chartPerWig[$index] =  $chartWig;

        }

        // dd($chartPerWig);

        $data = [
            'title' => $title,
            'departement' => $departement->load('wigs'),
            'wig_total' => $departement->wigs()->count(),
            'wig_aktif' => $departement->wigs()->where('status_wig', 1)->count(),
            'wig_selesai' => $departement->wigs()->where('status_wig', 2)->count(),
            'wig_tidak_aktif' => $departement->wigs()->where('status_wig', 0)->count(),
            'chartPerWig' => $chartPerWig
        ];

        // dd($data);


        return view('dashboard.departement.dept-show', $data);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departement $departement) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departement $departement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departement $departement)
    {
        //
    }


    public function showWig(Departement $departement, Wig $wig)
    {

        $progressTerbaru = TaskProcess::with('lead_measure')->orderBy('created_at', 'desc')->take(5)->get();



        // $dataLeadMeasure = $wig->lead_measures()->with('tasks')->get();


        // dd($dataLeadMeasure);
        // dd($progressTerbaru);
        $tasks = DB::table('task_processes')
            ->select(
                'lead_measure_id',
                DB::raw("DATE_FORMAT(tanggal_realisasi, '%M') as bulan"),
                'nama_tugas',
                'deskripsi',
                'jumlah_realisasi',
                'dokumen',
                'tanggal_realisasi',
                'status_tugas'
            )
            ->whereIn('lead_measure_id', (clone $wig)->lead_measures->pluck('id'))
            ->orderBy(DB::raw("MONTH(tanggal_realisasi)"))
            ->get()
            ->groupBy(['lead_measure_id', 'bulan']); // 👈 group by 2 level



        $chartWig = (clone $wig)->load('wig_progresses')->wig_progresses->groupBy('bulan')->map(function ($progress, $bulan) {
            return [
                'bulan' => Carbon::create()->month($bulan)->locale('id')->translatedFormat('F'),
                'progress' => $progress->sum('progress_wig')
            ];
        })->sortKeys()->toArray();



        $data = [
            'title' => $departement->nama_dept . ' | ' . $wig->judul_wig,
            'departement' => $departement,
            'wig' => $wig,
            'data_lm' => $tasks,
            'progressTerbaru' => $progressTerbaru,
            'chartWig' => $chartWig
        ];

        return view('dashboard.departement.dept-show-wig', $data);
    }
}
