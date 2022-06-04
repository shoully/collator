<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Mentoring;
use App\Models\MeetingRequest;
use App\Models\Activitie;
class HomeController extends Controller
{
  public function index()
    {
      //called model data
     
      $mentoring = new Mentoring;
      $mentoring = Mentoring::latest()->get();
   
      /*/
      $meetingrequest = new MeetingRequest;
      $meetingrequest = MeetingRequest::latest()->get();
      $activitie = new Activitie;
      $activitie = Activitie::latest()->get();
       /*/

      //define onces
      /*/
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
    /*/
    
    return view('welcome', ['meetingrequests' => $mentoring,'mentorings' => $mentoring,'activities' => $mentoring,]);
      }
	  
	  public function listoffollow()
    {
      
      
    return view('run');
      }
}
