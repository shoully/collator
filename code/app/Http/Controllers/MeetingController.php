<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Meeting;

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
     
        return redirect('/home');

     }

     public function remove(Meeting $meeting)
     {
         $meeting->delete();
        
          return redirect('/home');
     }
}
