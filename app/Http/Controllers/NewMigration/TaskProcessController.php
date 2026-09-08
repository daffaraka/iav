<?php

namespace App\Http\Controllers\NewMigration;

use App\Http\Controllers\Controller;
use App\Models\NewMigration\LeadMeasure;
use App\Models\NewMigration\TaskProcess;
use App\Models\TaskUserHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TaskProcessController extends Controller
{
    public function index(int $leadMeasureId)
    {
        $leadMeasure = LeadMeasure::with('wig')->findOrFail($leadMeasureId);
        $tasks = TaskProcess::where('lead_measure_id', $leadMeasureId)
            ->orderBy('position')
            ->get()
            ->groupBy('column_id');
            
        $users = User::all();
        
        return Inertia::render('NewMigration/Kanban/BoardView', [
            'leadMeasure' => $leadMeasure,
            'tasks' => $tasks,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_measure_id' => 'required|exists:lead_measures,id',
            'nama_tugas' => 'required',
            'priority' => 'in:low,medium,high',
            'column_id' => 'in:new,progress,done',
            'pic_id' => 'nullable|exists:users,id'
        ]);

        $validated['new_date'] = now();
        $maxPosition = TaskProcess::where('lead_measure_id', $validated['lead_measure_id'])
            ->where('column_id', $validated['column_id'])
            ->max('position');
            
        $validated['position'] = ($maxPosition ?? 0) + 1;

        $task = TaskProcess::create($validated);

        TaskUserHistory::create([
            'task_process_id' => $task->id,
            'user_id' => Auth::id(),
            'action' => 'new'
        ]);

        return back();
    }

    public function update(Request $request, int $id)
    {
        $task = TaskProcess::findOrFail($id);
        
        $validated = $request->validate([
            'nama_tugas' => 'required',
            'priority' => 'in:low,medium,high',
            'pic_id' => 'nullable|exists:users,id'
        ]);

        $task->update($validated);

        TaskUserHistory::create([
            'task_process_id' => $task->id,
            'user_id' => Auth::id(),
            'action' => 'update'
        ]);

        return back();
    }

    public function destroy(int $id)
    {
        $task = TaskProcess::findOrFail($id);
        $task->delete();
        
        return back();
    }

    public function move(Request $request, int $id)
    {
        $validated = $request->validate([
            'column_id' => 'required|in:new,progress,done',
            'position' => 'required|integer'
        ]);

        $task = TaskProcess::findOrFail($id);
        $task->column_id = $validated['column_id'];
        $task->position = $validated['position'];

        if ($validated['column_id'] === 'progress') {
            $task->proses_date = now();
        } elseif ($validated['column_id'] === 'done') {
            $task->end_date = now();
        }

        $task->save();

        TaskUserHistory::create([
            'task_process_id' => $task->id,
            'user_id' => Auth::id(),
            'action' => 'move_to_' . $validated['column_id']
        ]);

        return back();
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|exists:task_processes,id',
            'tasks.*.position' => 'required|integer',
            'tasks.*.column_id' => 'required|in:new,progress,done'
        ]);

        foreach ($validated['tasks'] as $taskData) {
            TaskProcess::where('id', $taskData['id'])->update([
                'position' => $taskData['position'],
                'column_id' => $taskData['column_id']
            ]);
        }

        return back();
    }

    public function myJobs()
    {
        $tasks = TaskProcess::where('pic_id', Auth::id())
            ->orderBy('position')
            ->get()
            ->groupBy('column_id');
            
        return Inertia::render('NewMigration/Task/TaskMyJobs', [
            'data' => $tasks
        ]);
    }
}
