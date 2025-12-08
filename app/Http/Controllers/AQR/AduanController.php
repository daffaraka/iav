<?php

namespace App\Http\Controllers\AQR;

use App\Http\Controllers\Controller;
use App\Models\Tiket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AduanController extends Controller
{
    public function index()
    {
        $tikets = Tiket::with(['humas', 'pic'])->latest()->paginate(10);
        return view('dashboard.aqr.aduan-index', compact('tikets'));
    }

    public function create()
    {
        return view('dashboard.aqr.aduan-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'no_hp' => 'nullable|string|max:250',
            'email' => 'nullable|email|max:50',
            'judul_kendala' => 'required|string|max:255',
            'detail_kendala' => 'required|string',
            'lokasi_kendala' => 'nullable|string|max:250',
            'pengirim' => 'required|in:Masyarakat Umum,Warga Sekolah',
            'lokasi_sekolah' => 'required_if:pengirim,Warga Sekolah|in:Cinere,Jagakarsa,Pamulang',
            'filename' => 'nullable|file|max:2048'
        ]);

        $validated['no_tiket'] = 'AQR-' . date('Ymd') . '-' . Str::random(6);
        $validated['status'] = 'New';

        if ($request->hasFile('filename')) {
            $validated['filename'] = $request->file('filename')->store('tiket-files', 'public');
        }

        $tiket = Tiket::create($validated);

        // Auto assign TU Admin jika warga sekolah
        if ($validated['pengirim'] === 'Warga Sekolah') {
            $tuAdmin = $tiket->getAutoAssignedTU();
            if ($tuAdmin) {
                $tiket->update(['pic_id' => $tuAdmin->id]);
            }
        }

        return redirect()->route('dashboard.aqr.aduan.index')
                        ->with('success', 'Tiket berhasil dibuat dengan nomor: ' . $tiket->no_tiket);
    }

    public function show(string $id)
    {
        $tiket = Tiket::with(['humas', 'pic', 'siswa'])->findOrFail($id);
        return view('dashboard.aqr.aduan-show', compact('tiket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
