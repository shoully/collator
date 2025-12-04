<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Mentoring;
use App\Http\Controllers\HomeController;

class TaskController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'nullable|string',
      'mentoring_id' => 'nullable|exists:mentoring,id',
      'priority' => 'required|in:High,Medium,Low',
      'mentor' => 'required|exists:users,id',
      'mentee' => 'required|exists:users,id',
      'project_id' => 'nullable|exists:projects,id',
    ]);

    // Authorization: Only mentors can create tasks
    $user = Auth::user();
    if ($user->type !== 'Mentor' || $user->id != $request->mentor) {
      abort(403, 'Only mentors can create tasks');
    }

    // Validate that the mentee exists and is a mentee type
    $mentee = \App\Models\User::find($request->mentee);
    if (!$mentee) {
      abort(403, 'The selected mentee does not exist');
    }
    
    // Ensure mentee is not the same as mentor
    if ($request->mentee == $request->mentor) {
      abort(403, 'Invalid mentee selected: You cannot assign a task to yourself. Please select a mentee.');
    }
    
    if (trim($mentee->type) !== 'Mentee') {
      abort(403, 'Invalid mentee selected: The selected user is not a Mentee. Selected user type: ' . ($mentee->type ?? 'null'));
    }

    // If mentoring_id is provided, validate it belongs to the project
    // Tasks are project-based, so we validate the mentoring belongs to the project
    if ($request->mentoring_id) {
      $mentoring = Mentoring::find($request->mentoring_id);
      if (!$mentoring) {
        abort(404, 'Mentoring relationship not found');
      }
      
      // Validate that the mentoring belongs to the same project
      if ($request->project_id && $mentoring->project_id != $request->project_id) {
        abort(403, 'The mentoring relationship does not belong to this project');
      }
      
      // Validate that the mentoring belongs to the mentor (project owner)
      if ($mentoring->mentor != $request->mentor) {
        abort(403, 'The mentoring relationship does not belong to you');
      }
      
      // Note: We don't require mentoring->mentee to match request->mentee
      // because tasks are project-based and can be assigned to any mentee in the project
    }

    $task = Task::create([
      'title' => $request->title,
      'description' => $request->description ?? '',
      'mentoring_id' => $request->mentoring_id ?? null,
      'priority' => $request->priority,
      'status' => 'New',
      'mentor' => $request->mentor,
      'mentee' => $request->mentee,
      'project_id' => $request->project_id,
    ]);

    return (new HomeController)->afterandreturn($request);
  }

  public function remove(Task $task, Request $request)
  {
    $user = Auth::user();
    
    // Authorization: Only the mentor who created it can delete it
    if ($user->id != $task->mentor) {
      abort(403, 'You can only delete your own tasks');
    }

    $task->delete();
    return (new HomeController)->afterandreturn($request);
  }

  public function markdone(Task $task, Request $request)
  {
    $user = Auth::user();
    
    // Authorization: Only the mentee or mentor can mark tasks as done
    if ($user->id != $task->mentee && $user->id != $task->mentor) {
      abort(403, 'You can only mark tasks as done if you are the mentee or mentor');
    }

    $task->status = 'Done';
    $task->save();

    return (new HomeController)->afterandreturn($request);
  }
}
