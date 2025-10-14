<?php

namespace App\Http\Controllers;


use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Departement';
        $departement = Departement::all();




        $data = [
            'title' => $title,
            'departement' => $departement
        ];
        return view('dashboard.departement.dept-index', $data);
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
    public function show(Departement $departement)
    {

        $title = $departement->nama_dept;


        $data = [
            'title' => $title,
            'departement' => $departement->load('wigs'),
            'wig_total' => $departement->wigs()->count(),
            'wig_aktif' => $departement->wigs()->where('status_wig', 1)->count(),
            'wig_selesai' => $departement->wigs()->where('status_wig', 2)->count(),
            'wig_tidak_aktif' => $departement->wigs()->where('status_wig', 0)->count(),
        ];

        // dd($data);


        return view('dashboard.departement.dept-show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departement $departement) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departement $departement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departement $departement)
    {
        //
    }
}
