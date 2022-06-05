<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Mentoring;
use App\Models\MeetingRequest;
use App\Models\Activitie;
use App\Models\User;
class HomeController extends Controller
{
  public function index()
    {
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
      public function listofuser()
      {
        $user = new User;
        $user = User::where('type' , '=', "Mentee")->get();
      
        return view('welcometoclient', ['users' => $user,]);
        }
        public function fromlistofuser(User $user)
        {
          //called model data
         
          $mentoring = new Mentoring;
          $mentoring = Mentoring::where('mentee' , '=', $user->id)->get();

        return view('welcome', ['meetingrequests' => $mentoring,'mentorings' => $mentoring,'activities' => $mentoring,]);
          }
}
