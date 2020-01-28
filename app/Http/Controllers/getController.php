<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class getController extends Controller
{


    public function getList(Request $request) {

        $tech_idd = $request->input('tech_id');

        $header = $request->header('x-auth-token');
        if($header != 'nidhi') {
            return response()->json(["error"=> "Not authorized"]);
        }

        $array = DB::table('task')->select('task_id','subcategory_id','status','created_at')
            ->where('tech_id', '=', $tech_idd)
            ->get();
            return response()->json($array);
    }

    public function taskDesc(Request $request,$task_idd){

        $info = DB::table('task')->select('desc', 'status','created_at','updated_at','subcategory_id','tech_id')
            ->where('task_id', '=', $task_idd)
            ->get();

        $tech_id=$info[0]->tech_id;

//        $cat_idd = $info[0]-> DB::table('task')->select('subcategory_id')
//            ->where('task_id', '=', $task_idd)
//            ->get();

        $cat_name_obj= DB::table('subcategory')->select('subcategory_name')
            ->where('subcategory_id', '=', strval($info[0]->subcategory_id) )
            ->get();

        $tech_nm= DB::table('technician')->select('tech_name')
            ->where('tech_id', '=',$tech_id )
            ->get();

        $cat_name= strval($cat_name_obj[0]->subcategory_name);
        $tech_name= strval($tech_nm[0]->tech_name);

        $json = json_decode( $info );
        $json[0]->cat_name= $cat_name;
        $json[0]->tech_name= $tech_name;

        return response()->json($json);
    }
}
