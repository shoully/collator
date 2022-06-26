<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

        return App::call('App\Http\Controllers\HomeController@afterandreturn' , ['request' => $request]);
     }

     public function remove(Meeting $meeting , Request $request)
     {
         $meeting->delete();
         return App::call('App\Http\Controllers\HomeController@afterandreturn' , ['request' => $request]);
     }
}
