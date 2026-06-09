<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\MasterSiswa;
use App\Models\DataPrestasi;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

        $sekolahs = Sekolah::all();

        return Inertia::render('Sekolah/sekolah-index', [
            'jagakarsa' => $jagakarsa,
            'cinere' => $cinere,
            'pamulang' => $pamulang,
            'prestasiJagakarsa' => $prestasiJagakarsa,
            'prestasiCinere' => $prestasiCinere,
            'prestasiPamulang' => $prestasiPamulang,
            'tingkatJagakarsa' => $tingkatJagakarsa,
            'tingkatCinere' => $tingkatCinere,
            'tingkatPamulang' => $tingkatPamulang,
            'tahunJagakarsa' => array_values($tahunJagakarsa),
            'tahunCinere' => array_values($tahunCinere),
            'tahunPamulang' => array_values($tahunPamulang),
            'tahunLabels' => array_keys($tahunJagakarsa + $tahunCinere + $tahunPamulang),
            'sekolahs' => $sekolahs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Sekolah/sekolah-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required',
            'unit' => 'required',
            'jenjang' => 'required'
        ]);

        Sekolah::create($request->all());
        return redirect()->route('sekolah.index')->with('success', 'Data sekolah berhasil ditambahkan');
    }

    public function show(Sekolah $sekolah)
    {
        //
    }

    public function edit(Sekolah $sekolah)
    {
        return Inertia::render('Sekolah/sekolah-edit', ['sekolah' => $sekolah]);
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $request->validate([
            'nama_sekolah' => 'required',
            'unit' => 'required',
            'jenjang' => 'required'
        ]);

        $sekolah->update($request->all());
        return redirect()->route('sekolah.index')->with('success', 'Data sekolah berhasil diupdate');
    }

    public function destroy(Sekolah $sekolah)
    {
        $sekolah->delete();
        return redirect()->route('sekolah.index')->with('success', 'Data sekolah berhasil dihapus');
    }
}
