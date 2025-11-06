<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Mentoring;
use App\Models\Task;
use App\Models\Meeting;
use App\Models\Document;
use App\Models\Project;
use App\Models\User;

class MenteeDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || $user->type !== 'Mentee') {
            abort(403, 'Only mentees can access this dashboard');
        }

        // REQUIRE project selection
        $projectId = $request->get('project_id');
        if (!$projectId) {
            return redirect()->route('project.select')
                ->with('info', 'Please select a project to access the dashboard.');
        }

        $project = Project::find($projectId);
        if (!$project || ($project->mentee != $user->id && $project->mentee !== null)) {
            return redirect()->route('project.select')
                ->with('error', 'Invalid project selected.');
        }

        // Get statistics for the mentee (filtered by project)
        $stats = [
            'mentors_count' => Mentoring::where('mentee', $user->id)->where('project_id', $project->id)->distinct('mentor')->count(),
            'mentorings_count' => Mentoring::where('mentee', $user->id)->where('project_id', $project->id)->count(),
            'tasks_count' => Task::where('mentee', $user->id)->where('project_id', $project->id)->count(),
            'pending_tasks' => Task::where('mentee', $user->id)->where('project_id', $project->id)->where('status', '!=', 'Done')->count(),
            'completed_tasks' => Task::where('mentee', $user->id)->where('project_id', $project->id)->where('status', 'Done')->count(),
            'meetings_count' => Meeting::where('mentee', $user->id)->where('project_id', $project->id)->count(),
            'documents_count' => Document::where('mentee', $user->id)->where('project_id', $project->id)->count(),
            'projects_count' => Project::where('mentee', $user->id)->count(),
        ];

        // Get available projects for display
        $mentorIds = Mentoring::where('mentee', $user->id)->pluck('mentor')->toArray();
        if (count($mentorIds) > 0) {
            $availableProjects = Project::whereNull('mentee')
                ->where('status', 'active')
                ->whereIn('owner', $mentorIds)
                ->orderBy('project_date', 'desc')
                ->get();
        } else {
            $availableProjects = Project::whereNull('mentee')
                ->where('status', 'active')
                ->orderBy('project_date', 'desc')
                ->get();
        }

        return view('mentee.dashboard', [
            'user' => $user,
            'stats' => $stats,
            'availableProjects' => $availableProjects,
            'selectedProject' => $project,
        ]);
    }
}

