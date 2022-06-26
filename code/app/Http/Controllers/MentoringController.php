<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Mentoring;
use App\Models\Task;

class MentoringController extends Controller
{
  public function store(Request $request)
  {
    $mentoring = new Mentoring;
    $mentoring->title = empty($request->title) ? 'nontitle' : $request->title;
    $mentoring->mentor = empty($request->mentor) ? '0' : $request->mentor;
    $mentoring->mentee = empty($request->mentee) ? '0' : $request->mentee;
    $mentoring->save();

    return App::call('App\Http\Controllers\HomeController@afterandreturn', ['request' => $request]);
  }
  public function remove(Mentoring $mentoring, Request $request)
  {
    Task::where('mentoring_id', $mentoring->id)->delete();
    $mentoring->delete();
    return App::call('App\Http\Controllers\HomeController@afterandreturn', ['request' => $request]);
  }
}
