<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class MeetingController extends Controller
{
    public function index()
    {
        $meetings = Meeting::paginate(10);
        return Inertia::render('NewMigration/Meeting/MeetingIndex', [
            'data' => $meetings
        ]);
    }

    public function create()
    {
        return Inertia::render('NewMigration/Meeting/MeetingCreate');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'meeting_date' => 'required|date',
            'meeting_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,png'
        ]);

        if ($request->hasFile('meeting_document')) {
            $validated['meeting_document'] = $request->file('meeting_document')->store('meetings', 'public');
        }

        Meeting::create($validated);

        return redirect()->route('kanban.meeting.index');
    }

    public function show(int $id)
    {
        $meeting = Meeting::findOrFail($id);
        return Inertia::render('NewMigration/Meeting/MeetingShow', [
            'data' => $meeting
        ]);
    }

    public function edit(int $id)
    {
        $meeting = Meeting::findOrFail($id);
        return Inertia::render('NewMigration/Meeting/MeetingEdit', [
            'data' => $meeting
        ]);
    }

    public function update(Request $request, int $id)
    {
        $meeting = Meeting::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string',
            'meeting_date' => 'required|date',
            'meeting_document' => 'nullable|file|mimes:pdf,doc,docx,jpg,png'
        ]);

        if ($request->hasFile('meeting_document')) {
            if ($meeting->meeting_document) {
                Storage::disk('public')->delete($meeting->meeting_document);
            }
            $validated['meeting_document'] = $request->file('meeting_document')->store('meetings', 'public');
        }

        $meeting->update($validated);

        return back();
    }

    public function destroy(int $id)
    {
        $meeting = Meeting::findOrFail($id);
        if ($meeting->meeting_document) {
            Storage::disk('public')->delete($meeting->meeting_document);
        }
        $meeting->delete();
        
        return redirect()->route('kanban.meeting.index');
    }
}
