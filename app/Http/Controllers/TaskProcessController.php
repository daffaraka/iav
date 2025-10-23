<?php

namespace App\Http\Controllers;

use App\Models\TaskProcess;
use Illuminate\Http\Request;

class TaskProcessController extends Controller
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
    public function show(TaskProcess $taskProcess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskProcess $taskProcess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskProcess $taskProcess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskProcess $taskProcess)
    {
        //
    }

    public function toggleStatus(Request $request)
    {
        $taskProcess = TaskProcess::find($request->id);
        $taskProcess->status = $request->status;
        $taskProcess->save();
        return response()->json(['message' => 'Status berhasil diubah']);
    }
}
