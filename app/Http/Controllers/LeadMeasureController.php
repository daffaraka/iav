<?php

namespace App\Http\Controllers;

use App\Models\LeadMeasure;
use Illuminate\Http\Request;

class LeadMeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadMeasure $leadMeasure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadMeasure $leadMeasure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadMeasure $leadMeasure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadMeasure $leadMeasure)
    {
        //
    }


    public function getLmTasks(Request $request)
    {


        $leadMeasure = LeadMeasure::find($request->id);



        $tasks = $leadMeasure->tasks()->get();

          dd($tasks);
        return response()->json($tasks);
    }

}
