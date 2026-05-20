<?php

namespace App\Http\Controllers\AQR;

use App\Models\User;
use App\Models\Tiket;
use App\Mail\OpenTiketMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AqrOption;
use App\Models\FeaturedQuestion;
use App\Models\FqInteraction;
use App\Models\FqVote;
use App\Models\MasterSiswa as Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeAQRController extends Controller
{


    public function create(Request $request)
    {

        if ($request->get('pengirim') == null) {
            return redirect()->route('helpdesk.home.cek-pengirim');
        }
        $pengirim = $request->get('pengirim');

        if ($pengirim === 'Masyarakat Umum') {
            return view('frontend.aqr.open-tiket-umum-new', compact('pengirim'));
        } else {
            $options = AqrOption::orderBy('nama_option', 'asc')->get();



            return view('frontend.aqr.open-tiket-warga-new', compact(['pengirim', 'options']));
        }
    }

    public function cekPengirim()
    {
        $featuredQuestions = FeaturedQuestion::published()
            ->orderBy('is_pinned', 'desc')
            ->orderBy('vote_count', 'desc')
            ->orderBy('order')
            ->take(10)
            ->get();
        return view('frontend.aqr.cek-pengirim-new', compact('featuredQuestions'));
    }


    public function storeTiket(Request $request)
    {

        // dd($request->all());

        $option = AqrOption::where('id', $request->kendala)->first();

        $request->validate([
            'pengirim' => 'required',
            'nama' => 'required_if:pengirim,Masyarakat Umum',
            'no_hp' => 'required_if:pengirim,Masyarakat Umum',
            'lokasi_kendala' => 'required_if:pengirim,Masyarakat Umum',
            // 'choosefile' => 'required_if:pengirim,Masyarakat Umum',
            'nisn' => 'required_if:pengirim,Warga Sekolah',
            'nama' => 'required_if:pengirim,Warga Sekolah',
            'no_hp' => 'required_if:pengirim,Warga Sekolah',
            'lokasi_kendala' => 'required_if:pengirim,Warga Sekolah',
        ], [
            'nama.required_if' => 'Nama harus diisi jika pengirim adalah Masyarakat Umum',
            'no_hp.required_if' => 'Nomor HP harus diisi jika pengirim adalah Masyarakat Umum',
            'lokasi_kendala.required_if' => 'Lokasi kendala harus diisi jika pengirim adalah Masyarakat Umum',
            'choosefile.required_if' => 'Bukti kendala harus diisi jika pengirim adalah Masyarakat Umum',
            'nisn.required_if' => 'NISN harus diisi jika pengirim adalah Warga Sekolah',
            'nama.required_if' => 'Nama harus diisi jika pengirim adalah Warga Sekolah',
            'no_hp.required_if' => 'Nomor HP harus diisi jika pengirim adalah Warga Sekolah',
            'lokasi_kendala.required_if' => 'Lokasi kendala harus diisi jika pengirim adalah Warga Sekolah',
        ]);

        // Validasi untuk warga sekolah
        if ($request->pengirim === 'Warga Sekolah') {
            $siswa = Siswa::where('nisn', $request->nisn)->first();
            if (!$siswa) {
                return back()->withErrors(['nisn' => 'NISN tidak ditemukan dalam database siswa']);
            }
        }

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

        $adminUnit = null;
        if ($request->pengirim === 'Warga Sekolah') {

            if ($option->kategori_pic == 'Psikolog') {
                $lokasiParts = explode(' ', $request->lokasi_kendala);
                $jenjang = $lokasiParts[0]; // KB, SD, SMA
                $unit = end($lokasiParts); // Pamulang, Cinere, Jagakar
                $psikologQuery = User::where('unit', $unit)
                    ->where('jenjang', $jenjang)
                    ->whereHas('roles', function ($q) {
                        $q->where('name', 'psikolog');
                    });
                
                $psikologCount = $psikologQuery->count();
                
                if ($psikologCount > 1) {
                    $adminUnit = $psikologQuery->whereHas('roles', function ($q) {
                        $q->where('name', 'kepala-psikolog');
                    })->first();
                } else {
                    $adminUnit = $psikologQuery->first();
                }
            } else {
                $lokasiParts = explode(' ', $request->lokasi_kendala);
                $jenjang = $lokasiParts[0]; // KB, SD, SMA
                $unit = end($lokasiParts); // Pamulang, Cinere, Jagakarsa
                $adminUnit = User::where('unit', $unit)->where('jenjang', $jenjang)->where('jabatan', $option->kategori_pic)->first();
            }
        }


        // dd($adminUnit);




        try {
            $tiket = Tiket::create([
                'no_tiket' => $noTiket,
                'nisn' => $request->nisn,
                'siswa_id' => $siswaId,
                'no_hp' => $request->no_hp,
                'nama' => $request->nama,
                'nama_orangtua' => $request->nama_orangtua,
                'email' => $request->email,
                'judul_kendala' => $request->judul_kendala,
                'jenjang' => $request->pengirim === 'Warga Sekolah' ? explode(' ', $request->lokasi_kendala)[0] : null,
                'lokasi_kendala' => $request->pengirim === 'Warga Sekolah' ? $request->lokasi_kendala : null,
                'detail_kendala' => $request->detail_kendala,
                'lokasi_sekolah' => $unit ?? '',
                'status' => 'New',
                'pengirim' => $request->pengirim,
                'filename' => $path ?? '',
                'admin_humas_id' => $adminUnit ? $adminUnit->id : null,
                'masalah_dept' => $option->nama_option ?? null,
                'option_id' => $option->id ?? null
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


            // Mail::to('daffarakals@gmail.com')->send(new OpenTiketMail($data));

            if (!empty($request->email)) {
                Mail::to($request->email)->send(new OpenTiketMail($data));
            }



            return redirect()->route('helpdesk.home.tiket-show', ['tiket' => $tiket->no_tiket]);
        } catch (\Throwable $th) {

            // return dd(json_encode($th->getMessage()));
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function tracking()
    {
        return view('frontend.aqr.tracking-tiket-new');
    }

    public function pencarianTiket(Request $request)
    {
        $noTiket = $request->no_tiket ?? $request->no_tiket;
        $email = $request->email ?? $request->email;
        $tiket = Tiket::with('first_pic', 'pic', 'progres')
            ->where('no_tiket', $noTiket)
            ->first();


        // dd($tiket);

        if ($tiket == null) {
            return redirect()->route('helpdesk.home.tiket-tracking')->with('error', 'Tiket Tidak Ditemukan. Pastikan nomor tiket dan email anda benar');
        } else {
            return redirect()->route('helpdesk.home.tiket-show', ['tiket' => $tiket->no_tiket]);
        }
    }

    public function show($tiket)
    {
        $tiket = Tiket::with('first_pic', 'pic', 'progres', 'option')
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

    public function trackFaqInteraction(Request $request)
    {
        $request->validate([
            'fq_id' => 'required|exists:featured_questions,id',
            'visitor_id' => 'required|string|max:36',
        ]);

        $exists = FqInteraction::where('featured_question_id', $request->fq_id)
            ->where('visitor_id', $request->visitor_id)
            ->exists();

        if ($exists) {
            return response()->json(['already_tracked' => true]);
        }

        FqInteraction::create([
            'featured_question_id' => $request->fq_id,
            'visitor_id' => $request->visitor_id,
            'ip_address' => $request->ip(),
            'clicked_at' => now(),
        ]);

        $fq = FeaturedQuestion::find($request->fq_id);
        $fq->increment('view_count');

        return response()->json(['tracked' => true, 'new_count' => $fq->view_count]);
    }

    public function toggleFaqVote(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'fq_id' => 'required|exists:featured_questions,id',
        ]);

        $vote = FqVote::where('featured_question_id', $request->fq_id)
            ->where('user_id', Auth::id())
            ->first();

        $fq = FeaturedQuestion::find($request->fq_id);

        if ($vote) {
            $vote->delete();
            $fq->decrement('vote_count');
            return response()->json(['voted' => false, 'new_count' => $fq->vote_count]);
        }

        FqVote::create([
            'featured_question_id' => $request->fq_id,
            'user_id' => Auth::id(),
        ]);
        $fq->increment('vote_count');

        return response()->json(['voted' => true, 'new_count' => $fq->vote_count]);
    }
}
