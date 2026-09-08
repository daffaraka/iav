<?php

namespace App\Http\Controllers;

use App\Models\KategoriProgramKerja;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KategoriProgramKerjaController extends Controller
{
    public function index()
    {
        $kategori = KategoriProgramKerja::all();
        return Inertia::render('NewMigration/MasterData/MasterDataPage', [
            'kategori' => $kategori
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        KategoriProgramKerja::create($validated);

        return back();
    }

    public function update(Request $request, int $id)
    {
        $kategori = KategoriProgramKerja::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string'
        ]);

        $kategori->update($validated);

        return back();
    }

    public function destroy(int $id)
    {
        $kategori = KategoriProgramKerja::findOrFail($id);
        $kategori->delete();
        
        return back();
    }
}
