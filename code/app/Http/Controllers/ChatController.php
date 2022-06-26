<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
use App\Models\Task;
use App\Models\Mentoring;
use App\Models\Document;
use App\Models\Meeting;
class ChatController extends Controller
{
    public function store(Request $request)
    {

        $chat = new Chat;
        $chat->message = $request->message;
        $chat->mentor = empty($request->mentor) ? '0' : $request->mentor;
        $chat->mentee = empty($request->mentee) ? '0' : $request->mentee;

        $chat->save();


        //$chat = Chat::where('mentee' , '=', $request->mentee)->get();
        $meeting = Meeting::where('mentee' , '=', $request->mentee)->get();
        $document = Document::where('mentee', '=', $request->mentee)->get();

        $task = Task::where('mentee', '=', $request->mentee)->get();
        $menteefind = User::where('id', '=', $request->mentee)->take(1)->get();
        $mentee = $menteefind[0];

        $userloginedin = Auth::user();
        $mentoring = Mentoring::where('mentee', '=', $request->mentee)->get();
        if ($request->mentor == $request->mentee) {
            $chatmentee = Chat::where('mentee', '=', $userloginedin->id)->where('mentor', '=',  $userloginedin->id)->get();
            $chattomentee = Chat::where('mentee', '=', $userloginedin->id)->where('mentor', '!=',  $userloginedin->id)->get();
        } else {
            $chatmentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '=',  $request->mentee)->get();
            $chattomentee = Chat::where('mentee', '=', $request->mentee)->where('mentor', '!=',  $request->mentee)->get();
        }


        $allchat1 = array();
        $allchat2 = array();
        $allchat = array();
        foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
        foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
        $allchat = array_merge($allchat1, $allchat2);
        arsort($allchat);

        return view('welcome', ['meetingrequests' => $meeting, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat,'documents' => $document]);
        /*/
        $development = new Development;
        $development = Development::find($request->Development_id);
        $development->Total_task += 1;
        $development->save();
/*/

        //       return redirect('/home');
    }
    //
}
