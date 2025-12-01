<?php

namespace App\Http\Controllers\AQR;

use App\Http\Controllers\Controller;

use App\Models\ProgresTiket;
use App\Models\User;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Prompts\Progress;

class TiketController extends Controller
{

    public function index(Request $request)
    {
        $query = Tiket::with(['humas', 'pic']);

        // Filter berdasarkan pengirim jika ada
        if ($request->has('pengirim') && $request->pengirim != '') {
            $query->where('pengirim', $request->pengirim);
        }

        if (Auth::user()->hasRole('Admin')) {
            $data = $query->get();
        } else {
            $data = $query->where('pic_id', Auth::user()->id)->get();
        }

        return view('admin.tiket.tiket-index', compact('data'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Tiket $tiket)
    {
        return view('admin.tiket.tiket-detail', compact('tiket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tiket $tiket)
    {
        $tiket = Tiket::with(['humas', 'pic', 'progres' => function ($query) {
            $query->latest();
        }])->find($tiket->id);
        $picSelect = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get();



        // dd($tiket);
        return view('admin.tiket.tiket-edit', compact('tiket', 'picSelect'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tiket $tiket)
    {

        // dd(Auth::user()->hasRole('Admin'));



        if (Auth::user()->hasRole('Admin')) {
            $tiket->update([
                'status' => 'Proses',
                'departemen' => $request->departemen,
                'humas_id' => Auth::user()->id,
                'pic_id' => $request->pic_menanggapi
            ]);
        } else {

            if ($request->has('fotopengerjaan')) {
                $file = $request->file('fotopengerjaan');
                $fileName = $file->getClientOriginalName();
                $path = $file->move('tiket/'.now()->year . '/progres/', $fileName);
            }

            $progressTiket = new ProgresTiket();

            $progressTiket->create([
                'penanganan' => $request->penanganan,
                'status' => 'Proses',
                'fotopengerjaan' => $path ?? null,
                'direspon_at' => date('Y-m-d H:i:s'),
                'tiket_id' => $tiket->id
            ]);
        }




        return redirect()->route('tiket.edit', $tiket->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tiket $tiket)
    {
        //
    }


    public function finish(Tiket $tiket)
    {
        $tiket->status = 'Selesai';
        $tiket->save();

        return redirect()->route('tiket.edit', $tiket->id);
    }
}
