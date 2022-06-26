<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Models\Task;
class TaskController extends Controller
{
  public function store(Request $request)
  {
    $task = new Task;
    $task->title = empty($request->title) ? 'nontitle' : $request->title;
    $task->description = empty($request->Description) ? 'nondescription' : $request->Description;
    $task->mentoring_id = $request->mentoring_id;
    $task->priority = $request->priority;
    $task->status = "New";
    $task->mentor = empty($request->mentor) ? '0' : $request->mentor;
    $task->mentee = empty($request->mentee) ? '0' : $request->mentee;

    $task->save();
    return App::call('App\Http\Controllers\HomeController@afterandreturn' , ['request' => $request]);
  }
  public function remove(Task $task, Request $request)
  {
    
    $task->delete();
    return App::call('App\Http\Controllers\HomeController@afterandreturn' , ['request' => $request]);
  }
  public function markdone(Task $task, Request $request)
  {
  
    $task->status = "Done";
    $task->save();

    return App::call('App\Http\Controllers\HomeController@afterandreturn' , ['request' => $request]);
  }
}
