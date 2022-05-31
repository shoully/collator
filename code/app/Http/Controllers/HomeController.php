<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Development;
use App\Models\MeetingRequest;
use App\Models\Activitie;
class HomeController extends Controller
{
  public function index()
    {
      //called model data
      $development = new Development;
      $development = Development::latest()->get();
      $meetingrequest = new MeetingRequest;
      $meetingrequest = MeetingRequest::latest()->get();
      $activitie = new Activitie;
      $activitie = Activitie::latest()->get();
      
      //define onces
      $percentagearray = array();
      foreach ($development as $key => $value) {
        $completed = $value['Completed_Activities']; 
        $total     = $value['Total_Activities']; 
        if ($total > 0 )
        {
          $percentage = ($completed/$total) * 100;
          $percentage = $percentage."%";
        }
        else
        $percentage = "0"."%";
      $theid = $value['id']; 
      $percentagearray[$theid]=$percentage;
    }
    
    return view('welcome', ['meetingrequests' => $meetingrequest,'developments' => $development,'activities' => $activitie,'calledper' =>$percentagearray,]);
      }
}
