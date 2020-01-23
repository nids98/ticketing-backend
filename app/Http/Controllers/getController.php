<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getController extends Controller
{
    public function getList(Request $request,$tech_idd) {

        $array = DB::table('task')->select('task_id','subcategory_id','status','created_at')
            ->where('tech_id', '=', $tech_idd)
            ->get();


        return response()->json($array);
    }
}
