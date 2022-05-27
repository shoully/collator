<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Development;
use App\Models\MeetingRequest;
use App\Models\Activitie;
class MeetingRequestController extends Controller
{
public function store(Request $request)
    {
        $meetingrequest = new MeetingRequest;
        $meetingrequest->Text = empty($request->Text) ? 'nontitle' : $request->Text;
        $meetingrequest->save();
        $meetingrequest = MeetingRequest::latest()->get();
        $development = new Development;
        $development = Development::latest()->get();
        $activitie = new Activitie;
        $activitie = Activitie::latest()->get();
        return view('welcome', ['meetingrequests' => $meetingrequest,'developments' => $development,'activities' => $activitie,]);

     }

     public function remove(MeetingRequest $meetingrequest)
     {
         $meetingrequest->delete();
         $meetingrequest = MeetingRequest::latest()->get();
         $development = new Development;
         $development = Development::latest()->get();
          $activitie = new Activitie;
          $activitie = Activitie::latest()->get();
          return view('welcome', ['meetingrequests' => $meetingrequest,'developments' => $development,'activities' => $activitie,]);
     }
}
