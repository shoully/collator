<?php

namespace App\Http\Controllers;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Mentoring;
use App\Models\Task;
use App\Models\Chat;
use App\Models\Meeting;
class DocumentController extends Controller
{
    public function store(Request $request)
    {
        
        $request->validate([
            'document' => 'required|mimes:pdf,csv,xls,xlsx,doc,docx|max:2048',
        ]);

        //document->file
        $document = new Document;
        $document->title       = $request->title;
        $document->description = $request->description;
        $document->mentor = empty($request->mentor) ? '0' : $request->mentor;
        $document->mentee = empty($request->mentee) ? '0' : $request->mentee;
        $file = $request->file('document');
        
        $document->ext = $file->extension();;
        $document->filename = $file->getClientOriginalName();
        

        $fileName = time().$request->file('document')->getClientOriginalName();
        $request->document->move(public_path('storage/images'), $fileName);

        $document->document    = $fileName;
        $document->save();

        $document = Document::where('mentee', '=', $request->mentee)->get();
        $meeting = Meeting::where('mentee' , '=', $request->mentee)->get();
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
        $allchat  = array();
        foreach ($chatmentee as $key => $value) $allchat1[$key] = $value;
        foreach ($chattomentee as $key => $value) $allchat2[$key] = $value;
        $allchat = array_merge($allchat1, $allchat2);
        arsort($allchat);

        return view('welcome', ['meetingrequests' => $meeting, 'mentorings' => $mentoring, 'tasks' => $task, 'currentuser' => $userloginedin, 'mentee' => $mentee, 'chats' => $allchat,'documents' => $document]);
      
    }
}
