<?php

namespace App\Http\Controllers;

use App\Models\MasterPt;
use App\Models\MasterSiswa;
use App\Models\PersebaranPt;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersebaranPtController extends Controller
{
    public function index()
    {
        $persebarans = PersebaranPt::with(['ptn','siswa'])->latest()->get();

        $chartJalurMasuk = PersebaranPt::select('jalur_masuk', \DB::raw('count(*) as total'))
            ->whereNotNull('jalur_masuk')
            ->groupBy('jalur_masuk')
            ->pluck('total', 'jalur_masuk');

        $chartTopPtn = PersebaranPt::select('pt_id', \DB::raw('count(*) as total'))
            ->with('ptn:id,nama_pt')
            ->groupBy('pt_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->ptn?->nama_pt ?? 'Unknown' => $item->total];
            });

        $chartStatusPt = PersebaranPt::join('master_pts', 'persebaran_pts.pt_id', '=', 'master_pts.id')
            ->select('master_pts.status_pt', \DB::raw('count(*) as total'))
            ->whereNotNull('master_pts.status_pt')
            ->where('master_pts.status_pt', '!=', '')
            ->groupBy('master_pts.status_pt')
            ->pluck('total', 'status_pt');

        $chartProvinsi = PersebaranPt::join('master_pts', 'persebaran_pts.pt_id', '=', 'master_pts.id')
            ->select('master_pts.provinsi', \DB::raw('count(*) as total'))
            ->whereNotNull('master_pts.provinsi')
            ->where('master_pts.provinsi', '!=', '')
            ->groupBy('master_pts.provinsi')
            ->pluck('total', 'provinsi');

        return Inertia::render('PersebaranPT/persebaran-pt-index', [
            'persebarans' => $persebarans,
            'charts' => [
                'jalurMasuk' => $chartJalurMasuk,
                'topPtn' => $chartTopPtn,
                'statusPt' => $chartStatusPt,
                'provinsi' => $chartProvinsi
            ]
        ]);
    }

    public function create()
    {
        $ptns = MasterPt::orderBy('nama_pt')->get();
        $siswas = MasterSiswa::orderBy('nama')->get();
        
        return Inertia::render('PersebaranPT/persebaran-pt-create', [
            'ptns' => $ptns,
            'siswas' => $siswas
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pt_id' => 'required|exists:master_pts,id',
            'siswa_id' => 'required|exists:master_siswas,id',
            'fakultas' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'rumpun_ilmu' => 'nullable|in:Saintek,Soshum,Campuran',
            'program_studi' => 'nullable|string|max:255',
            'starta' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|max:255',
            'jalur_masuk' => 'nullable|string|max:255',
        ]);

        PersebaranPt::create($request->all());

        return redirect()->route('persebaran-ptn.index')->with('success', 'Data persebaran berhasil ditambahkan.');
    }

    public function show(PersebaranPt $persebaranPtn)
    {
        $persebaranPtn->load(['ptn', 'siswa']);
        return Inertia::render('PersebaranPT/persebaran-pt-show', [
            'persebaran' => $persebaranPtn
        ]);
    }

    public function edit(PersebaranPt $persebaranPtn)
    {
        $ptns = MasterPt::orderBy('nama_pt')->get();
        $siswas = MasterSiswa::orderBy('nama')->get();

        return Inertia::render('PersebaranPT/persebaran-pt-edit', [
            'persebaran' => $persebaranPtn,
            'ptns' => $ptns,
            'siswas' => $siswas
        ]);
    }

    public function update(Request $request, PersebaranPt $persebaranPtn)
    {
        $request->validate([
            'pt_id' => 'required|exists:master_pts,id',
            'siswa_id' => 'required|exists:master_siswas,id',
            'fakultas' => 'nullable|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'rumpun_ilmu' => 'nullable|in:Saintek,Soshum,Campuran',
            'program_studi' => 'nullable|string|max:255',
            'starta' => 'nullable|string|max:255',
            'akreditasi' => 'nullable|string|max:255',
            'jalur_masuk' => 'nullable|string|max:255',
        ]);

        $persebaranPtn->update($request->all());
        
        return redirect()->route('persebaran-ptn.index')->with('success', 'Data persebaran berhasil diupdate.');
    }

    public function destroy(PersebaranPt $persebaranPtn)
    {
        $persebaranPtn->delete();
        return redirect()->route('persebaran-ptn.index')->with('success', 'Data persebaran berhasil dihapus.');
    }
}
