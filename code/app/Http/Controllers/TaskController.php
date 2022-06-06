<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//models
use App\Models\Mentoring;
use App\Models\Task;
use App\Models\User;
use App\Models\Chat;
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
        
        $chatmentee = Chat::where('mentee' , '=', $request->mentee)->where('mentor' , '=',  $request->mentee)->get();
          $chattomentee = Chat::where('mentee' , '=', $request->mentee)->where('mentor' , '!=',  $request->mentee)->get();
          $allchat1 = array();
          $allchat2 = array();
          $allchat = array();
          foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
          foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
          $allchat = array_merge($allchat1, $allchat2);
          arsort($allchat);

          return view('welcome', ['meetingrequests' => $mentoring,'mentorings' => $mentoring,'tasks' => $task,'currentuser' => $userloginedin,'mentee'=>$mentee,'chats'=>$allchat,]);
/*/
        $development = new Development;
        $development = Development::find($request->Development_id);
        $development->Total_task += 1;
        $development->save();
/*/

//       return redirect('/home');
    }
    public function remove(Task $task , Request $request)
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
        $task = new Task;
        $task = Task::where('mentee' , '=', $request->mentee)->get();
        $menteefind = new User;
        $menteefind = User::where('id' , '=', $request->mentee)->take(1)->get();
        $mentee = $menteefind[0];
        
        $userloginedin = Auth::user();
        $mentoring = new Mentoring;
        $mentoring = Mentoring::where('mentee' , '=', $request->mentee)->get();
        
        $chatmentee = Chat::where('mentee' , '=', $request->mentee)->where('mentor' , '=',  $request->mentee)->get();
        $chattomentee = Chat::where('mentee' , '=', $request->mentee)->where('mentor' , '!=',  $request->mentee)->get();
        $allchat1 = array();
        $allchat2 = array();
        $allchat = array();
        foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
        foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
        $allchat = array_merge($allchat1, $allchat2);
        arsort($allchat);

        return view('welcome', ['meetingrequests' => $mentoring,'mentorings' => $mentoring,'tasks' => $task,'currentuser' => $userloginedin,'mentee'=>$mentee,'chats'=>$allchat,]);
       //return redirect('/home');
    }
    public function markdone(Task $task,Request $request)
    {
        /*/
        $development = new Development;
        $development = Development::find( $task->Development_id);
        //here added logic if the Activities is 
        //not new then -1 to the (Completed_Activities) as well
        $development->Completed_task += 1;
        $development->save();
/*/
        $task->status = "Done";
        $task->save();


        
        $task = Task::where('mentee' , '=', $request->mentee)->get();
        $menteefind = new User;
        $menteefind = User::where('id' , '=', $request->mentee)->take(1)->get();
        $mentee = $menteefind[0];
        
        $userloginedin = Auth::user();
        $mentoring = new Mentoring;
        $mentoring = Mentoring::where('mentee' , '=', $request->mentee)->get();
        
        $chatmentee = Chat::where('mentee' , '=', $request->mentee)->where('mentor' , '=',  $request->mentee)->get();
          $chattomentee = Chat::where('mentee' , '=', $request->mentee)->where('mentor' , '!=',  $request->mentee)->get();
          $allchat1 = array();
          $allchat2 = array();
          $allchat = array();
          foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
          foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
          $allchat = array_merge($allchat1, $allchat2);
          arsort($allchat);

          return view('welcome', ['meetingrequests' => $mentoring,'mentorings' => $mentoring,'tasks' => $task,'currentuser' => $userloginedin,'mentee'=>$mentee,'chats'=>$allchat,]);
       //return redirect('/home');
    }
}
