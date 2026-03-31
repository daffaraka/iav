<?php

namespace App\Http\Controllers\AQR;

use App\Models\User;
use App\Models\Tiket;
use App\Models\ProgresTiket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TiketController extends Controller
{

    // public function index()
    // {

    //     $unit = Auth::user()->unit;
    //     $data['title'] = 'Manajemen Tiket AQR';
    //     $jenjang = Auth::user()->jenjang;
    //     $departemen = Auth::user()->departemen;
    //     $jabatan = Auth::user()->jabatan;
    //     // dd($unit);
    //     if (Auth::user()->hasAnyRole(['super-admin', 'humas'])) {
    //         $data['data'] = Tiket::with(['humas', 'pic', 'option'])->latest()->get();
    //     } else {

    //         // switch ($jabatan) {
    //         //     case 'Cinere':
    //         //         $unit = 'Cinere';
    //         //         break;
    //         //     case 'Jagakarsa':
    //         //         $unit = 'Jagakarsa';
    //         //         break;
    //         //     case 'Pamulang':
    //         //         $unit = 'Pamulang';
    //         //         break;
    //         //     default:
    //         //         $unit = null;
    //         //         break;
    //         // }

    //         if (Auth::user()->hasRole('kepala-tata-usaha')) {


    //             $data['data'] = Tiket::with(['humas', 'pic', 'option'])->where('lokasi_sekolah', $unit)
    //                 ->whereHas('option', function ($query) use ($unit) {
    //                     $query->where('kategori_pic', 'Kepala TU');
    //                 })->get();
    //         } else {


    //             $data['data'] = Tiket::with(['humas', 'pic', 'option'])->where('lokasi_sekolah', $unit)
    //                 ->whereHas('option', function ($query) {
    //                     $query->where('kategori_pic', 'Kepala Sekolah');
    //                 })->get();
    //         }
    //     }


    //     // dd($data['data']);


    //     // dd($data);

    //     return view('dashboard.aqr-dashboard.tiket.tiket-index', $data);
    // }


    public function index()
    {
        $user = Auth::user();
        $unit = $user->unit;

        $data['title'] = 'Manajemen Tiket AQR';

        if ($user->hasAnyRole(['super-admin', 'humas'])) {
            $data['data'] = Tiket::with(['first_pic', 'pic', 'option'])
                ->latest()
                ->get();

            return view('dashboard.aqr-dashboard.tiket.tiket-index', $data);
        }

        $kategoriPics = $this->getKategoriPicByRoles();

        $query = Tiket::with(['first_pic', 'pic', 'option'])
            ->where('lokasi_sekolah', $unit);

        if ($kategoriPics) {
            $query->whereHas('option', function ($q) use ($kategoriPics) {
                $q->whereIn('kategori_pic', $kategoriPics);
            });
        }

        $data['data'] = $query->get();



        // dd($data);

        return view('dashboard.aqr-dashboard.tiket.tiket-index', $data);
    }

    public function tiketDalamprogres()
    {
        $data['data'] = Tiket::with(['first_pic', 'pic'])->where('status', 'Proses')->latest()->paginate(15);
        return view('dashboard.aqr-dashboard.tiket.tiket-index', $data);
    }

    public function create()
    {
        return view('dashboard.aqr.tiket-create');
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

        $validated['no_tiket'] = 'AQR-' . date('Ymd') . '-' . \Illuminate\Support\Str::random(6);
        $validated['status'] = 'New';

        if ($request->hasFile('filename')) {
            $validated['filename'] = $request->file('filename')->store('tiket-files', 'public');
        }

        $tiket = Tiket::create($validated);

        if ($validated['pengirim'] === 'Warga Sekolah') {
            $tuAdmin = $tiket->getAutoAssignedTU();
            if ($tuAdmin) {
                $tiket->update(['pic_id' => $tuAdmin->id]);
            }
        }

        return redirect()->route('dashboard.aqr.tiket.index')
            ->with('success', 'Tiket berhasil dibuat dengan nomor: ' . $tiket->no_tiket);
    }

    public function show($id)
    {
        $tiket = Tiket::with(['first_pic', 'pic', 'siswa'])->findOrFail($id);
        return view('dashboard.aqr.tiket-show', compact('tiket'));
    }

    public function edit($id)
    {
        $tiket = Tiket::with(['first_pic', 'pic', 'option', 'progres' => function ($query) {
            $query->latest();
        }])->find($id);

        $picSelect = User::select('id', 'name', 'unit')->get();

        return view('dashboard.aqr-dashboard.tiket.tiket-edit', compact('tiket', 'picSelect'));
    }

    public function update(Request $request, $id)
    {



        $tiket = Tiket::find($id);

        // if($tiket->pengirim == 'Masyarakat Umum') {

        // };

        // dd(Auth::user()->hasAnyRole(['super-admin', 'admin', 'humas', 'tata-usaha', 'kepala-sekolah']));

        if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'humas', 'tata-usaha', 'kepala-sekolah','kepala-tata-usaha'])) {
            $tiket->update([
                'status' => 'Proses',
                'departemen' => $request->departemen,
                'admin_humas_id' => Auth::user()->id,
                'pic_id' => $request->pic_menanggapi
            ]);
            if ($request->has('fotopengerjaan')) {
                $file = $request->file('fotopengerjaan');
                $fileName = $file->getClientOriginalName();
                $path = $file->move('tiket/' . now()->year . '/progres/', $fileName);
            }

            $progressTiket = new ProgresTiket();

            $progressTiket->create([
                'penanganan' => $request->penanganan,
                'status' => 'Proses',
                'fotopengerjaan' => $path ?? null,
                'direspon_at' => date('Y-m-d H:i:s'),
                'tiket_id' => $tiket->id
            ]);
            return redirect()->back()
                ->with('success', 'Tiket berhasil diupdate');
        }

           return redirect()->back()
            ->with('error', 'Terdapat kesalahan');
    }

    public function destroy($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->delete();

        return redirect()->route('dashboard.aqr.tiket.index')
            ->with('success', 'Tiket berhasil dihapus');
    }

    public function deleteAll()
    {
        $count = Tiket::count();
        Tiket::truncate();

        return redirect()->route('dashboard.aqr.tiket.index')
            ->with('success', "Berhasil menghapus {$count} tiket");
    }

    public function proses($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->update([
            'status' => 'Proses',
            'waktu_proses' => now()
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil diproses');
    }

    public function finish($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->update([
            'status' => 'Selesai',
            'waktu_close' => now()
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil diselesaikan');
    }

    public function rating(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'deskripsi_penilaian' => 'nullable|string|max:1000'
        ]);

        $tiket = Tiket::findOrFail($id);

        if ($tiket->status !== 'Selesai') {
            return redirect()->back()->with('error', 'Hanya tiket selesai yang bisa diberi rating');
        }

        $tiket->update($validated);

        return redirect()->back()->with('success', 'Rating berhasil diberikan');
    }


    private function getKategoriPicByRoles()
    {
        $map = [
            'kepala-tata-usaha' => 'Kepala TU',
            'kepala-sekolah'    => 'Kepala Sekolah',
            'kepala-psikolog'   => 'Psikolog',
        ];

        return collect($map)
            ->filter(fn($_, $role) => Auth::user()->hasRole($role))
            ->values()
            ->toArray();
    }
}
