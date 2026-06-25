<?php

namespace App\Http\Controllers;

use App\Models\MasterPrestasiGuru;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrestasiGuruController extends Controller
{
    public function index()
    {
        $prestasi = MasterPrestasiGuru::with('user')->latest()->get();
        return Inertia::render('PrestasiGuru/Index', ['prestasi' => $prestasi]);
    }

    public function create()
    {
        $users = User::all(['id', 'name']);
        return Inertia::render('PrestasiGuru/Create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_lomba' => 'required',
            'jenis_lomba' => 'required',
            'mata_bidang_lomba' => 'required',
            'raihan_prestasi' => 'required',
            'tanggal_pelaksanaan_lomba' => 'required|date',
            'tanggal_perolehan_lomba' => 'required|date',
            'penyelenggara' => 'required',
            'level_lomba' => 'required',
            'tahapan_lomba' => 'required',
            'kategori_lomba' => 'required',
            'status_kurasi' => 'required',
            'lanjutan_status_kurasi' => 'required',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        MasterPrestasiGuru::create($data);

        return redirect()->route('prestasi-guru.index')->with('success', 'Data prestasi guru berhasil ditambahkan');
    }

    public function edit($id)
    {
        $prestasi = MasterPrestasiGuru::findOrFail($id);
        $users = User::all(['id', 'name']);
        
        return Inertia::render('PrestasiGuru/Edit', ['prestasi' => $prestasi, 'users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $prestasi = MasterPrestasiGuru::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_lomba' => 'required',
            'jenis_lomba' => 'required',
            'mata_bidang_lomba' => 'required',
            'raihan_prestasi' => 'required',
            'tanggal_pelaksanaan_lomba' => 'required|date',
            'tanggal_perolehan_lomba' => 'required|date',
            'penyelenggara' => 'required',
            'level_lomba' => 'required',
            'tahapan_lomba' => 'required',
            'kategori_lomba' => 'required',
            'status_kurasi' => 'required',
            'lanjutan_status_kurasi' => 'required',
        ]);

        $data = $request->all();

        $prestasi->update($data);

        return redirect()->route('prestasi-guru.index')->with('success', 'Data prestasi guru berhasil diubah');
    }

    public function destroy($id)
    {
        $prestasi = MasterPrestasiGuru::findOrFail($id);
        $prestasi->delete();

        return redirect()->route('prestasi-guru.index')->with('success', 'Data prestasi guru berhasil dihapus');
    }
}
