<?php

namespace App\Http\Controllers;

use App\Models\WigHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WigHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wigHistories = WigHistory::with(['wig', 'user'])->get();
        return Inertia::render('WigHistory/WigHistoryIndex', [
            'wigHistories' => $wigHistories
        ]);
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
    public function show(WigHistory $wigHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WigHistory $wigHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WigHistory $wigHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WigHistory $wigHistory)
    {
        //
    }
}
