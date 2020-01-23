<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class putController extends Controller
{
    public function updateStatus(Request $request,$task_idd) {

        DB::table('task')
            ->where ('task_id',$task_idd)
            ->where ('status','start')
            ->update(['status' => 'completed']);

        DB::table('task')
            ->where ('task_id',$task_idd)
            ->where ('status','assigned')
            ->update(['status' => 'start']);

        return "Success";
    }
}
