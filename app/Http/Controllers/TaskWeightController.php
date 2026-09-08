<?php

namespace App\Http\Controllers;

use App\Models\TaskWeight;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskWeightController extends Controller
{
    public function index()
    {
        $weights = TaskWeight::all();
        return Inertia::render('NewMigration/MasterData/MasterDataPage', [
            'weights' => $weights
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'value' => 'required|numeric'
        ]);

        TaskWeight::create($validated);

        return back();
    }

    public function update(Request $request, int $id)
    {
        $taskWeight = TaskWeight::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string',
            'value' => 'required|numeric'
        ]);

        $taskWeight->update($validated);

        return back();
    }

    public function destroy(int $id)
    {
        $taskWeight = TaskWeight::findOrFail($id);
        $taskWeight->delete();
        
        return back();
    }
}
