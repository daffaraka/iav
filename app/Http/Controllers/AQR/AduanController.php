<?php

namespace App\Http\Controllers\AQR;

use App\Http\Controllers\Controller;
use App\Mail\OpenTiketMail;
use App\Models\Tiket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AduanController extends Controller
{
    public function index()
    {
        $tikets = Tiket::with(['first_pic', 'pic'])->latest()->paginate(10);
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

        // Kirim email konfirmasi jika email diisi
        if (!empty($tiket->email)) {
            Mail::to($tiket->email)->send(new OpenTiketMail([
                'id'            => $tiket->id,
                'name'          => $tiket->nama,
                'no_tiket'      => $tiket->no_tiket,
                'tanggal'       => $tiket->created_at->format('d M Y H:i'),
                'lokasi_kendala'=> $tiket->lokasi_kendala,
                'detail_kendala'=> $tiket->detail_kendala,
            ]));
        }

        return redirect()->route('dashboard.aqr.aduan.index')
                        ->with('success', 'Tiket berhasil dibuat dengan nomor: ' . $tiket->no_tiket);
    }

    public function show(string $id)
    {
        $tiket = Tiket::with(['first_pic', 'pic', 'siswa'])->findOrFail($id);
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
