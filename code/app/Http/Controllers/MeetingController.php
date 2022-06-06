<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//models
use App\Models\Meeting;
use App\Models\User;
use App\Models\Chat;
use App\Models\Task;
use App\Models\Mentoring;

class MeetingController extends Controller
{
public function store(Request $request)
    {
        $meeting = new Meeting;
        $meeting->description = empty($request->description) ? 'nondescription' : $request->description;
        $meeting->notes = empty($request->notes) ? 'nonnotes' : $request->notes;
        $meeting->date = empty($request->date) ? 'nondate' : $request->date;
        $meeting->URL = empty($request->URL) ? 'nonURL' : $request->URL;
        $meeting->status = "requested";
        $meeting->mentor = empty($request->mentor) ? '0' : $request->mentor;
        $meeting->mentee = empty($request->mentee) ? '0' : $request->mentee;

        $meeting->save();
     
       
        


        $userloginedin = Auth::user();
        $task = Task::where('mentee' , '=', $userloginedin->id)->get();
            $menteefind = User::where('id' , '=', $userloginedin->id)->take(1)->get();
            $mentee = $menteefind[0];
            
            $meeting = Meeting::where('mentee' , '=', $userloginedin->id)->get();
           
            $mentoring = Mentoring::where('mentee' , '=', $userloginedin->id)->get();
            
            $chatmentee = Chat::where('mentee' , '=', $userloginedin->id)->where('mentor' , '=',  $userloginedin->id)->get();
            $chattomentee = Chat::where('mentee' , '=', $userloginedin->id)->where('mentor' , '!=',  $userloginedin->id)->get();
            $allchat1 = array();
            $allchat2 = array();
            $allchat = array();
            foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
            foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
            $allchat = array_merge($allchat1, $allchat2);
            arsort($allchat);
         
    
            return view('welcome', ['meetingrequests' => $meeting,'mentorings' => $mentoring,'tasks' => $task,'currentuser' => $userloginedin,'mentee'=>$mentee,'chats'=>$allchat,]);
     }

     public function remove(Meeting $meeting)
     {
         $meeting->delete();
        
          return redirect('/home');
     }
}
