<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//models
use App\Models\Mentoring;
use App\Models\Task;
use App\Models\User;
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

        $task = new Task;
        $task = Task::where('mentee' , '=', $request->mentee)->get();
        $menteefind = new User;
        $menteefind = User::where('id' , '=', $request->mentee)->take(1)->get();
        $mentee = $menteefind[0];
        
        $userloginedin = Auth::user();
        $mentoring = new Mentoring;
        $mentoring = Mentoring::where('mentee' , '=', $request->mentee)->get();
        
        return view('welcome', ['meetingrequests' => $mentoring,'mentorings' => $mentoring,'tasks' => $task,'currentuser' => $userloginedin,'mentee'=>$mentee,]);
/*/
        $development = new Development;
        $development = Development::find($request->Development_id);
        $development->Total_task += 1;
        $development->save();
/*/

//       return redirect('/home');
    }
    public function remove(Task $task)
    {
      /*/
        $development = new Development;
        $development = Development::find( $task->Development_id);
        //here added logic if the Activities is 
        //not new then -1 to the (Completed_Activities) as well
        $development->Total_task -= 1;
        $development->save();
      /*/
        $task->delete();
       return redirect('/home');
    }
    public function markdone(Task $task)
    {
        /*/
        $development = new Development;
        $development = Development::find( $task->Development_id);
        //here added logic if the Activities is 
        //not new then -1 to the (Completed_Activities) as well
        $development->Completed_task += 1;
        $development->save();
/*/
        $task->Status = "Done";
        $task->save();

       return redirect('/home');
    }
}
