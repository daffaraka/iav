<?php

namespace App\Http\Controllers\DynamicRoutes;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SelectController extends Controller
{
    public function getPicByDept(Request $request)
    {

        $unit = null;
        if (Auth::user()->unit == 'BPS' || Auth::user()->hasRole(['humas', 'admin'])) {
            $unit = ['BPS', 'Cinere', 'Jagakarsa', 'Pamulang'];
        } else {
            $unit = (array) Auth::user()->unit;
        }



        // dd($unit);
        $jabatan = $request->input('departemen');


        // dd($jabatan);

        $pic = null;
        if (Auth::user()->hasAnyRole(['tata-usaha', 'kepala-sekolah', 'kepala-psikolog', 'psikolog','kepala-tata-usaha'])) {

            if ($jabatan == 'Psikolog') {
                $pic = User::whereHas('roles', function ($query) {
                    $query->where('name', 'psikolog');
                })
                    ->where('unit', $unit)
                    ->select('id', 'name', 'departemen', 'jabatan', 'unit')->get();
            } else {
                $pic = User::where('jabatan', 'LIKE', "%{$jabatan}%")
                    ->whereIn('unit', $unit)
                    ->select('id', 'name', 'departemen', 'jabatan', 'unit')->get();
            }
        } else {
            $pic = User::where('jabatan', $jabatan)->select('id', 'name', 'departemen', 'unit', 'jabatan')->get();
        }



        // dd($pic);


        return response()->json($pic);
    }
}
