<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Development;
use App\Models\MeetingRequest;

class DevelopmentController extends Controller
{
  public function store(Request $request)
    {
       /*/
        $validator = Validator::make($request->all(), [
            'Studentname1' => 'required|max:255',
        ]);
        /*/
        $development = new Development;
        $development->Title = empty($request->Title) ? 'nontitle' : $request->Title;
        $development->Completed_Activities = empty($request->Completed_Activities) ? '0' : $request->Completed_Activities;
        $development->Total_Activities = empty($request->Total_Activities) ? '0' : $request->Total_Activities;

        $development->save();
        $development = Development::latest()->get();
         $meetingrequest = new MeetingRequest;
          $meetingrequest = MeetingRequest::latest()->get();
       return view('welcome', ['meetingrequests' => $meetingrequest,'developments' => $development,]);
    }

}
