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

    public function taskDesc(Request $request,$tech_id,$task_idd){

        $info = DB::table('task')->select('desc', 'status','created_at','updated_at')
            ->where('task_id', '=', $task_idd)
            ->get();

        $cat_idd = DB::table('task')->select('subcategory_id')
            ->where('task_id', '=', $task_idd)
            ->get();

        $cat_name_obj= DB::table('subcategory')->select('subcategory_name')
            ->where('subcategory_id', '=', strval($cat_idd[0]->subcategory_id) )
            ->get();

        $cat_name= strval($cat_name_obj[0]->subcategory_name);

        $json = json_decode( $info );
        $json[0]->cat_name= $cat_name;

        return response()->json($json);
    }
}
