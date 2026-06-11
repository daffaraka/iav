<?php

namespace App\Http\Controllers;

use App\Models\MasterKelas;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MasterKelasController extends Controller
{
    public function index()
    {
        $kelas = MasterKelas::with('waliKelas')->latest()->get();
        return Inertia::render('MasterKelas/master-kelas-index', [
            'kelas' => $kelas
        ]);
    }

    public function create()
    {
        $guru = User::role(['guru', 'walikelas'])->get();
        return Inertia::render('MasterKelas/master-kelas-create', [
            'guru' => $guru
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:master_kelas',
            'deskripsi' => 'nullable|string',
            'wali_kelas_id' => 'nullable|exists:users,id'
        ]);

        MasterKelas::create($request->all());

        return redirect()->route('master-kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $masterKela = MasterKelas::findOrFail($id);
        $guru = User::role(['guru', 'walikelas'])->get();
        return Inertia::render('MasterKelas/master-kelas-edit', [
            'kelas' => $masterKela,
            'guru' => $guru
        ]);
    }

    public function update(Request $request, $id)
    {
        $masterKela = MasterKelas::findOrFail($id);
        $request->validate([
            'nama_kelas' => 'required|string|max:255|unique:master_kelas,nama_kelas,' . $masterKela->id,
            'deskripsi' => 'nullable|string',
            'wali_kelas_id' => 'nullable|exists:users,id'
        ]);

        $masterKela->update($request->all());

        return redirect()->route('master-kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $masterKela = MasterKelas::findOrFail($id);
        $masterKela->delete();
        return redirect()->route('master-kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
