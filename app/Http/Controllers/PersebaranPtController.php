<?php

namespace App\Http\Controllers;

use App\Models\MasterPtn;
use App\Models\PersebaranPt;
use Illuminate\Http\Request;
class PersebaranPtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $persebarans = PersebaranPt::with('ptn')->latest()->paginate(10);
        return view('dashboard.persebaran-pt.index', compact('persebarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ptns = MasterPtn::orderBy('nama_pt')->get();
        return view('dashboard.persebaran-pt.create', compact('ptns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'master_ptn_id' => 'required|exists:master_pts,id',
            'fakultas' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'starta' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|max:255',
            'jalur_masuk' => 'nullable|string|max:255',
        ]);

        PersebaranPt::create($request->all());

        return redirect()->route('persebaran-pt.index')->with('success', 'Data persebaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PersebaranPt $persebaranPt)
    {
        $persebaranPt->load('ptn');
        return view('dashboard.persebaran-pt.show', compact('persebaranPt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersebaranPt $persebaranPt)
    {
        $ptns = MasterPtn::orderBy('nama_pt')->get();
        return view('dashboard.persebaran-pt.edit', compact('persebaranPt', 'ptns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersebaranPt $persebaranPt)
    {
        $request->validate([
            'master_ptn_id' => 'required|exists:master_pts,id',
            'fakultas' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'starta' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|max:255',
            'jalur_masuk' => 'nullable|string|max:255',
        ]);

        $persebaranPt->update($request->all());
        return redirect()->route('persebaran-pt.index')->with('success', 'Data persebaran berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersebaranPt $persebaranPt)
    {
        $persebaranPt->delete();
        return redirect()->route('persebaran-pt.index')->with('success', 'Data persebaran berhasil dihapus.');
    }
}
