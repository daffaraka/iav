<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\Wig;
use App\Models\LeadMeasure;
use App\Models\TaskProcess;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';


        // Count total records from each table
        $totalDepartemen = Departement::count();
        $totalWig = Wig::count();
        $totalLeadMeasure = LeadMeasure::count();
        $totalTask = TaskProcess::count();

        // Chart data for WIG per department
        $wigPerDepartment = Departement::withCount('wigs')
            ->get()
            ->pluck('wigs_count', 'nama_dept')
            ->toArray();

        return view('dashboard.dashboard', compact(
            'title',
            'totalDepartemen',
            'totalWig',
            'totalLeadMeasure',
            'totalTask',
            'wigPerDepartment'
        ));
    }
}
