<?php

namespace App\Http\Controllers\AQR;

use App\Http\Controllers\Controller;
use App\Mail\TiketCreatedMail;
use App\Mail\TiketDisposisiMail;
use App\Mail\TiketNotifAdminMail;
use App\Mail\TiketResponMail;
use App\Models\ProgresTiket;
use App\Models\Tiket;
use App\Models\User;
use App\Notifications\TiketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $query = Tiket::with(['first_pic', 'pic', 'option'])->latest();

        if ($user->hasAnyRole(['super-admin', 'admin', 'humas'])) {
            $data['data'] = $query->get();
        } elseif ($user->hasAnyRole(['kepala-sekolah', 'kepala-tata-usaha', 'kepala-psikolog'])) {
            $kategoriPics = $this->getKategoriPicByRoles();
            $query->where('lokasi_sekolah', $unit);

            if (!empty($kategoriPics)) {
                $query->whereHas('option', function ($q) use ($kategoriPics) {
                    $q->whereIn('kategori_pic', $kategoriPics);
                });
            }
            $data['data'] = $query->get();
        } else {
            $query->where('pic_id', $user->id);
            $data['data'] = $query->get();
        }

        return \Inertia\Inertia::render('AQR/tiket-index', [
            'tikets' => $data['data'],
            'userRoles' => $user->getRoleNames()
        ]);
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
            'filename' => 'nullable|file|max:2048',
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

        // 1a. Email ke pengirim
        if ($tiket->email) {
            Mail::to($tiket->email)->queue(new TiketCreatedMail($tiket));
        }

        // 1b. Email ke admin_humas (gate 1) jika sudah di-assign
        if ($tiket->admin_humas_id) {
            $adminHumas = User::find($tiket->admin_humas_id);
            if ($adminHumas?->email) {
                Mail::to($adminHumas->email)->queue(new TiketNotifAdminMail($tiket));
                $adminHumas->notify(new TiketNotification($tiket, 'Tiket baru masuk: ' . $tiket->judul_kendala, 'new'));
            }
        } else {
            // Broadcast ke semua humas jika belum ada admin_humas
            User::role('humas')->each(function ($user) use ($tiket) {
                if ($user->email) {
                    Mail::to($user->email)->queue(new TiketNotifAdminMail($tiket));
                }
                $user->notify(new TiketNotification($tiket, 'Tiket baru masuk: ' . $tiket->judul_kendala, 'new'));
            });
        }

        return redirect()->route('dashboard.aqr.tiket.index')
            ->with('success', 'Tiket berhasil dibuat dengan nomor: ' . $tiket->no_tiket);
    }

    public function show($id)
    {
        $tiket = Tiket::with(['first_pic', 'pic', 'option', 'siswa', 'progres' => function ($query) {
            $query->latest();
        }])->findOrFail($id);

        $picSelect = User::select('id', 'name', 'unit', 'jabatan', 'departemen')->get();

        return \Inertia\Inertia::render('AQR/tiket-edit', [
            'tiket' => $tiket,
            'picSelect' => $picSelect,
            'userRoles' => Auth::user()->getRoleNames(),
            'currentUser' => Auth::user()
        ]);
    }

    public function edit($id)
    {
        $tiket = Tiket::with(['first_pic', 'pic', 'option', 'progres' => function ($query) {
            $query->latest();
        }])->find($id);

        $picSelect = User::select('id', 'name', 'unit', 'jabatan', 'departemen')->get();

        return \Inertia\Inertia::render('AQR/tiket-edit', [
            'tiket' => $tiket,
            'picSelect' => $picSelect,
            'userRoles' => Auth::user()->getRoleNames(),
            'currentUser' => Auth::user()
        ]);
    }

    public function update(Request $request, $id)
    {

        // Handle forward action
        if ($request->action == 'forward') {
            $validated = $request->validate([
                'forward_type' => 'required|in:kepala-sekolah,kepala-tu',
                'pic_id' => 'required|exists:users,id',
                'catatan' => 'nullable|string|max:500'
            ]);

            $tiket->update([
                'pic_id' => $validated['pic_id'],
                'status' => 'Proses'
            ]);

            ProgresTiket::create([
                'tiket_id' => $tiket->id,
                'penanganan' => 'Tiket diteruskan ke ' . ($validated['forward_type'] == 'kepala-sekolah' ? 'Kepala Sekolah' : 'Kepala TU') .
                               ($validated['catatan'] ? '. Catatan: ' . $validated['catatan'] : ''),
                'status' => 'Proses',
                'direspon_at' => now()
            ]);

            return redirect()->back()->with('success', 'Tiket berhasil diteruskan');
        }

        $tiket = Tiket::find($id);


        // dd($request->all());
        if (Auth::user()->hasAnyRole(['super-admin', 'admin', 'humas', 'tata-usaha', 'kepala-sekolah', 'kepala-tata-usaha', 'staff','guru','wali-kelas'])) {

            $oldPicId = $tiket->pic_id;

            if ($tiket->pengirim == 'Masyarakat Umum') {
                $tiket->update([
                    'status' => 'Proses',
                    'departemen' => $request->departemen,
                    'admin_humas_id' => Auth::user()->id,
                    'pic_id' => Auth::user()->id,
                ]);
            } else {
                if ($tiket->status == 'New' || $request->has('pic_menanggapi')) {
                    $tiket->update([
                        'status' => 'Proses',
                        'departemen' => $request->departemen,
                        'admin_humas_id' => Auth::user()->id,
                        'pic_id' => $request->pic_menanggapi,
                    ]);
                }
            }

            $tiket->refresh();

            // 1b. Email ke admin_humas jika baru di-assign
            if (!$tiket->wasRecentlyCreated && $tiket->admin_humas_id == Auth::user()->id) {
                $adminHumas = Auth::user();
                if ($adminHumas->email) {
                    Mail::to($adminHumas->email)->queue(new TiketNotifAdminMail($tiket));
                }
                $adminHumas->notify(new TiketNotification($tiket, 'Tiket ditugaskan ke Anda: ' . $tiket->judul_kendala, 'new'));
            }

            // 1c. Email ke pic jika pic berubah (disposisi)
            if ($tiket->pic_id && $tiket->pic_id != $oldPicId) {
                $pic = User::find($tiket->pic_id);
                if ($pic?->email) {
                    Mail::to($pic->email)->queue(new TiketDisposisiMail($tiket));
                }
                $pic?->notify(new TiketNotification($tiket, 'Tiket didisposisikan ke Anda: ' . $tiket->judul_kendala, 'disposisi'));
            }

            if ($request->filled('penanganan')) {
                if ($request->hasFile('fotopengerjaan')) {
                    $file = $request->file('fotopengerjaan');
                    $fileName = $file->getClientOriginalName();
                    $path = $file->move('tiket/' . now()->year . '/progres/', $fileName);
                }

                ProgresTiket::create([
                    'penanganan' => $request->penanganan,
                    'status' => 'Proses',
                    'fotopengerjaan' => $path ?? null,
                    'direspon_at' => date('Y-m-d H:i:s'),
                    'tiket_id' => $tiket->id,
                ]);

                // 1d. Email ke pelapor saat pic memberi respon
                if ($tiket->email) {
                    Mail::to($tiket->email)->queue(new TiketResponMail($tiket, $request->penanganan));
                }

                // Notifikasi ke admin_humas bahwa pic sudah merespon
                if ($tiket->admin_humas_id) {
                    $adminHumas = User::find($tiket->admin_humas_id);
                    $adminHumas?->notify(new TiketNotification($tiket, 'PIC telah memberikan respon pada tiket: ' . $tiket->no_tiket, 'respon'));
                }
            }

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

    public function forwardTicket(Request $request)
    {
        $validated = $request->validate([
            'tiket_id' => 'required|exists:tikets,id',
            'pic_id' => 'required|exists:users,id',
            'forward_type' => 'required|in:kepala-sekolah,kepala-tu',
            'catatan' => 'nullable|string|max:500'
        ]);

        $tiket = Tiket::findOrFail($validated['tiket_id']);

        // Update PIC
        $tiket->update([
            'pic_id' => $validated['pic_id'],
            'status' => 'Proses'
        ]);

        // Create progress entry
        ProgresTiket::create([
            'tiket_id' => $tiket->id,
            'penanganan' => 'Tiket diteruskan ke ' . ($validated['forward_type'] == 'kepala-sekolah' ? 'Kepala Sekolah' : 'Kepala TU') .
                           ($validated['catatan'] ? '. Catatan: ' . $validated['catatan'] : ''),
            'status' => 'Proses',
            'direspon_at' => now()
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil diteruskan');
    }

    public function proses($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->update([
            'status' => 'Proses',
            'waktu_proses' => now(),
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil diproses');
    }

    public function finish($id)
    {
        $tiket = Tiket::findOrFail($id);
        $tiket->update([
            'status' => 'Selesai',
            'waktu_close' => now(),
        ]);

        return redirect()->back()->with('success', 'Tiket berhasil diselesaikan');
    }

    public function rating(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'kepuasan' => 'nullable|string|max:1000',
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
            'kepala-sekolah' => 'Kepala Sekolah',
            'kepala-psikolog' => 'Psikolog',
        ];

        return collect($map)
            ->filter(fn($_, $role) => Auth::user()->hasRole($role))
            ->values()
            ->toArray();
    }
}
