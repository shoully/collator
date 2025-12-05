<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mentoring;
use App\Models\Task;
use App\Models\Meeting;
use App\Models\Document;
use App\Models\User;
use App\Models\Project;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $projectId = $request->get('project_id');

        if ($user->type === 'Mentor') {
            if (!$projectId) {
                return redirect()->route('projects.select')
                    ->with('info', 'Please select a project to access the dashboard.');
            }

            $project = Project::find($projectId);
            if (!$project || $project->owner != $user->id) {
                return redirect()->route('projects.select')
                    ->with('error', 'Invalid project selected.');
            }

            $stats = [
                'mentees_count' => Mentoring::where('mentor', $user->id)->where('project_id', $project->id)->distinct('mentee')->count(),
                'mentorings_count' => Mentoring::where('mentor', $user->id)->where('project_id', $project->id)->count(),
                'tasks_count' => Task::where('mentor', $user->id)->where('project_id', $project->id)->count(),
                'pending_tasks' => Task::where('mentor', $user->id)->where('project_id', $project->id)->where('status', '!=', 'Done')->count(),
                'meetings_count' => Meeting::where('mentor', $user->id)->where('project_id', $project->id)->count(),
                'documents_count' => Document::where('mentor', $user->id)->where('project_id', $project->id)->count(),
                'projects_count' => Project::where('owner', $user->id)->count(),
            ];

            return view('mentor.dashboard', [
                'user' => $user,
                'stats' => $stats,
                'selectedProject' => $project,
            ]);
        }

        if ($user->type === 'Mentee') {
            if (!$projectId) {
                return redirect()->route('projects.select')
                    ->with('info', 'Please select a project to access the dashboard.');
            }

            $project = Project::find($projectId);
            if (!$project || ($project->mentee != $user->id && $project->mentee !== null)) {
                return redirect()->route('projects.select')
                    ->with('error', 'Invalid project selected.');
            }

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

        return redirect()->route('login');
    }
}
