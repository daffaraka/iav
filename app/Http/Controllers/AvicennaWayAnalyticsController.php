<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvicennaWayAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $departemen = $user->departemen;
        
        $startDate = $request->query('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->query('end_date', now()->format('Y-m-d'));

        $activitiesQuery = \App\Models\AwActivity::with('user')
            ->whereHas('user', function($q) use ($departemen) {
                $q->where('departemen', $departemen);
            })
            ->whereBetween('date', [$startDate, $endDate]);

        $activities = $activitiesQuery->get();

        // Analytics processing
        $habitsCount = [];
        $valuesCount = [];
        $topStars = [];

        foreach ($activities as $activity) {
            // Process habits
            if (is_array($activity->habits)) {
                foreach ($activity->habits as $habit) {
                    $habitsCount[$habit] = ($habitsCount[$habit] ?? 0) + 1;
                }
            }

            // Process values
            if (is_array($activity->aw_value)) {
                foreach ($activity->aw_value as $val) {
                    $valuesCount[$val] = ($valuesCount[$val] ?? 0) + 1;
                }
            }

            // Process stars
            if ($activity->is_favorite) {
                $userName = $activity->user->name;
                $topStars[$userName] = ($topStars[$userName] ?? 0) + 1;
            }
        }

        // Sort arrays for dashboard
        arsort($habitsCount);
        arsort($valuesCount);
        arsort($topStars);

        return \Inertia\Inertia::render('AvicennaWay/Analytics', [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'habitsCount' => $habitsCount,
            'valuesCount' => $valuesCount,
            'topStars' => $topStars,
            'departemen' => $departemen
        ]);
    }
}
