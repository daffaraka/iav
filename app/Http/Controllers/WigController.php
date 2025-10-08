<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Wig;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class WigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'WIG';
        // $wig = Wig::all();


        $data = [
            'title' => $title,
            // 'wig' => $wig,
            'modul' => Str::lower($title)
        ];
        return view('dashboard.sdm.wig.wig-index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $title = 'Tambah WIG';
        $unit = Sekolah::all()->unique('unit');

        $data = [
            'title' => $title,
            'unit' => $unit,
            'modul' => Str::lower($title)
        ];

        return view('dashboard.sdm.wig.wig-create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
   dd($request->all());
        $request->validate([

        ],[

        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Wig $wig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wig $wig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wig $wig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wig $wig)
    {
        //
    }
}
