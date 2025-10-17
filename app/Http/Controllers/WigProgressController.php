<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Wig;
use App\Models\WigProgress;
use Illuminate\Http\Request;

class WigProgressController extends Controller
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

        $request->validate([
            'wig_id' => 'required|exists:wigs,id',
            'progress_wig' => 'required|numeric|min:0',
            'bulan_wig' => 'required|numeric|min:1|max:12'
        ]);

        $wigProgress = WigProgress::create([
            'wig_id' => $request->wig_id,
            'progress_wig' => $request->progress_wig,
            'bulan' => $request->bulan_wig
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data WIG Progress berhasil ditambahkan',
            'data' => $wigProgress
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(WigProgress $wigProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WigProgress $wigProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WigProgress $wigProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WigProgress $wigProgress)
    {
        //
    }



    public function getWigById($id)
    {
        $wigProgress = WigProgress::find($id);

        if (!$wigProgress) {
            return response()->json([
                'success' => false,
                'message' => 'WIG tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $wigProgress
        ]);
    }
}
