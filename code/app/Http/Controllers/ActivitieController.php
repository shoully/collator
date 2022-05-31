<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//models
use App\Models\Development;
use App\Models\Activitie;
class ActivitieController extends Controller
{
    public function store(Request $request)
    {
        $activitie = new Activitie;
        $activitie->Title = empty($request->Title) ? 'nontitle' : $request->Title;
        $activitie->Description = empty($request->Description) ? 'nondescription' : $request->Description;
        $activitie->Development_id = $request->Development_id;
        $activitie->Priorities = $request->Priorities;
        $activitie->Status = "New";
        $activitie->save();

        $development = new Development;
        $development = Development::find($request->Development_id);
        $development->Total_Activities += 1;

        $development->save();
       return redirect('/home');
    }
    public function remove(Activitie $activitie)
    {
        $development = new Development;
        $development = Development::find( $activitie->Development_id);
        //here added logic if the Activities is 
        //not new then -1 to the (Completed_Activities) as well
        $development->Total_Activities -= 1;
        $development->save();

        $activitie->delete();
      
       return redirect('/home');
    }
    public function markdone(Activitie $activitie)
    {
        $development = new Development;
        $development = Development::find( $activitie->Development_id);
        //here added logic if the Activities is 
        //not new then -1 to the (Completed_Activities) as well
        $development->Completed_Activities += 1;
        $development->save();

        $activitie->Status = "Done";
        $activitie->save();

       return redirect('/home');
    }
}
