<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//models
use App\Models\Mentoring;
use App\Models\Activitie;
use App\Models\User;
class MentoringController extends Controller
{
  public function store(Request $request)
    {
       /*/
        $validator = Validator::make($request->all(), [
            'Studentname1' => 'required|max:255',
        ]);
        /*/
        $mentoring = new Mentoring;
        $mentoring->title = empty($request->title) ? 'nontitle' : $request->title;
        $mentoring->mentor = empty($request->mentor) ? '0' : $request->mentor;
        $mentoring->mentee = empty($request->mentee) ? '0' : $request->mentee;
       
        $mentoring->save();

         
        $menteefind = new User;
        $menteefind = User::where('id' , '=', $request->mentee)->take(1)->get();
        $mentee = $menteefind[0];
        
        $userloginedin = Auth::user();
        $mentoring = new Mentoring;
        $mentoring = Mentoring::where('mentee' , '=', $request->mentee)->get();

          return view('welcome', ['meetingrequests' => $mentoring,'mentorings' => $mentoring,'activities' => $mentoring,'currentuser' => $userloginedin,'mentee'=>$mentee,]);
          //return redirect('/home');
    }
    public function remove(Mentoring $mentoring,Request $request)
    {
      // Activitie::where('mentoring_id', $mentoring->id)->delete();
        //check if there is related Activities
        $mentoring->delete();

        $menteefind = new User;
        $menteefind = User::where('id' , '=', $request->mentee)->take(1)->get();
        $mentee = $menteefind[0];
        
        $userloginedin = Auth::user();
        $mentoring = new Mentoring;
        $mentoring = Mentoring::where('mentee' , '=', $request->mentee)->get();

          return view('welcome', ['meetingrequests' => $mentoring,'mentorings' => $mentoring,'activities' => $mentoring,'currentuser' => $userloginedin,'mentee'=>$mentee,]);
         //return redirect('/home');
    }

}
