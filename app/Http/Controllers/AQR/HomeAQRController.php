<?php

namespace App\Http\Controllers\AQR;

use App\Models\Tiket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterSiswa as Siswa;
use Illuminate\Support\Facades\Mail;
use App\Mail\OpenTiketMail;

class HomeAQRController extends Controller
{


    public function create(Request $request)
    {
        $pengirim = $request->get('pengirim');

        if ($pengirim === 'Masyarakat Umum') {
            return view('frontend.aqr.open-tiket-umum-new', compact('pengirim'));
        } else {
            return view('frontend.aqr.open-tiket-warga-new', compact('pengirim'));
        }
    }

    public function cekPengirim()
    {
        return view('frontend.aqr.cek-pengirim-new');
    }


    public function storeTiket(Request $request)
    {
        // Validasi untuk warga sekolah
        if ($request->pengirim === 'Warga Sekolah') {
            $siswa = Siswa::where('nisn', $request->nisn)->first();
            if (!$siswa) {
                return back()->withErrors(['nisn' => 'NISN tidak ditemukan dalam database siswa']);
            }
        }


        // dd($request->all());

        if ($request->hasFile('choosefile')) {
            $file = $request->file('choosefile');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->move('tiket/' . date('Y') . '/', $fileName);
        }

        $noTiket = rand(100000, 999999);
        if (Tiket::where('no_tiket', $noTiket)->exists()) {
            $noTiket = rand(100000, 999999);
        }

        $siswaId = null;
        if ($request->pengirim === 'Warga Sekolah' && $request->nisn) {
            $siswa = Siswa::where('nisn', $request->nisn)->first();
            $siswaId = $siswa ? $siswa->id : null;
        }


        // dd($siswaId);

        $tiket = Tiket::create([
            'no_tiket' => $noTiket,
            'nisn' => $request->nisn,
            'siswa_id' => $siswaId,
            'no_hp' => $request->no_hp,
            'nama' => $request->nama,
            'nama_orangtua' => $request->nama_orangtua,
            'email' => $request->email,
            'judul_kendala' => $request->judul_kendala,

            'lokasi_kendala' => $request->pengirim === 'Warga Sekolah' ? $request->lokasi_kendala : null,
            'detail_kendala' => $request->detail_kendala,
            'status' => 'New',
            'pengirim' => $request->pengirim,
            'filename' => $path ?? '',
        ]);


        $data = [
            'id' => $tiket->no_tiket,
            'title' => 'Open Tiket ID ' . $tiket->id,
            'name' => $request->nama,
            'no_tiket' => $tiket->no_tiket,
            'tanggal' => $tiket->created_at->isoFormat('D MMMM YYYY, HH:mm:ss'),
            'judul_kendala' => $request->judul_kendala,

            'lokasi_kendala' => $request->lokasi_kendala,
            'detail_kendala' => $request->detail_kendala,
            'body' => 'Testing Kirim Email di AQR'

        ];


        Mail::to('daffarakals@gmail.com')->send(new OpenTiketMail($data));



        return redirect()->route('helpdesk.home.tiket-show', ['tiket' => $tiket->no_tiket]);
    }


    public function tracking()
    {
        return view('frontend.aqr.tracking-tiket-new');
    }

    public function pencarianTiket(Request $request)
    {
        $noTiket = $request->no_tiket ?? $request->no_tiket;
        $email = $request->email ?? $request->email;
        $tiket = Tiket::with('humas', 'pic', 'progres')
            ->where('no_tiket', $noTiket)
            ->first();


        // dd($tiket);

        if ($tiket == null) {
            return redirect()->route('frontend.aqr.tiket-tracking')->with('error', 'Tiket Tidak Ditemukan. Pastikan nomor tiket dan email anda benar');
        } else {
            return redirect()->route('frontend.aqr.tiket-show', ['tiket' => $tiket->no_tiket]);
        }
    }

    public function show($tiket)
    {
        $tiket = Tiket::with('humas', 'pic', 'progres')
            ->where('no_tiket', $tiket)
            ->first();
        // dd($tiket);
        return view('frontend.aqr.detail-tracking-tiket-new', compact('tiket'));
    }


    public function storeKepuasan($id, Request $request)
    {

        // dd($request->all());
        $tiket = Tiket::find($id);
        // $tiket->kepuasan = $request->kepuasan;
        $tiket->rating = $request->rating;
        $tiket->deskripsi_penilaian = $request->deskripsi_penilaian;
        $tiket->status = 'Selesai';
        $tiket->save();
        return redirect()->back()->with('success', 'Anda telah mengisikan kepuasan');
    }

    public function getSiswaByNisn(Request $request)
    {
        $siswa = Siswa::where('nisn', $request->nisn)->first();
        if ($siswa) {
            return response()->json([
                'success' => true,
                'data' => $siswa
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'NISN tidak ditemukan'
        ]);
    }
}
