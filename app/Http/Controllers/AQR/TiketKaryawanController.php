<?php

namespace App\Http\Controllers\AQR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\TiketKaryawan;
use Illuminate\Support\Facades\Auth;

class TiketKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = TiketKaryawan::with(['user', 'admin', 'pic'])->orderBy('created_at', 'desc');

        // Jika dia bukan admin yg bisa monitor semua tiket, maka hanya lihat miliknya atau yang ditugaskan ke dia
        if (!$user->can('monitor-all-tiket-karyawan')) {
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('pic_id', $user->id)
                  ->orWhere('admin_id', $user->id);
            });
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('no_tiket', 'like', '%' . $request->search . '%')
                  ->orWhere('judul_kendala', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $tikets = $query->paginate(10)->withQueryString();

        return Inertia::render('AQRKaryawan/AQRKaryawanIndex', [
            'tikets' => $tikets,
            'filters' => $request->only(['search', 'status']),
            'can' => [
                'create' => $user->can('create-tiket-karyawan'),
                'monitor_all' => $user->can('monitor-all-tiket-karyawan')
            ]
        ]);
    }

    public function create()
    {
        $user = Auth::user();
        
        return Inertia::render('AQRKaryawan/AQRKaryawanCreate', [
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_kendala' => 'required|string|max:255',
            'departemen' => 'required|string|max:50',
            'masalah_dept' => 'required|string',
            'lokasi_kendala' => 'required|string|max:250',
            'detail_kendala' => 'required|string'
        ]);

        $tiket = new TiketKaryawan();
        $tiket->user_id = Auth::id();
        $tiket->judul_kendala = $validated['judul_kendala'];
        $tiket->departemen = $validated['departemen'];
        $tiket->masalah_dept = $validated['masalah_dept'];
        $tiket->lokasi_kendala = $validated['lokasi_kendala'];
        $tiket->detail_kendala = $validated['detail_kendala'];
        $tiket->status = 'New';
        
        if ($request->hasFile('filename')) {
            $path = $request->file('filename')->store('tiket_karyawan', 'public');
            $tiket->filename = $path;
        }

        $tiket->save();

        return redirect()->route('tiket-karyawan.index')->with('success', 'Tiket berhasil dibuat.');
    }

    public function show(TiketKaryawan $tiketKaryawan)
    {
        $user = Auth::user();
        
        // Cek akses
        if (!$user->can('monitor-all-tiket-karyawan') && 
            $tiketKaryawan->user_id !== $user->id && 
            $tiketKaryawan->pic_id !== $user->id && 
            $tiketKaryawan->admin_id !== $user->id) {
            abort(403);
        }

        $tiketKaryawan->load(['user', 'admin', 'pic', 'progres.user']);

        // Mengambil daftar PIC/Users untuk ditugaskan
        $pics = \App\Models\User::whereHas('roles', function($q) {
            $q->whereIn('name', ['tata-usaha', 'staff', 'super-admin', 'guru']);
        })->get(['id', 'name', 'unit', 'employee_code']);

        return Inertia::render('AQRKaryawan/AQRKaryawanShow', [
            'tiket' => $tiketKaryawan,
            'pics' => $pics,
            'can' => [
                'finish' => $user->can('tiket-karyawan-finish'),
                'monitor_all' => $user->can('monitor-all-tiket-karyawan')
            ]
        ]);
    }

    public function update(Request $request, TiketKaryawan $tiketKaryawan)
    {
        $user = Auth::user();

        // Update status or assignment
        if ($request->has('status')) {
            $tiketKaryawan->status = $request->status;
            
            if ($request->status === 'Proses' && !$tiketKaryawan->waktu_proses) {
                $tiketKaryawan->waktu_proses = now();
            }
            if ($request->status === 'Selesai' && !$tiketKaryawan->waktu_close) {
                $tiketKaryawan->waktu_close = now();
            }
        }

        if ($request->has('pic_id') && $user->can('monitor-all-tiket-karyawan')) {
            $tiketKaryawan->pic_id = $request->pic_id;
            if (!$tiketKaryawan->admin_id) {
                $tiketKaryawan->admin_id = $user->id;
            }
            if ($tiketKaryawan->status === 'New') {
                $tiketKaryawan->status = 'Proses';
                $tiketKaryawan->waktu_proses = now();
            }
        }

        $tiketKaryawan->save();

        return redirect()->back()->with('success', 'Tiket diperbarui.');
    }

    public function destroy(TiketKaryawan $tiketKaryawan)
    {
        if (Auth::id() !== $tiketKaryawan->user_id && !Auth::user()->can('delete-tiket-karyawan')) {
            abort(403);
        }
        $tiketKaryawan->delete();
        return redirect()->route('tiket-karyawan.index')->with('success', 'Tiket dihapus.');
    }
}
