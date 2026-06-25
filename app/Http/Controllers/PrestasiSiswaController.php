<?php

namespace App\Http\Controllers;

use App\Models\MasterPrestasiSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PrestasiSiswaController extends Controller
{
    public function index()
    {
        $prestasi = MasterPrestasiSiswa::latest()->get();
        return Inertia::render('PrestasiSiswa/Index', ['prestasi' => $prestasi]);
    }

    public function create()
    {
        $users = User::all(['id', 'name']);
        return Inertia::render('PrestasiSiswa/Create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'wilayah' => 'required',
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
        
        if (is_array($request->nama_pelatih)) {
            $data['nama_pelatih'] = json_encode($request->nama_pelatih);
        }
        if (is_array($request->nama_pembina)) {
            $data['nama_pembina'] = json_encode($request->nama_pembina);
        }

        $data['created_by'] = auth()->id();

        MasterPrestasiSiswa::create($data);

        return redirect()->route('prestasi-siswa.index')->with('success', 'Data prestasi siswa berhasil ditambahkan');
    }

    public function edit($id)
    {
        $prestasi = MasterPrestasiSiswa::findOrFail($id);
        $users = User::all(['id', 'name']);
        // Ensure nama_pelatih and nama_pembina are arrays before passing to the view
        $prestasi->nama_pelatih = is_string($prestasi->nama_pelatih) ? json_decode($prestasi->nama_pelatih, true) : $prestasi->nama_pelatih;
        $prestasi->nama_pembina = is_string($prestasi->nama_pembina) ? json_decode($prestasi->nama_pembina, true) : $prestasi->nama_pembina;

        return Inertia::render('PrestasiSiswa/Edit', ['prestasi' => $prestasi, 'users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $prestasi = MasterPrestasiSiswa::findOrFail($id);

        $request->validate([
            'nama_siswa' => 'required',
            'kelas' => 'required',
            'wilayah' => 'required',
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
        
        if (is_array($request->nama_pelatih)) {
            $data['nama_pelatih'] = json_encode($request->nama_pelatih);
        }
        if (is_array($request->nama_pembina)) {
            $data['nama_pembina'] = json_encode($request->nama_pembina);
        }

        $prestasi->update($data);

        return redirect()->route('prestasi-siswa.index')->with('success', 'Data prestasi siswa berhasil diubah');
    }

    public function destroy($id)
    {
        $prestasi = MasterPrestasiSiswa::findOrFail($id);
        $prestasi->delete();

        return redirect()->route('prestasi-siswa.index')->with('success', 'Data prestasi siswa berhasil dihapus');
    }
}
