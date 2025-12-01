<?php

namespace App\Http\Controllers;

use App\Models\LowonganProgress;
use App\Models\LowonganApply;
use Illuminate\Http\Request;

class LowonganProgressController extends Controller
{
    public function index()
    {
        $title = 'Progress Pelamar';
        $progress = LowonganProgress::with('lowonganApply.lowonganPekerjaan')->latest()->paginate(10);
        return view('dashboard.lowongan.progress.progress-index', compact('title', 'progress'));
    }

    public function create()
    {
        $title = 'Tambah Progress';
        $applies = LowonganApply::with('lowonganPekerjaan')->get();
        return view('dashboard.lowongan.progress.progress-create', compact('title', 'applies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lowongan_apply_id' => 'required|exists:lowongan_applies,id',
            'status' => 'required|in:Pending,Review,Interview,Diterima,Ditolak',
            'keterangan' => 'nullable|string',
            'tanggal_progress' => 'required|date',
        ]);

        LowonganProgress::create($request->all());
        
        // Update status di apply
        $apply = LowonganApply::find($request->lowongan_apply_id);
        $apply->update(['status' => $request->status]);

        return redirect()->route('lowongan-progress.index')->with('success', 'Progress berhasil ditambahkan');
    }

    public function show(LowonganProgress $lowonganProgress)
    {
        $title = 'Detail Progress';
        $lowonganProgress->load('lowonganApply.lowonganPekerjaan');
        return view('dashboard.lowongan.progress.progress-show', compact('title', 'lowonganProgress'));
    }

    public function edit(LowonganProgress $lowonganProgress)
    {
        $title = 'Edit Progress';
        $applies = LowonganApply::with('lowonganPekerjaan')->get();
        return view('dashboard.lowongan.progress.progress-edit', compact('title', 'lowonganProgress', 'applies'));
    }

    public function update(Request $request, LowonganProgress $lowonganProgress)
    {
        $request->validate([
            'lowongan_apply_id' => 'required|exists:lowongan_applies,id',
            'status' => 'required|in:Pending,Review,Interview,Diterima,Ditolak',
            'keterangan' => 'nullable|string',
            'tanggal_progress' => 'required|date',
        ]);

        $lowonganProgress->update($request->all());
        
        // Update status di apply
        $apply = LowonganApply::find($request->lowongan_apply_id);
        $apply->update(['status' => $request->status]);

        return redirect()->route('lowongan-progress.index')->with('success', 'Progress berhasil diupdate');
    }

    public function destroy(LowonganProgress $lowonganProgress)
    {
        $lowonganProgress->delete();
        return redirect()->route('lowongan-progress.index')->with('success', 'Progress berhasil dihapus');
    }
}