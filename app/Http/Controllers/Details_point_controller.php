<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\V_detail_point;

class Details_point_controller extends Controller
{
    public function getDetailsPoint(Request $request){
        $id_equiipe = $request->input('id_equipe');
        $det = V_detail_point::where('id_equipe', $id_equiipe)->get();

        return view('details.detail_points', compact('det'));
    }
}
