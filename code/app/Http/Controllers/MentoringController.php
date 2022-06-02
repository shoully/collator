<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Mentoring;
use App\Models\Activitie;
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
        $mentoring->mentor = empty($request->mentor) ? '1' : $request->mentor;
        $mentoring->mentee = empty($request->mentee) ? '1' : $request->mentee;
       
        $mentoring->save();
          return redirect('/home');
    }
    public function remove(Mentoring $mentoring)
    {
       Activitie::where('mentoring_id', $mentoring->id)->delete();
        //check if there is related Activities
        $mentoring->delete();
         return redirect('/home');
    }

}
