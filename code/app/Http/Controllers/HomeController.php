<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Development;
use App\Models\MeetingRequest;

class HomeController extends Controller
{
  public function index()
    {
     $development = new Development;
  $development = Development::latest()->get();
   $meetingrequest = new MeetingRequest;
            $meetingrequest = MeetingRequest::latest()->get();
    return view('welcome', ['meetingrequests' => $meetingrequest,'developments' => $development,]);
    //
      }
}
