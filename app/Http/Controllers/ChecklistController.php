<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_process_id' => 'required|exists:task_processes,id',
            'text' => 'required|string'
        ]);

        Checklist::create($validated);

        return back();
    }

    public function update(Request $request, int $id)
    {
        $checklist = Checklist::findOrFail($id);
        
        $validated = $request->validate([
            'text' => 'required|string'
        ]);

        $checklist->update($validated);

        return back();
    }

    public function destroy(int $id)
    {
        $checklist = Checklist::findOrFail($id);
        $checklist->delete();
        
        return back();
    }

    public function toggle(int $id)
    {
        $checklist = Checklist::findOrFail($id);
        $checklist->completed = !$checklist->completed;
        $checklist->save();
        
        return back();
    }
}
