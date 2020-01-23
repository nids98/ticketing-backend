<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Task;
use App\Technician;

class PostsController extends Controller
{
    public function submit(Request $request) {

        $subcategory_id = $request->input("subcategory_id");
        $description = $request->input("desc");

        //Get all technicians of this category_id
        $all_tech_id = Technician::where('subcategory_id', $subcategory_id)->get();

        // Get all technicians who are assigned some task
        $all_assigned_tech_id = Task::where('subcategory_id', $subcategory_id)->whereNotIn('status', ['completed'])->get();
        
        $all_tech=[];
        $assigned_tech=[];

        foreach($all_tech_id as $item) {
            array_push($all_tech, $item->tech_id);
        }

        foreach($all_assigned_tech_id as $item) {
            if(!in_array($item->tech_id, $assigned_tech, true)){
                array_push($assigned_tech, $item->tech_id);
            }
        }

        $unassigned_tech = [];

        foreach($all_tech as $item) {
            if(!in_array($item, $assigned_tech)) {
                array_push($unassigned_tech, $item);
            }
        }

        $techid = 0;

        $minTaskEid = -1;

        if(empty($unassigned_tech)) {
            // Check task table
            // Get number of tasks of each employee
            $emptask_count =  DB::table('task')
            ->select(DB::raw('tech_id, count(*) as numTasks'))
            ->groupBy('tech_id')
            ->whereNotIn('status', ['completed'])
            ->get();


            //Get the employee id who has the minimum number of tasks
            $minTask = 100000000;
            
            foreach ($emptask_count as $item) {
                if($item->numTasks < $minTask) {
                    $minTask = $item->numTasks;
                    $minTaskEid = $item->tech_id;
                }
            }
            $techid=$minTaskEid;

        } else {
            $techid = $unassigned_tech[0];
        }

        // Create a new Task
        $task = new Task();

        $task->subcategory_id = $subcategory_id;
        $task->desc = $description;
        $task->status = 'assigned';
        $task->tech_id=$techid;

        $task->save();
        return $task;

    }
}
