<?php

namespace App\Http\Controllers;

use App\Models\DataPrestasi;
use Illuminate\Http\Request;

class DataPrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jagakarsa = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Jagakarsa'))
            ->with('siswa')
            ->latest()
            ->limit(5)
            ->get();

        $cinere = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Cinere'))
            ->with('siswa')
            ->latest()
            ->limit(5)
            ->get();

        $pamulang = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Pamulang'))
            ->with('siswa')
            ->latest()
            ->limit(5)
            ->get();

        $allPrestasi = DataPrestasi::with('siswa.sekolah')->latest()->get();

        return view('dashboard.prestasi.prestasi-index', compact('jagakarsa', 'cinere', 'pamulang', 'allPrestasi'));
    }

    public function jagakarsa()
    {
        $prestasi = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Jagakarsa'))
            ->with('siswa.sekolah')
            ->latest()
            ->get();
        return view('dashboard.prestasi.sekolah', ['prestasi' => $prestasi, 'sekolah' => 'Jagakarsa']);
    }

    public function cinere()
    {
        $prestasi = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Cinere'))
            ->with('siswa.sekolah')
            ->latest()
            ->get();
        return view('dashboard.prestasi.sekolah', ['prestasi' => $prestasi, 'sekolah' => 'Cinere']);
    }

    public function pamulang()
    {
        $prestasi = DataPrestasi::whereHas('siswa.sekolah', fn($q) => $q->where('unit', 'Pamulang'))
            ->with('siswa.sekolah')
            ->latest()
            ->get();
        return view('dashboard.prestasi.sekolah', ['prestasi' => $prestasi, 'sekolah' => 'Pamulang']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = \App\Models\MasterSiswa::with('sekolah')->get();
        return view('dashboard.prestasi.create', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'master_siswa_id' => 'required',
            'nama_lomba' => 'required',
            'tingkat_lomba' => 'required',
            'status_lomba' => 'required'
        ]);

        $siswa = \App\Models\MasterSiswa::find($request->master_siswa_id);
        DataPrestasi::create(array_merge($request->all(), ['sekolah_id' => $siswa->sekolah_id]));
        
        return redirect()->route('data-prestasi.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $prestasi = DataPrestasi::with('siswa.sekolah')->findOrFail($id);
        return view('dashboard.prestasi.show', compact('prestasi'));
    }

    public function edit($id)
    {
        $prestasi = DataPrestasi::findOrFail($id);
        $siswa = \App\Models\MasterSiswa::with('sekolah')->get();
        return view('dashboard.prestasi.edit', compact('prestasi', 'siswa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'master_siswa_id' => 'required',
            'nama_lomba' => 'required',
            'tingkat_lomba' => 'required',
            'status_lomba' => 'required'
        ]);

        $prestasi = DataPrestasi::findOrFail($id);
        $siswa = \App\Models\MasterSiswa::find($request->master_siswa_id);
        $prestasi->update(array_merge($request->all(), ['sekolah_id' => $siswa->sekolah_id]));
        
        return redirect()->route('data-prestasi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        DataPrestasi::findOrFail($id)->delete();
        return redirect()->route('data-prestasi.index')->with('success', 'Data berhasil dihapus');
    }
}
