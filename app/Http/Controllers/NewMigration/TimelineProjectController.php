<?php

namespace App\Http\Controllers\NewMigration;

use App\Http\Controllers\Controller;
use App\Models\Departement;
use App\Models\KategoriProgramKerja;
use App\Models\NewMigration\ProgramKerja;
use App\Models\NewMigration\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TimelineProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['boards.tasks', 'boards.pic', 'departement', 'pic'])->get();
        $programKerjas = ProgramKerja::with(['boards.tasks', 'boards.pic', 'departement', 'pic', 'kategori'])->get();
        $departements = Departement::all();
        $kategoriPrograms = KategoriProgramKerja::all();

        return Inertia::render('NewMigration/TimelineProject/TimelineProjectIndex', [
            'projects' => $projects,
            'programKerjas' => $programKerjas,
            'departements' => $departements,
            'kategoriPrograms' => $kategoriPrograms
        ]);
    }

    public function create()
    {
        $departements = Departement::all();
        $users = User::all();

        return Inertia::render('NewMigration/Wig/WigCreate', [
            'departements' => $departements,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Target Date format handling (if needed by frontend calendar)
        $date = $request->target_date ? Carbon::parse($request->target_date)->format('Y-m-d') : null;
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->format('Y-m-d') : null;

        // Determine if it's WIG or Program Kerja (you can pass 'type' from frontend)
        $type = $request->get('type', 'wig');

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $startDate,
            'target_date' => $date,
            'departement_id' => $request->filled('department_id') ? $request->department_id : $user->departement_id,
            'pic_id' => $user->id,
            'bobot' => $request->has('bobot_kpi') ? $request->bobot_kpi : 100,
        ];

        if ($type === 'program_kerja') {
            if ($request->has('kategori_program_id')) {
                $data['kategori_program_id'] = $request->kategori_program_id;
            }
            ProgramKerja::create($data);
        } else {
            Project::create($data);
        }

        return redirect()->back()->with('success', 'Project created successfully');
    }

    public function show(int $id)
    {
        $project = Project::with(['boards.tasks', 'boards.pic', 'departement', 'pic'])->findOrFail($id);

        return Inertia::render('NewMigration/TimelineProject/TimelineProjectShow', [
            'project' => $project,
        ]);
    }

    public function edit(int $id)
    {
        $project = Project::findOrFail($id);
        $departements = Departement::all();
        $users = User::all();

        return Inertia::render('NewMigration/Wig/WigEdit', [
            'project' => $project,
            'departements' => $departements,
            'users' => $users
        ]);
    }

    public function update(Request $request, int $id)
    {
        $type = $request->get('type', 'wig');
        $model = $type === 'program_kerja' ? ProgramKerja::findOrFail($id) : Project::findOrFail($id);

        $data = [];
        if ($request->has('title')) $data['title'] = $request->title;
        if ($request->has('description')) $data['description'] = $request->description;

        if ($request->has('start_date')) $data['start_date'] = $request->start_date;
        if ($request->has('target_date')) $data['target_date'] = $request->target_date;
        if ($request->has('targetDate')) $data['target_date'] = $request->targetDate;

        if ($request->has('department_id')) $data['departement_id'] = $request->department_id;
        if ($request->has('departmentId')) $data['departement_id'] = $request->departmentId;

        if ($request->has('bobot_kpi')) $data['bobot'] = $request->bobot_kpi;
        if ($request->has('kategori_program_id')) $data['kategori_program_id'] = $request->kategori_program_id;

        $model->update($data);

        return redirect()->back()->with('success', 'Project updated successfully');
    }

    public function destroy(Request $request, int $id)
    {
        try {
            $type = $request->get('type', 'wig');
            $model = $type === 'program_kerja' ? ProgramKerja::findOrFail($id) : Project::findOrFail($id);
            $model->delete();
            return redirect()->back()->with('success', 'Project deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withErrors(['message' => 'Gagal menghapus: Project ini masih terkait dengan data lain.']);
        }
    }
}
