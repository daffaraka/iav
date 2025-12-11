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
        if(Auth::user()->unit == 'BPS'){
            $unit = ['BPS','Cinere','Jagakarsa','Pamulang'];
        } else {
            $unit = (array) Auth::user()->unit;
        }

        $dept = $request->input('departemen');
        $pic = null;
        if (Auth::user()->hasAnyRole(['tata-usaha', 'super-admin', 'admin','humas'])) {
            $pic = User::where('departemen', $dept)->whereIn('unit',$unit)
            ->select('id', 'name', 'departemen', 'unit')->get();
        } else {
            $pic = User::where('departemen', $dept)->select('id', 'name', 'departemen', 'unit')->get();
        }
        return response()->json($pic);
    }
}
