<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
//models
use App\Models\Mentoring;
use App\Models\Document;
use App\Models\Task;
use App\Models\User;
use App\Models\Chat;
use App\Models\Meeting;

class HomeController extends Controller
{
  public function index()
  {

     $userloginedin = Auth::user();

    $task = Task::where('mentee', '=', $userloginedin->id)->get();
    $menteefind = User::where('id', '=', $userloginedin->id)->take(1)->get();
    $mentee = $menteefind[0];

    $document = Document::where('mentee', '=', $userloginedin->id)->get();
    $mentoring = Mentoring::where('mentee', '=', $userloginedin->id)->get();
    $meeting = Meeting::where('mentee', '=', $userloginedin->id)->get();
    $chatmentee = Chat::where('mentee', '=', $userloginedin->id)->where('mentor', '=',  $userloginedin->id)->get();
    $chattomentee = Chat::where('mentee', '=', $userloginedin->id)->where('mentor', '!=',  $userloginedin->id)->get();
    $allchat1 = array();
    $allchat2 = array();
    $allchat = array();
    foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
    foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
    $allchat = array_merge($allchat1, $allchat2);
    arsort($allchat);


    return view('welcome', ['meetingrequests' => $meeting, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat, 'documents' => $document,]);
    //return view('welcome', ['meetingrequests' => $mentoring,'mentorings' => $mentoring,'activities' => $mentoring,]);
  }
  public function listofuser()
  {
    $user = new User;
    $user = User::where('type', '=', "Mentee")->get();
    return view('welcometoclient', ['users' => $user,]);
  }

  public function fromlistofuser(User $user)
  {
    $mentee = $user;
    $userloginedin = Auth::user();
    $document = Document::where('mentee', '=', $user->id)->get();
    $task = new Task;
    $task = Task::where('mentee', '=', $user->id)->get();

    $mentoring = new Mentoring;
    $mentoring = Mentoring::where('mentee', '=', $user->id)->get();
    $meeting = Meeting::where('mentee', '=', $user->id)->get();
    $chatmentee = Chat::where('mentee', '=', $user->id)->where('mentor', '=',  $user->id)->get();
    $chattomentee = Chat::where('mentee', '=', $user->id)->where('mentor', '!=',  $user->id)->get();
    $allchat1 = array();
    $allchat2 = array();
    $allchat = array();
    foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
    foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
    $allchat = array_merge($allchat1, $allchat2);
    arsort($allchat);

    return view('welcome', ['meetingrequests' => $meeting, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat, 'documents' => $document,]);
  }

  public function afterandreturn($request)
  {
    $task = Task::where('mentee', '=', $request->mentee)->get();
    $menteefind = new User;
    $menteefind = User::where('id', '=', $request->mentee)->take(1)->get();
    $mentee = $menteefind[0];
    $userloginedin = Auth::user();
    $mentoring = new Mentoring;
    $meeting = Meeting::where('mentee', '=', $request->mentee)->get();
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

    return view('welcome', ['meetingrequests' => $meeting, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat, 'documents' => $document,]);
  }
}
