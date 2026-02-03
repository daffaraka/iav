<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\MasterSiswa;
use App\Models\DataPrestasi;
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

        $prestasiJagakarsa = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Jagakarsa'))->count();
        $prestasiCinere = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Cinere'))->count();
        $prestasiPamulang = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Pamulang'))->count();

        // Chart Tingkat Lomba
        $tingkatJagakarsa = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Jagakarsa'))
            ->selectRaw('tingkat_lomba, COUNT(*) as total')
            ->groupBy('tingkat_lomba')
            ->get()
            ->map(fn($item) => ['name' => $item->tingkat_lomba, 'y' => $item->total])
            ->toArray();

        $tingkatCinere = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Cinere'))
            ->selectRaw('tingkat_lomba, COUNT(*) as total')
            ->groupBy('tingkat_lomba')
            ->get()
            ->map(fn($item) => ['name' => $item->tingkat_lomba, 'y' => $item->total])
            ->toArray();

        $tingkatPamulang = [['name' => 'Nasional', 'y' => 8], ['name' => 'Provinsi', 'y' => 5], ['name' => 'Kota', 'y' => 3]];

        // Chart Prestasi per Tahun
        $tahunJagakarsa = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Jagakarsa'))
            ->selectRaw('tahun_pelajaran, COUNT(*) as total')
            ->groupBy('tahun_pelajaran')
            ->orderBy('tahun_pelajaran')
            ->get()
            ->pluck('total', 'tahun_pelajaran')
            ->toArray();

        $tahunCinere = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Cinere'))
            ->selectRaw('tahun_pelajaran, COUNT(*) as total')
            ->groupBy('tahun_pelajaran')
            ->orderBy('tahun_pelajaran')
            ->get()
            ->pluck('total', 'tahun_pelajaran')
            ->toArray();

        $tahunPamulang = ['2022/2023' => 4, '2023/2024' => 7, '2024/2025' => 5];

        return view('dashboard.sekolah.sekolah-index', [
            'jagakarsa' => json_encode($jagakarsa),
            'cinere' => json_encode($cinere),
            'pamulang' => json_encode($pamulang),
            'prestasiJagakarsa' => $prestasiJagakarsa,
            'prestasiCinere' => $prestasiCinere,
            'prestasiPamulang' => $prestasiPamulang,
            'tingkatJagakarsa' => json_encode($tingkatJagakarsa),
            'tingkatCinere' => json_encode($tingkatCinere),
            'tingkatPamulang' => json_encode($tingkatPamulang),
            'tahunJagakarsa' => json_encode(array_values($tahunJagakarsa)),
            'tahunCinere' => json_encode(array_values($tahunCinere)),
            'tahunPamulang' => json_encode(array_values($tahunPamulang)),
            'tahunLabels' => json_encode(array_keys($tahunJagakarsa + $tahunCinere + $tahunPamulang))
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
