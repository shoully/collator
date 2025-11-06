<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mentoring;
use App\Models\Task;
use App\Http\Controllers\HomeController;

class MentoringController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'mentor' => 'required|exists:users,id',
      'mentee' => 'required|exists:users,id',
      'project_id' => 'nullable|exists:projects,id',
    ]);

    // Authorization: Only mentors can create mentorings, and they must be the mentor
    $user = Auth::user();
    if ($user->type !== 'Mentor' || $user->id != $request->mentor) {
      abort(403, 'Only mentors can create mentorings for themselves');
    }

    $mentoring = Mentoring::create([
      'title' => $request->title,
      'mentor' => $request->mentor,
      'mentee' => $request->mentee,
      'project_id' => $request->project_id,
    ]);

    return (new HomeController)->afterandreturn($request);
  }

  public function remove(Mentoring $mentoring, Request $request)
  {
    $user = Auth::user();
    
    // Authorization: Only the mentor who created it can delete it
    if ($user->id != $mentoring->mentor) {
      abort(403, 'You can only delete your own mentorings');
    }

    // Delete associated tasks
    Task::where('mentoring_id', $mentoring->id)->delete();
    $mentoring->delete();

    return (new HomeController)->afterandreturn($request);
  }
}
