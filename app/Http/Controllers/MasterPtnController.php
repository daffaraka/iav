<?php

namespace App\Http\Controllers;

use App\Models\MasterPtn;
use Illuminate\Http\Request;

class MasterPtnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ptns = MasterPtn::latest()->paginate(10);
        return view('dashboard.master-ptn.index', compact('ptns'));
    }

    public function create()
    {
        return view('dashboard.master-ptn.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pt' => 'required',
            'status_pt' => 'required'
        ]);

        MasterPtn::create($request->all());
        return redirect()->route('master-ptn.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(MasterPtn $masterPtn)
    {
        return view('dashboard.master-ptn.edit', compact('masterPtn'));
    }

    public function update(Request $request, MasterPtn $masterPtn)
    {
        $request->validate([
            'nama_pt' => 'required',
            'status_pt' => 'required'
        ]);

        $masterPtn->update($request->all());
        return redirect()->route('master-ptn.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(MasterPtn $masterPtn)
    {
        $masterPtn->delete();
        return redirect()->route('master-ptn.index')->with('success', 'Data berhasil dihapus');
    }
}
