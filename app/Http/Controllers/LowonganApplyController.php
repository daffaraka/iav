<?php

namespace App\Http\Controllers;

use App\Models\LowonganApply;
use App\Models\LowonganPekerjaan;
use Illuminate\Http\Request;

class LowonganApplyController extends Controller
{
    public function index()
    {
        $title = 'Data Pelamar Lowongan';
        $applies = LowonganApply::with('lowonganPekerjaan')->latest()->paginate(10);
        return view('dashboard.lowongan.apply.apply-index', compact('title', 'applies'));
    }

    public function create()
    {
        $title = 'Tambah Pelamar';
        $lowongans = LowonganPekerjaan::where('status', 'Aktif')->get();
        return view('dashboard.lowongan.apply.apply-create', compact('title', 'lowongans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lowongan_pekerjaan_id' => 'required|exists:lowongan_pekerjaans,id',
            'nama_pelamar' => 'required|string|max:255',
            'email_pelamar' => 'required|email',
            'phone_pelamar' => 'required|string|max:20',
            'alamat_pelamar' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('cv_file')) {
            $lowongan = LowonganPekerjaan::find($request->lowongan_pekerjaan_id);
            $filename = $lowongan->nama_pekerjaan . '-' . $request->nama_pelamar . '-' . time();
            $data['cv_file'] = $request->file('cv_file')->storeAs('cv_files', $filename . '.' . $request->file('cv_file')->extension(), 'public');
        }

        LowonganApply::create($data);
        return redirect()->route('lowongan-apply.index')->with('success', 'Pelamar berhasil ditambahkan');
    }

    public function show(LowonganApply $lowonganApply)
    {
        $title = 'Detail Pelamar';
        $lowonganApply->load('lowonganPekerjaan', 'progress');
        return view('dashboard.lowongan.apply.apply-show', compact('title', 'lowonganApply'));
    }

    public function edit(LowonganApply $lowonganApply)
    {
        $title = 'Edit Pelamar';
        $lowongans = LowonganPekerjaan::where('status', 'Aktif')->get();
        return view('dashboard.lowongan.apply.apply-edit', compact('title', 'lowonganApply', 'lowongans'));
    }

    public function update(Request $request, LowonganApply $lowonganApply)
    {
        $request->validate([
            'lowongan_pekerjaan_id' => 'required|exists:lowongan_pekerjaans,id',
            'nama_pelamar' => 'required|string|max:255',
            'email_pelamar' => 'required|email',
            'phone_pelamar' => 'required|string|max:20',
            'alamat_pelamar' => 'required|string',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string',
            'status' => 'required|in:Pending,Review,Interview,Diterima,Ditolak',
        ]);

        $data = $request->all();

        if ($request->hasFile('cv_file')) {
            $data['cv_file'] = $request->file('cv_file')->store('cv_files', 'public');
        }

        $lowonganApply->update($data);
        return redirect()->route('lowongan-apply.index')->with('success', 'Pelamar berhasil diupdate');
    }

    public function destroy(LowonganApply $lowonganApply)
    {
        $lowonganApply->delete();
        return redirect()->route('lowongan-apply.index')->with('success', 'Pelamar berhasil dihapus');
    }
}
