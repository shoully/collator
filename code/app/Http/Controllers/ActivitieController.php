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

        $development = new Development;
        $development = Development::find($request->Development_id);
        $development->Total_Activities += 1;

        $development->save();

        $activitie = Activitie::latest()->get();

        
        $development = Development::latest()->get();
        $meetingrequest = new MeetingRequest;
        $meetingrequest = MeetingRequest::latest()->get();
       return view('welcome', ['meetingrequests' => $meetingrequest,'developments' => $development,'activities' => $activitie,]);
    }
    public function remove(Activitie $activitie)
    {
        $development = new Development;
        $development = Development::find( $activitie->Development_id);
        //here added logic if the Activities is 
        //not new then -1 to the (Completed_Activities) as well
        $development->Total_Activities -= 1;
        $development->save();

        $activitie->delete();
        $activitie = Activitie::latest()->get();
        $development = new Development;
        $development = Development::latest()->get();
        $meetingrequest = new MeetingRequest;
        $meetingrequest = MeetingRequest::latest()->get();
       return view('welcome', ['meetingrequests' => $meetingrequest,'developments' => $development,'activities' => $activitie,]);
    }
}
