<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//models
use App\Models\Mentoring;
use App\Models\Task;
use App\Models\User;
use App\Models\Chat;
use App\Models\Document;
use App\Models\Meeting;
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
    $meeting = Meeting::where('mentee' , '=', $request->mentee)->get();
    $document = Document::where('mentee', '=', $request->mentee)->get();
    $task = new Task;
    $task = Task::where('mentee', '=', $request->mentee)->get();
    $menteefind = new User;
    $menteefind = User::where('id', '=', $request->mentee)->take(1)->get();
    $mentee = $menteefind[0];

    $userloginedin = Auth::user();
    $mentoring = new Mentoring;
    $mentoring = Mentoring::where('mentee', '=', $request->mentee)->get();

    $chatmentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '=',  $request->mentee)->get();
    $chattomentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '!=',  $request->mentee)->get();
    $allchat1 = array();
    $allchat2 = array();
    $allchat = array();
    foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
    foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
    $allchat = array_merge($allchat1, $allchat2);
    arsort($allchat);

    return view('welcome', ['meetingrequests' => $meeting, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat,'documents' => $document,]);

  }
  public function remove(Task $task, Request $request)
  {
    
    $task->delete();
    $task = new Task;
    $task = Task::where('mentee', '=', $request->mentee)->get();
    $menteefind = new User;
    $menteefind = User::where('id', '=', $request->mentee)->take(1)->get();
    $mentee = $menteefind[0];

    $userloginedin = Auth::user();
    $mentoring = new Mentoring;
    $meeting = Meeting::where('mentee' , '=', $request->mentee)->get();
    $mentoring = Mentoring::where('mentee', '=', $request->mentee)->get();
    $document = Document::where('mentee', '=', $request->mentee)->get();
    $chatmentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '=',  $request->mentee)->get();
    $chattomentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '!=',  $request->mentee)->get();
    $allchat1 = array();
    $allchat2 = array();
    $allchat = array();
    foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
    foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
    $allchat = array_merge($allchat1, $allchat2);
    arsort($allchat);

    return view('welcome', ['meetingrequests' => $meeting, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat,'documents' => $document,]);
  }
  public function markdone(Task $task, Request $request)
  {
  
    $task->status = "Done";
    $task->save();

    $task = Task::where('mentee', '=', $request->mentee)->get();
    $menteefind = new User;
    $menteefind = User::where('id', '=', $request->mentee)->take(1)->get();
    $mentee = $menteefind[0];

    $userloginedin = Auth::user();
    $mentoring = new Mentoring;
    $meeting = Meeting::where('mentee' , '=', $userloginedin->id$request->mentee)->get();
    $mentoring = Mentoring::where('mentee', '=', $request->mentee)->get();
    $document = Document::where('mentee', '=', $request->mentee)->get();
    $chatmentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '=',  $request->mentee)->get();
    $chattomentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '!=',  $request->mentee)->get();
    $allchat1 = array();
    $allchat2 = array();
    $allchat = array();
    foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
    foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
    $allchat = array_merge($allchat1, $allchat2);
    arsort($allchat);

    return view('welcome', ['meetingrequests' => $meeting, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat,'documents' => $document,]);
  }
}
