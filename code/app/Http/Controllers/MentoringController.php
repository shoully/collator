<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//models
use App\Models\Mentoring;
use App\Models\Task;
use App\Models\User;
use App\Models\Chat;

class MentoringController extends Controller
{
  public function store(Request $request)
  {
    /*/
        $validator = Validator::make($request->all(), [
            'Studentname1' => 'required|max:255',
        ]);
        /*/
    $mentoring = new Mentoring;
    $mentoring->title = empty($request->title) ? 'nontitle' : $request->title;
    $mentoring->mentor = empty($request->mentor) ? '0' : $request->mentor;
    $mentoring->mentee = empty($request->mentee) ? '0' : $request->mentee;

    $mentoring->save();

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

    return view('welcome', ['meetingrequests' => $mentoring, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat,]);
    //return redirect('/home');
  }
  public function remove(Mentoring $mentoring, Request $request)
  {
    Task::where('mentoring_id', $mentoring->id)->delete();
    //check if there is related Activities
    $mentoring->delete();

    $menteefind = new User;
    $menteefind = User::where('id', '=', $request->mentee)->take(1)->get();
    $mentee = $menteefind[0];

    $userloginedin = Auth::user();
    $mentoring = new Mentoring;
    $mentoring = Mentoring::where('mentee', '=', $request->mentee)->get();
    $task = Task::where('mentee', '=', $request->mentee)->get();

    $chatmentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '=',  $request->mentee)->get();
    $chattomentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '!=',  $request->mentee)->get();
    $allchat1 = array();
    $allchat2 = array();
    $allchat = array();
    foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
    foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
    $allchat = array_merge($allchat1, $allchat2);
    arsort($allchat);

    return view('welcome', ['meetingrequests' => $mentoring, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat,]);
    //return redirect('/home');
  }
}
