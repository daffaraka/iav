<?php

namespace App\Http\Controllers;

use App\Models\MasterLabel;
use Illuminate\Http\Request;

class MasterLabelController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
        ]);

        MasterLabel::create($validated);

        return back()->with('success', 'Label created successfully.');
    }

    public function update(Request $request, MasterLabel $masterLabel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:50',
        ]);

        $masterLabel->update($validated);

        return back()->with('success', 'Label updated successfully.');
    }

    public function destroy(MasterLabel $masterLabel)
    {
        $masterLabel->delete();

        return back()->with('success', 'Label deleted successfully.');
    }
}
