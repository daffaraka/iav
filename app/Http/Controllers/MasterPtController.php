<?php

namespace App\Http\Controllers;

use App\Models\MasterPt;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MasterPtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ptns = MasterPt::latest()->get();
        return Inertia::render('MasterPTN/ptn-index', ['ptns' => $ptns]);
    }

    public function create()
    {
        return Inertia::render('MasterPTN/ptn-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pt' => 'required',
            'status_pt' => 'required'
        ]);

        MasterPt::create($request->all());
        return redirect()->route('master-ptn.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(MasterPt $MasterPt)
    {
        return Inertia::render('MasterPTN/ptn-edit', ['MasterPt' => $MasterPt]);
    }

    public function update(Request $request, MasterPt $MasterPt)
    {
        $request->validate([
            'nama_pt' => 'required',
            'status_pt' => 'required'
        ]);

        $MasterPt->update($request->all());
        return redirect()->route('master-ptn.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(MasterPt $MasterPt)
    {
        $MasterPt->delete();
        return redirect()->route('master-ptn.index')->with('success', 'Data berhasil dihapus');
    }
}
