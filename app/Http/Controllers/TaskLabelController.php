<?php

namespace App\Http\Controllers;

use App\Models\TaskLabel;
use Illuminate\Http\Request;

class TaskLabelController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_process_id' => 'required|exists:task_processes,id',
            'label' => 'required|string',
            'color' => 'nullable|string'
        ]);

        TaskLabel::create($validated);

        return back();
    }

    public function destroy(int $id)
    {
        $taskLabel = TaskLabel::findOrFail($id);
        $taskLabel->delete();
        
        return back();
    }
}
