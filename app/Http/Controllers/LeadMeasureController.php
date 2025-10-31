<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Wig;
use App\Models\LeadMeasure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LeadMeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Wig $wig)
    {
        $title = 'Tambah Lead Measure';
        $data = [
            'title' => $title,
            'modul' => Str::lower($title),
            'wig' => $wig
        ];
        return view('dashboard.lead-measure.create-lm-by-dept', $data);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request, Wig $wig)
    {
        $request->validate([
            'judul_lead' => 'required|string|max:255',
            'deskripsi_lead' => 'required|string',
            'target' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
            'status' => 'required|in:active,inactive',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai'
        ]);



        LeadMeasure::create([
            'wig_id' => $wig->id,
            'judul_lead' => $request->judul_lead,
            'deskripsi_lead' => $request->deskripsi_lead,
            'target' => $request->target,
            'satuan' => $request->satuan,
            // 'status' => $request->status,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);
        return redirect()->route('dept.show.wig', [$wig->departement_id, $wig])->with('success', 'Lead Measure berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadMeasure $leadMeasure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadMeasure $leadMeasure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadMeasure $leadMeasure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadMeasure $leadMeasure)
    {
        //
    }


    public function getLmTasks(Request $request)
    {

        // dd($request->all());

        $bulan = Carbon::parse($request->bulan);


        $leadMeasure = LeadMeasure::find($request->id);



        $tasks = $leadMeasure->tasks()->whereMonth('tanggal_realisasi', $bulan->month)->get();

        //   dd($tasks);
        return response()->json($tasks);
    }


    public function getLm(Request $request)
    {
        $leadMeasure = LeadMeasure::find($request->id);
        return response()->json($leadMeasure);
    }
}
