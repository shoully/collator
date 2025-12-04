<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display project selection page (required before accessing workspace)
     */
    public function select()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->type === 'Mentor') {
            // Mentors see all their projects
            $projects = Project::where('owner', $user->id)
                ->orderBy('project_date', 'desc')
                ->get();
        } elseif ($user->type === 'Mentee') {
            // Mentees see assigned projects and available projects
            $assignedProjects = Project::where('mentee', $user->id)
                ->orderBy('project_date', 'desc')
                ->get();
            
            // Get available projects
            $mentorIds = \App\Models\Mentoring::where('mentee', $user->id)->pluck('mentor')->toArray();
            
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
            
            $projects = $assignedProjects->merge($availableProjects)->sortByDesc('project_date')->values();
        } else {
            abort(403, 'Only mentors and mentees can access projects');
        }

        return view('projects.select', [
            'projects' => $projects,
            'user' => $user,
        ]);
    }

    /**
     * Display a listing of projects
     * Mentors see all their projects, Mentees see projects assigned to them
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403, 'You must be logged in to view projects');
        }

        if ($user->type === 'Mentor') {
            // Mentors see all projects they created
            $projects = Project::where('owner', $user->id)
                ->orderBy('project_date', 'desc')
                ->get();
        } elseif ($user->type === 'Mentee') {
            // Mentees see projects assigned to them AND available projects
            $assignedProjects = Project::where('mentee', $user->id)
                ->orderBy('project_date', 'desc')
                ->get();
            
            // Get available projects (not assigned to anyone and active)
            $mentorIds = \App\Models\Mentoring::where('mentee', $user->id)->pluck('mentor')->toArray();
            
            if (count($mentorIds) > 0) {
                // Show available projects from their mentors (active only)
                $availableProjects = Project::whereNull('mentee')
                    ->where('status', 'active')
                    ->whereIn('owner', $mentorIds)
                    ->orderBy('project_date', 'desc')
                    ->get();
            } else {
                // Show all available projects if no mentoring relationship (active only)
                $availableProjects = Project::whereNull('mentee')
                    ->where('status', 'active')
                    ->orderBy('project_date', 'desc')
                    ->get();
            }
            
            // Merge assigned and available projects
            $projects = $assignedProjects->merge($availableProjects)->sortByDesc('project_date')->values();
        } else {
            abort(403, 'Only mentors and mentees can view projects');
        }

        return view('projects.index', [
            'projects' => $projects,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new project
     */
    public function create()
    {
        $user = Auth::user();
        
        if (!$user || $user->type !== 'Mentor') {
            abort(403, 'Only mentors can create projects');
        }

        // Get all mentees - mentors can assign projects to any mentee
        // This allows mentors to create projects and start mentoring relationships
        $mentees = User::where('type', 'Mentee')
            ->orderBy('name')
            ->get();

        return view('projects.create', [
            'mentees' => $mentees,
            'user' => $user,
        ]);
    }

    /**
     * Store a newly created project
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || $user->type !== 'Mentor') {
            abort(403, 'Only mentors can create projects');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_date' => 'required|date',
            'file' => 'nullable|file|max:10240', // Max 10MB
            'mentee' => 'nullable|exists:users,id',
        ]);

        $file = null;
        $filename = null;

        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            
            if (!Storage::exists('projects')) {
                Storage::makeDirectory('projects');
            }
            
            $uploadedFile->storeAs('projects', $filename);
            $file = $filename;
        }

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description ?? '',
            'file' => $file,
            'filename' => $filename ?? $request->title,
            'owner' => $user->id,
            'project_date' => $request->project_date,
            'mentee' => $request->mentee ?? null,
            'status' => 'active',
        ]);

        // If a mentee was assigned, automatically create a mentoring relationship if it doesn't exist
        if ($request->mentee) {
            $menteeId = $request->mentee;
            $existingMentoring = \App\Models\Mentoring::where('mentor', $user->id)
                ->where('mentee', $menteeId)
                ->where('project_id', $project->id)
                ->first();
            
            if (!$existingMentoring) {
                // Create mentoring relationship linked to this project
                \App\Models\Mentoring::create([
                    'mentor' => $user->id,
                    'mentee' => $menteeId,
                    'project_id' => $project->id,
                ]);
            }
        }

        $successMessage = 'Project created successfully!';
        if ($request->mentee) {
            $menteeName = \App\Models\User::find($request->mentee)->name ?? 'the mentee';
            $successMessage .= ' ' . $menteeName . ' has been assigned and a mentoring relationship has been established.';
        }

        return redirect()->route('projects.index')
            ->with('success', $successMessage);
    }

    /**
     * Display the specified project
     */
    public function show(Project $project)
    {
        $user = Auth::user();
        
        // Authorization: Owner can always view, mentees can view if assigned or if it's available and they have mentoring relationship
        $canView = false;
        
        if ($user->id == $project->owner) {
            $canView = true;
        } elseif ($user->type === 'Mentee') {
            // Can view if assigned to them OR if it's available (active) and they have mentoring relationship with owner
            if ($project->mentee == $user->id) {
                $canView = true;
            } elseif ($project->mentee === null && $project->status === 'active') {
                // Check if they have mentoring relationship with the owner
                $hasMentoring = \App\Models\Mentoring::where('mentor', $project->owner)
                    ->where('mentee', $user->id)
                    ->exists();
                $canView = $hasMentoring;
            }
        }
        
        if (!$canView) {
            abort(403, 'You can only view projects you own, are assigned to, or available from your mentors');
        }

        return view('projects.show', [
            'project' => $project,
            'user' => $user,
        ]);
    }

    /**
     * Download project file
     */
    public function download(Project $project)
    {
        $user = Auth::user();
        
        // Authorization: Only the owner or assigned mentee can download
        if ($user->id != $project->owner && ($project->mentee && $user->id != $project->mentee)) {
            abort(403, 'You can only download projects you own or are assigned to');
        }

        if (!$project->file || !Storage::exists('projects/' . $project->file)) {
            abort(404, 'Project file not found');
        }

        return Storage::download('projects/' . $project->file, $project->filename);
    }

    /**
     * Remove the specified project
     */
    public function destroy(Project $project)
    {
        $user = Auth::user();
        
        // Authorization: Only the owner can delete
        if ($user->id != $project->owner) {
            abort(403, 'You can only delete your own projects');
        }

        // Delete file if exists
        if ($project->file && Storage::exists('projects/' . $project->file)) {
            Storage::delete('projects/' . $project->file);
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    /**
     * Request to join a project (for mentees)
     */
    public function requestJoin(Request $request, Project $project)
    {
        $user = Auth::user();
        
        if (!$user || $user->type !== 'Mentee') {
            abort(403, 'Only mentees can request to join projects');
        }

        // Check if project is available (not assigned to anyone)
        if ($project->mentee !== null) {
            return redirect()->back()
                ->with('error', 'This project is already assigned to another mentee.');
        }

        // Check if project is active (not completed or cancelled)
        if ($project->status !== 'active') {
            return redirect()->back()
                ->with('error', 'This project is not available for joining.');
        }

        // Check if mentee already has an active project
        $activeProject = Project::where('mentee', $user->id)
            ->where('status', 'active')
            ->first();
        
        if ($activeProject) {
            return redirect()->back()
                ->with('error', 'You can only join one project at a time. Please complete or leave your current project "' . $activeProject->title . '" before joining another one.');
        }

        // Check if mentee has a mentoring relationship with the project owner
        // If no mentoring relationships exist yet, allow joining any available project
        $mentorIds = \App\Models\Mentoring::where('mentee', $user->id)->pluck('mentor')->toArray();
        $hasMentoring = false;
        
        if (count($mentorIds) > 0) {
            // If mentee has mentors, check if project owner is one of them
            $hasMentoring = in_array($project->owner, $mentorIds);
            if (!$hasMentoring) {
                return redirect()->back()
                    ->with('error', 'You can only request to join projects from your mentors.');
            }
        }
        // If no mentoring relationships exist, allow joining any available project

        // Check if mentee is already assigned to this project
        if ($project->mentee == $user->id) {
            return redirect()->back()
                ->with('error', 'You are already assigned to this project.');
        }

        // Assign the project to the mentee
        $project->update([
            'mentee' => $user->id,
            'status' => 'active'
        ]);

        return redirect()->route('userDashboard')
            ->with('success', 'Successfully joined the project: ' . $project->title);
    }

    /**
     * Update project status (for mentors)
     */
    public function updateStatus(Request $request, Project $project)
    {
        $user = Auth::user();
        
        if (!$user || $user->type !== 'Mentor' || $user->id != $project->owner) {
            abort(403, 'Only the project owner can update project status');
        }

        $request->validate([
            'status' => 'required|in:active,completed,cancelled',
        ]);

        $oldStatus = $project->status;
        $newStatus = $request->status;
        
        $project->update(['status' => $newStatus]);

        $statusMessages = [
            'active' => 'Project marked as active.',
            'completed' => 'Project marked as completed. The mentee can now join another project.',
            'cancelled' => 'Project cancelled. The mentee can now join another project.',
        ];

        return redirect()->back()
            ->with('success', $statusMessages[$newStatus] ?? 'Project status updated successfully.');
    }
}
