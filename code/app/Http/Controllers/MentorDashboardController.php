<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Mentoring;
use App\Models\Task;
use App\Models\Meeting;
use App\Models\Document;
use App\Models\User;

class MentorDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || $user->type !== 'Mentor') {
            abort(403, 'Only mentors can access this dashboard');
        }

        // REQUIRE project selection
        $projectId = $request->get('project_id');
        if (!$projectId) {
            return redirect()->route('project.select')
                ->with('info', 'Please select a project to access the dashboard.');
        }

        $project = \App\Models\Project::find($projectId);
        if (!$project || $project->owner != $user->id) {
            return redirect()->route('project.select')
                ->with('error', 'Invalid project selected.');
        }

        // Get statistics for the mentor (filtered by project)
        $stats = [
            'mentees_count' => Mentoring::where('mentor', $user->id)->where('project_id', $project->id)->distinct('mentee')->count(),
            'mentorings_count' => Mentoring::where('mentor', $user->id)->where('project_id', $project->id)->count(),
            'tasks_count' => Task::where('mentor', $user->id)->where('project_id', $project->id)->count(),
            'pending_tasks' => Task::where('mentor', $user->id)->where('project_id', $project->id)->where('status', '!=', 'Done')->count(),
            'meetings_count' => Meeting::where('mentor', $user->id)->where('project_id', $project->id)->count(),
            'documents_count' => Document::where('mentor', $user->id)->where('project_id', $project->id)->count(),
            'projects_count' => \App\Models\Project::where('owner', $user->id)->count(),
        ];

        return view('mentor.dashboard', [
            'user' => $user,
            'stats' => $stats,
            'selectedProject' => $project,
        ]);
    }
}

