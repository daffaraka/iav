<?php

namespace App\Http\Controllers;


use Exception;
use Carbon\Carbon;
use App\Models\Wig;
use App\Models\Departement;
use App\Models\LeadMeasure;
use App\Models\TaskProcess;
use App\Models\TaskProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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
        return Inertia::render('Departement/dept-index', $data);
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

    public function store(Request $request) {}

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


        return Inertia::render('Departement/dept-show', $data);
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
            'title' => $departement->nama_dept . ' > ' . $wig->judul_wig,
            'departement' => $departement,
            'wig' => $wig,
            'data_lm' => $tasks,
            'progressTerbaru' => $progressTerbaru,
            'chartWig' => $chartWig
        ];

        if (request()->ajax()) {
            return response()->json([
                'data_lm' => $tasks,
                'progressTerbaru' => $progressTerbaru,
                'chartWig' => $chartWig
            ]);
        } else {

            return Inertia::render('Departement/dept-show-wig', $data);
        }
    }


    public function addNewTask(Request $request)
    {
        try {
            $request->validate([
                'lm_id' => 'required',
                'nama_tugas' => 'required',
                'deskripsi' => 'required',
                'jumlah_realisasi' => 'required',
                'tanggal_realisasi' => 'required',
                'status_tugas' => 'required',
            ], [
                'lm_id.required' => 'Lead Measure harus diisi',
                'nama_tugas.required' => 'Nama Tugas harus diisi',
                'deskripsi.required' => 'Deskripsi harus diisi',
                'jumlah_realisasi.required' => 'Jumlah Realisasi harus diisi',
                'tanggal_realisasi.required' => 'Tanggal Realisasi harus diisi',
                'status_tugas.required' => 'Status Tugas harus diisi',
            ]);

            $task = new TaskProcess();
            $task->lead_measure_id = $request->lm_id;
            $task->nama_tugas = $request->nama_tugas;
            $task->deskripsi = $request->deskripsi;
            $task->jumlah_realisasi = $request->jumlah_realisasi;
            $task->tanggal_realisasi = $request->tanggal_realisasi;
            $task->status_tugas = $request->status_tugas;
            $task->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Task Baru berhasil ditambahkan',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
        // return dd($request->all());
    }
}
