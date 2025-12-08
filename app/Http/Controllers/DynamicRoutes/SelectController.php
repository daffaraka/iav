<?php

namespace App\Http\Controllers\DynamicRoutes;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SelectController extends Controller
{
    public function getPicByDept(Request $request)
    {
        $dept = $request->input('departemen');
        $pic = User::where('departemen', $dept)->select('id','name','departemen')->get();
        return response()->json($pic);
    }
}
