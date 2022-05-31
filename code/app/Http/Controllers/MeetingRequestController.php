<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\MeetingRequest;

class MeetingRequestController extends Controller
{
public function store(Request $request)
    {
        $meetingrequest = new MeetingRequest;
        $meetingrequest->Text = empty($request->Text) ? 'nontitle' : $request->Text;
        $meetingrequest->save();
     
        return redirect('/home');

     }

     public function remove(MeetingRequest $meetingrequest)
     {
         $meetingrequest->delete();
        
          return redirect('/home');
     }
}
