<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Development;
use App\Models\Task;
class TaskController extends Controller
{
    public function store(Request $request)
    {
        $task = new Task;
        $task->Title = empty($request->Title) ? 'nontitle' : $request->Title;
        $task->Description = empty($request->Description) ? 'nondescription' : $request->Description;
        $task->Development_id = $request->Development_id;
        $task->Priorities = $request->Priorities;
        $task->Status = "New";
        $task->save();

        $development = new Development;
        $development = Development::find($request->Development_id);
        $development->Total_task += 1;

        $development->save();
       return redirect('/home');
    }
    public function remove(Task $task)
    {
        $development = new Development;
        $development = Development::find( $task->Development_id);
        //here added logic if the Activities is 
        //not new then -1 to the (Completed_Activities) as well
        $development->Total_task -= 1;
        $development->save();
        $task->delete();
       return redirect('/home');
    }
    public function markdone(Task $task)
    {
        $development = new Development;
        $development = Development::find( $task->Development_id);
        //here added logic if the Activities is 
        //not new then -1 to the (Completed_Activities) as well
        $development->Completed_task += 1;
        $development->save();

        $task->Status = "Done";
        $task->save();

       return redirect('/home');
    }
}
