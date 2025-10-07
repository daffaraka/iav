<?php

namespace App\Http\Controllers;

use App\Models\DataPrestasi;
use Illuminate\Http\Request;

class DataPrestasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Prestasi';
        $data = DataPrestasi::all();


        $data = [
            'title' => $title,
            'data' => $data
        ];
        return view('dashboard.prestasi.prestasi-index', $data);
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
    public function show(DataPrestasi $dataPrestasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataPrestasi $dataPrestasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataPrestasi $dataPrestasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataPrestasi $dataPrestasi)
    {
        //
    }
}
