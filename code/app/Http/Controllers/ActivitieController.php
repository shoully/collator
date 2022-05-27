<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Development;
use App\Models\MeetingRequest;
use App\Models\Activitie;
class ActivitieController extends Controller
{
    public function store(Request $request)
    {

       /*/
        $validator = Validator::make($request->all(), [
            'Studentname1' => 'required|max:255',
        ]);
        /*/
        $activitie = new Activitie;
        $activitie->Title = empty($request->Title) ? 'nontitle' : $request->Title;
        $activitie->Description = empty($request->Description) ? 'nondescription' : $request->Description;
        $activitie->Development_id = $request->Development_id;
        $activitie->Priorities = $request->Priorities;
        $activitie->Status = "New";
        $activitie->save();
       
        $activitie = Activitie::latest()->get();

        $development = new Development;
        $development = Development::latest()->get();
         $meetingrequest = new MeetingRequest;
          $meetingrequest = MeetingRequest::latest()->get();
       return view('welcome', ['meetingrequests' => $meetingrequest,'developments' => $development,'activities' => $activitie,]);
    }
    public function remove(Activitie $activitie)
    {
        $activitie->delete();
        $activitie = Activitie::latest()->get();
        $development = new Development;
        $development = Development::latest()->get();
         $meetingrequest = new MeetingRequest;
          $meetingrequest = MeetingRequest::latest()->get();
       return view('welcome', ['meetingrequests' => $meetingrequest,'developments' => $development,'activities' => $activitie,]);
    }
}
