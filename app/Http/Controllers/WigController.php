<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Exception;
use App\Models\Wig;
use App\Models\Sekolah;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class WigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'WIG';
        // $wig = Wig::all();


        $data = [
            'title' => $title,
            // 'wig' => $wig,
            'modul' => Str::lower($title)
        ];
        return view('dashboard.wig.wig-index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $title = 'Tambah WIG';
        $unit = Sekolah::all()->unique('unit');

        $data = [
            'title' => $title,
            'unit' => $unit,
            'modul' => Str::lower($title)
        ];

        return view('dashboard.wig.wig-create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate request
        $validatedData = $request->validate([
            'nama_wig' => 'required|string|max:255',
            'deskripsi_wig' => 'required|string',
            'tanggal_mulai_wig' => 'required|date',
            'tanggal_berakhir_wig' => 'required|date|after:tanggal_mulai_wig',
            'from_x' => 'required|numeric',
            'from_y' => 'required|numeric|gt:from_x',
            'satuan' => 'required|in:%,Angka'
        ]);

        try {
            // Create new WIG
            $wig = Wig::create([
                'judul_wig' => $request->nama_wig,
                'deskripsi_wig' => $request->deskripsi_wig,
                'tanggal_mulai' => $request->tanggal_mulai_wig,
                'tanggal_berakhir' => $request->tanggal_berakhir_wig,
                'from_x' => $request->from_x,
                'to_y' => $request->from_y,
                'satuan' => $request->satuan,
                'status_wig' => 1, // Set as active
                'departement_id' => $request->departement_id
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'WIG berhasil ditambahkan',
                'data' => $wig
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan WIG',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function storeByDept(Request $request)
    {

        // dd($request->all());
        // Validate request
        $validatedData = $request->validate([
            'nama_wig' => 'required|string|max:255',
            'deskripsi_wig' => 'required|string',
            'tanggal_mulai_wig' => 'required|date',
            'tanggal_berakhir_wig' => 'required|date|after:tanggal_mulai_wig',
            'from_x' => 'required|numeric',
            'from_y' => 'required|numeric|gt:from_x',
            'satuan' => 'required|in:%,Angka'
        ]);

        try {
            // Create new WIG
            $wig = Wig::create([
                'judul_wig' => $request->nama_wig,
                'deskripsi_wig' => $request->deskripsi_wig,
                'tanggal_mulai_wig' => $request->tanggal_mulai_wig,
                'tanggal_berakhir_wig' => $request->tanggal_berakhir_wig,
                'from_x' => $request->from_x,
                'to_y' => $request->from_y,
                'unit_wig' => $request->satuan,
                'status_wig' => 1, // Set as active
                'departement_id' => $request->departement_id,
                'user_id' => 1
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'WIG berhasil ditambahkan',
                'data' => $wig
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan WIG',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Wig $wig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departement $departement, Wig $wig)
    {
        $title = 'Edit WIG';
        $wig = Sekolah::all()->unique('unit');

        $data = [
            'title' => $title,
            'wig' => $wig,
            'modul' => Str::lower($title)
        ];
        return view('dashboard.wig.wig-edit', $data);
    }


    public function editByDept(Departement $departement, Wig $wig)
    {
        $title = 'Edit WIG';

        // dd()
        $data = [
            'title' => $title,
            'dept' => $departement,
            'wig' => $wig,
            'modul' => Str::lower($title)
        ];
        return view('dashboard.wig.wig-edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wig $wig)
    {


       
        $validatedData = $request->validate([
            'nama_wig' => 'required|string|max:255',
            'deskripsi_wig' => 'required|string',
            'tanggal_mulai_wig' => 'required|date',
            'tanggal_berakhir_wig' => 'required|date|after:tanggal_mulai_wig',
            'from_x' => 'required|numeric',
            'from_y' => 'required|numeric|gt:from_x',
            'satuan' => 'required|in:%,Angka'
        ]);


        //   $wig->update([
        //         'judul_wig' => $request->nama_wig,
        //         'deskripsi_wig' => $request->deskripsi_wig,
        //         'tanggal_mulai_wig' => $request->tanggal_mulai_wig,
        //         'tanggal_berakhir_wig' => $request->tanggal_berakhir_wig,
        //         'from_x' => $request->from_x,
        //         'to_y' => $request->from_y,
        //         'satuan' => $request->satuan,
        //         'status_wig' => 1, // Set as active
        //         'departement_id' => $wig->departement_id
        //     ]);



        try {
            // Create new WIG
            $wig->update([
                'judul_wig' => $request->nama_wig,
                'deskripsi_wig' => $request->deskripsi_wig,
                'tanggal_mulai_wig' => $request->tanggal_mulai_wig,
                'tanggal_berakhir_wig' => $request->tanggal_berakhir_wig,
                'from_x' => $request->from_x,
                'to_y' => $request->from_y,
                'satuan' => $request->satuan,
                'status_wig' => 1, // Set as active
                // 'departement_id' => $request->departement_id
            ]);


            //  dd($wig);

            return redirect()->back()->with('success', 'WIG berhasil diupdate');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate WIG: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wig $wig)
    {
        //
    }

    public function wigChart($id)
    {
        $wig = Wig::find($id);
        $chartWig = (clone $wig)->load('wig_progresses')->wig_progresses->groupBy('bulan')->map(function ($progress, $bulan) {
            return [
                'bulan' => Carbon::create()->month($bulan)->locale('id')->translatedFormat('F'),
                'progress' => $progress->sum('progress_wig')
            ];
        })->sortKeys()->toArray();
    }
}
