<?php

namespace App\Http\Controllers;

use App\Models\AqrOption;
use Illuminate\Http\Request;

class AqrOptionController extends Controller
{
    public function index()
    {
        $aqrOptions = AqrOption::orderBy('nama_option', 'asc')->get();
        return view('dashboard.aqr-option.aqro-index', compact('aqrOptions'));
    }

    public function create()
    {
        return view('dashboard.aqr-option.aqro-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_option' => 'required|string|max:255',
            'kategori_pic' => 'required'
        ]);

        AqrOption::create($request->all());

        return redirect()->route('aqr-option.index')->with('success', 'AQR Option berhasil ditambahkan');
    }

    public function edit(AqrOption $aqrOption)
    {
        return view('dashboard.aqr-option.aqro-edit', compact('aqrOption'));
    }

    public function update(Request $request, AqrOption $aqrOption)
    {
        $request->validate([
            'nama_option' => 'required|string|max:255',
            'kategori_pic' => 'required'
        ]);

        $aqrOption->update($request->all());

        return redirect()->route('aqr-option.index')->with('success', 'AQR Option berhasil diupdate');
    }

    public function destroy(AqrOption $aqrOption)
    {
        $aqrOption->delete();
        return redirect()->route('aqr-option.index')->with('success', 'AQR Option berhasil dihapus');
    }
}
