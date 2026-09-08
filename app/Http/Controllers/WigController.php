<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Sekolah;
use App\Models\User;
use App\Models\Wig;
use App\Models\WigHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class WigController extends Controller
{
    public function index()
    {
        $wigsQuery = Wig::withCount('lead_measures')
            ->with(['deptartement', 'user', 'wig_progresses']);

        $wigs = $wigsQuery->paginate(10);

        $allWigs = Wig::with('wig_progresses')->get();
        $totalWigs = $allWigs->count();
        $activeWigs = $allWigs->where('status_wig', 1)->count();

        // Calculate overall average progress
        $totalProgress = 0;
        foreach ($allWigs as $w) {
            $totalProgress += (float) $w->wig_progresses->sum('progress_wig');
        }
        $averageProgress = $totalWigs > 0 ? round($totalProgress / $totalWigs, 2) : 0;

        return Inertia::render('Wig/WigIndex', [
            'wigs' => $wigs,
            'totalWigs' => $totalWigs,
            'activeWigs' => $activeWigs,
            'averageProgress' => $averageProgress
        ]);
    }

    public function create()
    {
        $departements = Departement::all();
        $users = User::all();

        return Inertia::render('Wig/WigCreate', [
            'departements' => $departements,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_wig' => 'required|unique:wigs,judul_wig',
            'deskripsi_wig' => 'required',
            'tanggal_mulai_wig' => 'required|date',
            'tanggal_berakhir_wig' => 'required|date',
            'departement_id' => 'required|exists:departements,id',
            // 'bobot_kpi' => 'numeric|min:0'
        ]);

        $validated['user_id'] = Auth::id();
        $validated['unit_wig'] = '%';
        $validated['from_x'] = 0;
        $validated['to_y'] = 100;

        Wig::create($validated);

        return redirect()->route('wig.index');
    }

    public function historyIndex(\Illuminate\Http\Request $request, Wig $wig)
    {
        $query = $wig->wig_histories()->with('user')->orderBy('tanggal', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('riwayat_wig', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $histories = $query->paginate(10)->withQueryString();

        return Inertia::render('Wig/WigHistoriesAll', [
            'wig' => $wig,
            'histories' => $histories,
            'filters' => $request->only('search')
        ]);
    }

    public function storeHistory(\Illuminate\Http\Request $request, Wig $wig)
    {
        $request->validate([
            'riwayat_wig' => 'required|string',
            'realisasi' => 'required|numeric',
            'tanggal' => 'required|date',
            'lampiran' => 'nullable|file|max:5120'
        ]);

        $data = $request->only(['riwayat_wig', 'realisasi', 'tanggal']);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('lampiran_wig', 'public');
        }

        $wig->wig_histories()->create($data);

        return redirect()->back()->with('success', 'Riwayat berhasil ditambahkan.');
    }

    public function show(Wig $wig)
    {
        $wig->load([
            'lead_measures',
            'deptartement',
            'user',
            'wig_progresses'
        ]);

        $score = (float) $wig->wig_histories()->sum('realisasi');

        $progressTerbaru = $wig->wig_histories()
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $tasks = \Illuminate\Support\Facades\DB::table('task_processes')
            ->select(
                'lead_measure_id',
                \Illuminate\Support\Facades\DB::raw("DATE_FORMAT(tanggal_realisasi, '%M') as bulan"),
                'nama_tugas',
                'deskripsi',
                'jumlah_realisasi',
                'dokumen',
                'tanggal_realisasi',
                'status_tugas'
            )
            ->whereIn('lead_measure_id', $wig->lead_measures->pluck('id'))
            ->orderBy(\Illuminate\Support\Facades\DB::raw("MONTH(tanggal_realisasi)"))
            ->get()
            ->groupBy(['lead_measure_id', 'bulan']);

        $histories = $wig->wig_histories()->orderBy('tanggal')->get();
        $monthlySums = [];
        foreach ($histories as $h) {
            $month = (int) \Carbon\Carbon::parse($h->tanggal)->format('n');
            if (!isset($monthlySums[$month])) $monthlySums[$month] = 0;
            $monthlySums[$month] += (float) $h->realisasi;
        }

        $chartWig = [];
        $runningTotal = 0;
        $maxMonth = !empty($monthlySums) ? max(array_keys($monthlySums)) : (int) date('n');

        for ($m = 1; $m <= $maxMonth; $m++) {
            $sumThisMonth = $monthlySums[$m] ?? 0;
            $runningTotal += $sumThisMonth;
            $chartWig[] = [
                'bulan' => \Illuminate\Support\Carbon::create()->month($m)->locale('id')->translatedFormat('F'),
                'progress' => (float) $runningTotal,
                'realisasi_bulanan' => (float) $sumThisMonth,
            ];
        }

        return Inertia::render('Wig/WigShow', [
            'wig' => $wig,
            'boards' => $wig->lead_measures,
            'score' => $score,
            'data_lm' => $tasks,
            'progressTerbaru' => $progressTerbaru,
            'chartWig' => $chartWig,
            'departement' => $wig->deptartement
        ]);
    }

    public function edit(Wig $wig)
    {
        $departements = Departement::all();
        $users = User::all();

        return Inertia::render('Wig/WigEdit', [
            'wig' => $wig,
            'departements' => $departements,
            'users' => $users
        ]);
    }

    public function update(Request $request, Wig $wig)
    {
        $validated = $request->validate([
            'judul_wig' => 'required|unique:wigs,judul_wig,' . $wig->id,
            'deskripsi_wig' => 'required',
            'tanggal_mulai_wig' => 'required|date',
            'tanggal_berakhir_wig' => 'required|date',
            'departement_id' => 'required|exists:departements,id',
        ]);

        $wig->update($validated);

        return redirect()->route('wig.index')->with('success', 'WIG berhasil diupdate');
    }

    public function destroy(Wig $wig)
    {
        $wig->delete();
        return redirect()->route('wig.index')->with('success', 'WIG berhasil dihapus');
    }

    public function storeByDept(Request $request)
    {
        // Keep this method as it might be used by DepartementController
        $request->validate([
            'nama_wig' => 'required|string|max:255',
            'deskripsi_wig' => 'required|string',
            'tanggal_mulai_wig' => 'required|date',
            'tanggal_berakhir_wig' => 'required|date|after:tanggal_mulai_wig',
            'from_x' => 'required|numeric',
            'to_y' => 'required|numeric',
            'satuan' => 'required|in:%,Angka'
        ]);

        try {
            $wig = Wig::create([
                'judul_wig' => $request->nama_wig,
                'deskripsi_wig' => $request->deskripsi_wig,
                'tanggal_mulai_wig' => $request->tanggal_mulai_wig,
                'tanggal_berakhir_wig' => $request->tanggal_berakhir_wig,
                'from_x' => $request->from_x,
                'to_y' => $request->to_y,
                'unit_wig' => $request->satuan,
                'status_wig' => 1,
                'departement_id' => $request->departement_id,
                'user_id' => Auth::id() ?? 1
            ]);
            return response()->json(['status' => 'success', 'data' => $wig], 201);
        } catch (Exception $e) {
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function editByDept(Departement $departement, Wig $wig)
    {
        return Inertia::render('Wig/WigEdit', [
            'wig' => $wig,
            'dept' => $departement
        ]);
    }

    public function wigChart($id)
    {
        $wig = Wig::findOrFail($id);
        $histories = $wig->wig_histories()->orderBy('tanggal')->get();
        $monthlySums = [];
        foreach ($histories as $h) {
            $month = (int) \Carbon\Carbon::parse($h->tanggal)->format('n');
            if (!isset($monthlySums[$month])) $monthlySums[$month] = 0;
            $monthlySums[$month] += (float) $h->realisasi;
        }

        $chartWig = [];
        $runningTotal = 0;
        $maxMonth = !empty($monthlySums) ? max(array_keys($monthlySums)) : (int) date('n');

        for ($m = 1; $m <= $maxMonth; $m++) {
            $sumThisMonth = $monthlySums[$m] ?? 0;
            $runningTotal += $sumThisMonth;
            $chartWig[] = [
                'bulan' => \Illuminate\Support\Carbon::create()->month($m)->locale('id')->translatedFormat('F'),
                'progress' => (float) $runningTotal,
                'realisasi_bulanan' => (float) $sumThisMonth,
            ];
        }

        return response()->json(['chartWig' => $chartWig]);
    }


    public function showHistory(Wig $wig, WigHistory $history)
    {
        abort_if($history->wig_id !== $wig->id, 404);

        return Inertia::render('WigHistories/WigHistoriesShow', [
            'wig' => $wig,
            'history' => $history->load('user'),
        ]);
    }

    public function updateHistory(Request $request, Wig $wig, WigHistory $history)
    {
        abort_if($history->wig_id !== $wig->id, 404);

        $request->validate([
            'riwayat_wig' => 'required|string',
            'realisasi' => 'required|numeric',
            'tanggal' => 'required|date',
            'lampiran' => 'nullable|file|max:5120'
        ]);

        $data = $request->only(['riwayat_wig', 'realisasi', 'tanggal']);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')->store('lampiran_wig', 'public');
        }

        $history->update($data);

        return redirect()->back()->with('success', 'Riwayat berhasil diperbarui');
    }

    public function destroyHistory(Wig $wig, WigHistory $history)
    {
        abort_if($history->wig_id !== $wig->id, 404);
        $history->delete();
        return redirect()->back()->with('success', 'Riwayat berhasil dihapus');
    }
}
