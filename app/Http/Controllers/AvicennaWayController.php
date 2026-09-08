<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvicennaWayController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->query('date', now()->format('Y-m-d'));
        $departemen = $request->query('departemen', 'Semua Departemen');
        
        // Mengambil daftar departemen langsung dari tabel User agar datanya sinkron
        $allDepartemen = \App\Models\User::select('departemen')->whereNotNull('departemen')->where('departemen', '!=', '')->distinct()->pluck('departemen');

        if ($departemen === 'Semua Departemen') {
            $departmentUsers = \App\Models\User::all();
            $activities = \App\Models\AwActivity::with('user')
                ->where('date', $date)
                ->get();
        } else {
            // Fetch users in the same department
            $departmentUsers = \App\Models\User::where('departemen', $departemen)->get();
            
            // Fetch existing activities for this date
            $activities = \App\Models\AwActivity::with('user')
                ->whereHas('user', function($q) use ($departemen) {
                    $q->where('departemen', $departemen);
                })
                ->where('date', $date)
                ->get();
        }
            
        return \Inertia\Inertia::render('AvicennaWay/Index', [
            'date' => $date,
            'departmentUsers' => $departmentUsers,
            'activities' => $activities,
            'departemen' => $departemen,
            'allDepartemen' => $allDepartemen
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'activities' => 'required|array',
            'activities.*.user_id' => 'required|exists:users,id',
            'activities.*.is_facilitator' => 'boolean',
            'activities.*.is_culture_champion' => 'boolean',
            'activities.*.yesterday_activity' => 'nullable|string',
            'activities.*.aw_value' => 'nullable|array',
            'activities.*.habits' => 'nullable|array',
            'activities.*.is_favorite' => 'boolean',
        ]);

        foreach ($data['activities'] as $activityData) {
            \App\Models\AwActivity::updateOrCreate(
                [
                    'date' => $data['date'],
                    'user_id' => $activityData['user_id']
                ],
                [
                    'is_facilitator' => $activityData['is_facilitator'] ?? false,
                    'is_culture_champion' => $activityData['is_culture_champion'] ?? false,
                    'yesterday_activity' => $activityData['yesterday_activity'] ?? null,
                    'aw_value' => $activityData['aw_value'] ?? null,
                    'habits' => $activityData['habits'] ?? null,
                    'is_favorite' => $activityData['is_favorite'] ?? false,
                ]
            );
        }

        return redirect()->back()->with('success', 'Data Avicenna Way berhasil disimpan.');
    }
}
