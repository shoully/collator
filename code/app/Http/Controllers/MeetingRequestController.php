<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeetingRequest;
class MeetingRequestController extends Controller
{
public function store(Request $request)
    {
        $meetingrequest = new MeetingRequest;
        $meetingrequest->Text = empty($request->Text) ? 'nontitle' : $request->Text;
        $meetingrequest->save();
        $meetingrequest = MeetingRequest::latest()->get();
        return view('welcome', ['meetingrequests' => $meetingrequest,]);

     }
}
