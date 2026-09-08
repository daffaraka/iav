<?php

namespace App\Http\Controllers\NewMigration;

use App\Http\Controllers\Controller;
use App\Models\NewMigration\LeadMeasure;
use App\Models\NewMigration\Wig;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LeadMeasureController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wig_id' => 'required|exists:wigs,id',
            'judul_lead' => 'required',
            'bobot_board' => 'numeric|min:0'
        ]);

        $wig = Wig::findOrFail($validated['wig_id']);
        
        $currentSum = $wig->lead_measures()->sum('bobot_board');
        
        if (($currentSum + $validated['bobot_board']) > $wig->bobot_kpi) {
            return back()->withErrors(['bobot_board' => 'Sum of bobot_board exceeds wig bobot_kpi.']);
        }

        LeadMeasure::create($validated);

        return back();
    }

    public function update(Request $request, int $id)
    {
        $leadMeasure = LeadMeasure::findOrFail($id);
        
        $validated = $request->validate([
            'judul_lead' => 'required',
            'bobot_board' => 'numeric|min:0'
        ]);

        $wig = $leadMeasure->wig;
        $currentSum = $wig->lead_measures()->where('id', '!=', $id)->sum('bobot_board');
        
        if (($currentSum + $validated['bobot_board']) > $wig->bobot_kpi) {
            return back()->withErrors(['bobot_board' => 'Sum of bobot_board exceeds wig bobot_kpi.']);
        }

        $leadMeasure->update($validated);

        return back();
    }

    public function destroy(int $id)
    {
        $leadMeasure = LeadMeasure::findOrFail($id);
        $leadMeasure->delete();
        
        return back();
    }
}
