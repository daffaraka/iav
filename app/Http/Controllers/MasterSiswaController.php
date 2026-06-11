<?php

namespace App\Http\Controllers;

use App\Models\MasterSiswa;
use Illuminate\Http\Request;

class MasterSiswaController extends Controller
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
    public function show(MasterSiswa $masterSiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterSiswa $masterSiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterSiswa $masterSiswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterSiswa $masterSiswa)
    {
        //
    }

    public function generateQrCode(MasterSiswa $siswa)
    {
        $name = $siswa->nis;
        return response()->streamDownload(function () use ($name) {
            echo file_get_contents('https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . $name);
        }, $siswa->nis . '-' . $siswa->nama . '-' . $siswa->kelas . '.png');
    }
}
