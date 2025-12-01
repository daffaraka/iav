<?php

namespace App\Http\Controllers;

use App\Models\LowonganPekerjaan;
use Illuminate\Http\Request;

class LowonganPekerjaanController extends Controller
{
    public function index()
    {
        $title = 'Data Lowongan Pekerjaan';
        $lowongans = LowonganPekerjaan::with('applies')->latest()->paginate(10);
        return view('dashboard.lowongan.lowongan-index', compact('title', 'lowongans'));
    }

    public function create()
    {
        $title = 'Tambah Lowongan Pekerjaan';
        return view('dashboard.lowongan.lowongan-create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_lowongan' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|in:Full Time,Part Time,Kontrak,Magang',
            'persyaratan' => 'required|string',
            'tanggal_tutup' => 'required|date|after:today',
            'kontak_email' => 'required|email',
        ]);

        LowonganPekerjaan::create($request->all());
        return redirect()->route('lowongan-pekerjaan.index')->with('success', 'Lowongan berhasil ditambahkan');
    }

    public function show(LowonganPekerjaan $lowonganPekerjaan)
    {
        $lowonganPekerjaan->load('applies');
        $title = 'Detail Lowongan';
        return view('dashboard.lowongan.lowongan-show', compact('title', 'lowonganPekerjaan'));
    }

    public function edit(LowonganPekerjaan $lowonganPekerjaan)
    {

        $lowonganPekerjaan->load('applies');
        $title = 'Edit Lowongan';
        return view('dashboard.lowongan.lowongan-edit', compact('title', 'lowonganPekerjaan'));
    }

    public function update(Request $request, LowonganPekerjaan $lowonganPekerjaan)
    {
        $request->validate([
            'judul_lowongan' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'jenis_pekerjaan' => 'required|in:Full Time,Part Time,Kontrak,Magang',
            'persyaratan' => 'required|string',
            'tanggal_tutup' => 'required|date',
            'kontak_email' => 'required|email',
        ]);

        $lowonganPekerjaan->update($request->all());
        return redirect()->route('lowongan-pekerjaan.index')->with('success', 'Lowongan berhasil diupdate');
    }

    public function destroy(LowonganPekerjaan $lowonganPekerjaan)
    {
        $lowonganPekerjaan->delete();
        return redirect()->route('lowongan-pekerjaan.index')->with('success', 'Lowongan berhasil dihapus');
    }
}
