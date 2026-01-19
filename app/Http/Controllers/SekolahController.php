<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\MasterSiswa;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jagakarsa = MasterSiswa::whereHas('sekolah', fn($q) => $q->where('unit', 'Jagakarsa'))
            ->where('jenjang', 'SMA')
            ->selectRaw('jurusan as ptn, COUNT(*) as total')
            ->groupBy('jurusan')
            ->get()
            ->map(fn($item) => ['name' => $item->ptn, 'y' => $item->total])
            ->toArray();

        $cinere = MasterSiswa::whereHas('sekolah', fn($q) => $q->where('unit', 'Cinere'))
            ->where('jenjang', 'SMA')
            ->selectRaw('jurusan as ptn, COUNT(*) as total')
            ->groupBy('jurusan')
            ->get()
            ->map(fn($item) => ['name' => $item->ptn, 'y' => $item->total])
            ->toArray();

        $pamulang = [
            ['name' => 'UI', 'y' => 15],
            ['name' => 'ITB', 'y' => 12],
            ['name' => 'UGM', 'y' => 10],
            ['name' => 'IPB', 'y' => 8],
            ['name' => 'Unpad', 'y' => 6]
        ];

        $prestasiJagakarsa = \App\Models\DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Jagakarsa'))->count();
        $prestasiCinere = \App\Models\DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Cinere'))->count();
        $prestasiPamulang = \App\Models\DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Pamulang'))->count();

        return view('dashboard.sekolah.sekolah-index', [
            'jagakarsa' => json_encode($jagakarsa),
            'cinere' => json_encode($cinere),
            'pamulang' => json_encode($pamulang),
            'prestasiJagakarsa' => $prestasiJagakarsa,
            'prestasiCinere' => $prestasiCinere,
            'prestasiPamulang' => $prestasiPamulang
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Sekolah $sekolah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        //
    }
}
