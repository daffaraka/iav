<?php

namespace App\Http\Controllers;

use App\Models\AqrOption;
use App\Models\Tiket;
use App\Models\TopikPermasalahan;
use Illuminate\Http\Request;

class TopikPermasalahanController extends Controller
{
    public function index()
    {
        $data = TopikPermasalahan::with(['aqrOption', 'tiket'])->latest()->get();
        return view('dashboard.topik-permasalahan.topik-index', compact('data'));
    }

    public function create()
    {
        $options = AqrOption::orderBy('nama_option')->get();
        $tikets  = Tiket::orderBy('no_tiket')->get();
        return view('dashboard.topik-permasalahan.topik-create', compact('options', 'tikets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_topik'    => 'required|string|max:255',
            'aqr_option_id' => 'required|exists:aqr_options,id',
            'tiket_id'      => 'required|exists:tikets,id',
        ]);

        TopikPermasalahan::create($request->only('nama_topik', 'aqr_option_id', 'tiket_id'));

        return redirect()->route('topik-permasalahan.index')->with('success', 'Topik permasalahan berhasil ditambahkan');
    }

    public function edit(TopikPermasalahan $topikPermasalahan)
    {
        $options = AqrOption::orderBy('nama_option')->get();
        $tikets  = Tiket::orderBy('no_tiket')->get();
        return view('dashboard.topik-permasalahan.topik-edit', compact('topikPermasalahan', 'options', 'tikets'));
    }

    public function update(Request $request, TopikPermasalahan $topikPermasalahan)
    {
        $request->validate([
            'nama_topik'    => 'required|string|max:255',
            'aqr_option_id' => 'required|exists:aqr_options,id',
            'tiket_id'      => 'required|exists:tikets,id',
        ]);

        $topikPermasalahan->update($request->only('nama_topik', 'aqr_option_id', 'tiket_id'));

        return redirect()->route('topik-permasalahan.index')->with('success', 'Topik permasalahan berhasil diupdate');
    }

    public function destroy(TopikPermasalahan $topikPermasalahan)
    {
        $topikPermasalahan->delete();
        return redirect()->route('topik-permasalahan.index')->with('success', 'Topik permasalahan berhasil dihapus');
    }
}
