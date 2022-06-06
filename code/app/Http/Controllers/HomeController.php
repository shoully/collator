<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//models
use App\Models\Mentoring;

use App\Models\Task;
use App\Models\User;
use App\Models\Chat;

class HomeController extends Controller
{
  public function index()
  {

    $userloginedin = Auth::user();

    $task = Task::where('mentee', '=', $userloginedin->id)->get();
    $menteefind = User::where('id', '=', $userloginedin->id)->take(1)->get();
    $mentee = $menteefind[0];


    $mentoring = Mentoring::where('mentee', '=', $userloginedin->id)->get();

    $chatmentee = Chat::where('mentee', '=', $userloginedin->id)->where('mentor', '=',  $userloginedin->id)->get();
    $chattomentee = Chat::where('mentee', '=', $userloginedin->id)->where('mentor', '!=',  $userloginedin->id)->get();
    $allchat1 = array();
    $allchat2 = array();
    $allchat = array();
    foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
    foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
    $allchat = array_merge($allchat1, $allchat2);
    arsort($allchat);


    return view('welcome', ['meetingrequests' => $mentoring, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat,]);
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

    $task = new Task;
    $task = Task::where('mentee', '=', $user->id)->get();

    $mentoring = new Mentoring;
    $mentoring = Mentoring::where('mentee', '=', $user->id)->get();

    $chatmentee = Chat::where('mentee', '=', $user->id)->where('mentor', '=',  $user->id)->get();
    $chattomentee = Chat::where('mentee', '=', $user->id)->where('mentor', '!=',  $user->id)->get();
    $allchat1 = array();
    $allchat2 = array();
    $allchat = array();
    foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
    foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
    $allchat = array_merge($allchat1, $allchat2);
    arsort($allchat);

    return view('welcome', ['meetingrequests' => $mentoring, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat,]);
  }
}
