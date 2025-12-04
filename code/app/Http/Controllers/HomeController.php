<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//models
use App\Models\Mentoring;
use App\Models\Document;
use App\Models\Task;
use App\Models\User;
use App\Models\Chat;
use App\Models\Meeting;
use App\Models\Project;

class HomeController extends Controller
{
  public function index(Request $request)
  {
    $userloginedin = Auth::user();

    if (!$userloginedin) {
      return redirect()->route('login');
    }

    // Use the logged-in user as the mentee
    $mentee = $userloginedin;

    // Get selected project ID from request
    $projectId = $request->get('project_id');

    // Get all projects available to this user
    if ($userloginedin->type === 'Mentor') {
      $availableProjects = Project::where('owner', $userloginedin->id)
          ->orderBy('project_date', 'desc')
          ->get();
    } else {
      $assignedProjects = Project::where('mentee', $mentee->id)
          ->orderBy('project_date', 'desc')
          ->get();
      
      $mentorIds = Mentoring::where('mentee', $mentee->id)->pluck('mentor')->toArray();
      
      if (count($mentorIds) > 0) {
        $availableProjectsFromMentors = Project::whereNull('mentee')
            ->whereIn('owner', $mentorIds)
            ->orderBy('project_date', 'desc')
            ->get();
      } else {
        $availableProjectsFromMentors = Project::whereNull('mentee')
            ->orderBy('project_date', 'desc')
            ->get();
      }
      
      $availableProjects = $assignedProjects->merge($availableProjectsFromMentors)->sortByDesc('project_date')->values();
    }

    // Get selected project
    $selectedProject = null;
    if ($projectId) {
      $selectedProject = Project::find($projectId);
      // Verify user has access to this project
      if ($selectedProject) {
        if ($userloginedin->type === 'Mentor' && $selectedProject->owner != $userloginedin->id) {
          $selectedProject = null;
        } elseif ($userloginedin->type === 'Mentee' && $selectedProject->mentee != $mentee->id && $selectedProject->mentee != null) {
          // Check if it's from their mentor
          $mentorIds = Mentoring::where('mentee', $mentee->id)->pluck('mentor')->toArray();
          if (!in_array($selectedProject->owner, $mentorIds) && $selectedProject->mentee != null) {
            $selectedProject = null;
          }
        }
      }
    }

    // REQUIRE project selection - redirect to project selection if no project selected
    if (!$selectedProject) {
      return redirect()->route('project.select')
          ->with('info', 'Please select a project to access the workspace.');
    }

    // Get all data filtered by project (project is required)
    // Anyone with access to the project can see all items in that project
    if ($userloginedin->type === 'Mentor') {
      // Mentors see all items in their projects
      $queryTask = Task::where('project_id', $selectedProject->id);
      $queryDocument = Document::where('project_id', $selectedProject->id);
      $queryMentoring = Mentoring::where('project_id', $selectedProject->id);
      $queryMeeting = Meeting::where('project_id', $selectedProject->id);
      $queryChat = Chat::where('project_id', $selectedProject->id);
    } else {
      // Mentees see all items in projects they have access to
      // For tasks/meetings: show items where they are the mentee OR where project is general
      $queryTask = Task::where('project_id', $selectedProject->id)
          ->where(function($q) use ($mentee) {
              $q->where('mentee', $mentee->id)
                ->orWhereNull('mentee'); // General tasks
          });
      $queryDocument = Document::where('project_id', $selectedProject->id);
      $queryMentoring = Mentoring::where('project_id', $selectedProject->id);
      $queryMeeting = Meeting::where('project_id', $selectedProject->id)
          ->where(function($q) use ($mentee) {
              $q->where('mentee', $mentee->id)
                ->orWhereNull('mentee'); // General meetings
          });
      // Mentees see ALL chats in the project, not just their own
      $queryChat = Chat::where('project_id', $selectedProject->id);
    }

    $task = $queryTask->get();
    $document = $queryDocument->get();
    $mentoring = $queryMentoring->get();
    $meeting = $queryMeeting->get();
    $chats = $queryChat->orderBy('created_at', 'desc')->get();
    
    // Get the mentor for display (first mentoring relationship's mentor)
    $mentor = null;
    if ($mentoring->isNotEmpty()) {
      $mentor = User::find($mentoring->first()->mentor);
    } elseif ($userloginedin->type === 'Mentor') {
      // If user is a mentor viewing their own page, show themselves
      $mentor = $userloginedin;
    }
    
    return view('welcome', [
      'meetingrequests' => $meeting,
      'mentorings' => $mentoring,
      'tasks' => $task,
      'currentuser' => $userloginedin,
      'mentee' => $mentee,
      'mentor' => $mentor,
      'chats' => $chats,
      'documents' => $document,
      'projects' => $availableProjects ?? collect(),
      'selectedProject' => $selectedProject,
    ]);
  }
  public function listofuser()
  {
    $userloginedin = Auth::user();
    
    if (!$userloginedin) {
      return redirect()->route('login');
    }

    // Authorization: Only mentors can view the list of mentees
    if ($userloginedin->type !== 'Mentor') {
      abort(403, 'Only mentors can view the list of mentees');
    }

    // Get mentees that this mentor is mentoring
    $menteeIds = Mentoring::where('mentor', $userloginedin->id)
        ->pluck('mentee')
        ->toArray();
    
    // If mentor has mentees, show only those. Otherwise, show all mentees for initial setup
    if (count($menteeIds) > 0) {
      $users = User::where('type', 'Mentee')
          ->whereIn('id', $menteeIds)
          ->get();
    } else {
      // Show all mentees if no relationships exist yet (for initial setup)
      $users = User::where('type', 'Mentee')->get();
    }
    
    return view('welcometoclient', [
      'users' => $users,
      'hasMentorings' => count($menteeIds) > 0,
    ]);
  }

  public function fromlistofuser(Request $request, User $user)
  {
    $userloginedin = Auth::user();
    
    if (!$userloginedin) {
      return redirect()->route('login');
    }

    $mentee = $user;
    
    // Authorization: Verify the current user has a mentoring relationship with this mentee
    // If user is a mentor, they can only view mentees they mentor
    // If user is a mentee, they can only view their own data
    if ($userloginedin->type === 'Mentor') {
      $hasRelationship = Mentoring::where('mentor', $userloginedin->id)
          ->where('mentee', $mentee->id)
          ->exists();
      
      if (!$hasRelationship) {
        abort(403, 'You can only view mentees you are mentoring');
      }
    } elseif ($userloginedin->type === 'Mentee') {
      if ($userloginedin->id != $mentee->id) {
        abort(403, 'You can only view your own data');
      }
    }
    
    // Get selected project ID from request
    $projectId = $request->get('project_id');

    // Get all projects available to this user
    if ($userloginedin->type === 'Mentor') {
      $availableProjects = Project::where('owner', $userloginedin->id)
          ->orderBy('project_date', 'desc')
          ->get();
    } else {
      $assignedProjects = Project::where('mentee', $mentee->id)
          ->orderBy('project_date', 'desc')
          ->get();
      
      $mentorIds = Mentoring::where('mentee', $mentee->id)->pluck('mentor')->toArray();
      
      if (count($mentorIds) > 0) {
        $availableProjectsFromMentors = Project::whereNull('mentee')
            ->where('status', 'active')
            ->whereIn('owner', $mentorIds)
            ->orderBy('project_date', 'desc')
            ->get();
      } else {
        $availableProjectsFromMentors = Project::whereNull('mentee')
            ->where('status', 'active')
            ->orderBy('project_date', 'desc')
            ->get();
      }
      
      $availableProjects = $assignedProjects->merge($availableProjectsFromMentors)->sortByDesc('project_date')->values();
    }

    // Get selected project
    $selectedProject = null;
    if ($projectId) {
      $selectedProject = Project::find($projectId);
      // Verify user has access to this project
      if ($selectedProject) {
        if ($userloginedin->type === 'Mentor' && $selectedProject->owner != $userloginedin->id) {
          $selectedProject = null;
        } elseif ($userloginedin->type === 'Mentee' && $selectedProject->mentee != $mentee->id && $selectedProject->mentee != null) {
          $mentorIds = Mentoring::where('mentee', $mentee->id)->pluck('mentor')->toArray();
          if (!in_array($selectedProject->owner, $mentorIds) && $selectedProject->mentee != null) {
            $selectedProject = null;
          }
        }
      }
    }

    // REQUIRE project selection - redirect to project selection if no project selected
    if (!$selectedProject) {
      return redirect()->route('project.select')
          ->with('info', 'Please select a project to access the workspace.');
    }

    // Get all data filtered by project (project is required)
    // Anyone with access to the project can see all items in that project
    if ($userloginedin->type === 'Mentor') {
      // Mentors see all items in their projects
      $queryTask = Task::where('project_id', $selectedProject->id);
      $queryDocument = Document::where('project_id', $selectedProject->id);
      $queryMentoring = Mentoring::where('project_id', $selectedProject->id);
      $queryMeeting = Meeting::where('project_id', $selectedProject->id);
      $queryChat = Chat::where('project_id', $selectedProject->id);
    } else {
      // Mentees see all items in projects they have access to
      // For tasks/meetings: show items where they are the mentee OR where project is general
      $queryTask = Task::where('project_id', $selectedProject->id)
          ->where(function($q) use ($mentee) {
              $q->where('mentee', $mentee->id)
                ->orWhereNull('mentee'); // General tasks
          });
      $queryDocument = Document::where('project_id', $selectedProject->id);
      $queryMentoring = Mentoring::where('project_id', $selectedProject->id);
      $queryMeeting = Meeting::where('project_id', $selectedProject->id)
          ->where(function($q) use ($mentee) {
              $q->where('mentee', $mentee->id)
                ->orWhereNull('mentee'); // General meetings
          });
      // Mentees see ALL chats in the project, not just their own
      $queryChat = Chat::where('project_id', $selectedProject->id);
    }

    $task = $queryTask->get();
    $document = $queryDocument->get();
    $mentoring = $queryMentoring->get();
    $meeting = $queryMeeting->get();
    $chats = $queryChat->orderBy('created_at', 'desc')->get();

    // Get the mentor for display (first mentoring relationship's mentor)
    $mentor = null;
    if ($mentoring->isNotEmpty()) {
      $mentor = User::find($mentoring->first()->mentor);
    } elseif ($userloginedin->type === 'Mentor') {
      // If user is a mentor viewing their own page, show themselves
      $mentor = $userloginedin;
    }

    return view('welcome', [
      'meetingrequests' => $meeting,
      'mentorings' => $mentoring,
      'tasks' => $task,
      'currentuser' => $userloginedin,
      'mentee' => $mentee,
      'mentor' => $mentor,
      'chats' => $chats,
      'documents' => $document,
      'projects' => $availableProjects ?? collect(),
      'selectedProject' => $selectedProject,
    ]);
  }

  public function afterandreturn(Request $request)
  {
    $userloginedin = Auth::user();
    
    if (!$userloginedin) {
      return redirect()->route('login');
    }

    $mentee = User::find($request->mentee);
    
    if (!$mentee) {
      abort(404, 'Mentee not found');
    }

    // Get selected project ID from request
    $projectId = $request->get('project_id');
    
    // Authorization: For project-based tasks, validate project access instead of mentoring relationships
    if ($userloginedin->type === 'Mentor') {
      // If project_id is provided, validate the mentor owns the project and mentee has access
      if ($projectId) {
        $project = Project::find($projectId);
        if (!$project || $project->owner != $userloginedin->id) {
          abort(403, 'You can only create tasks in your own projects');
        }
        
        // Check if mentee has access to this project:
        // 1. Project has no specific mentee (general project) - any mentee allowed
        // 2. Project is assigned to this mentee
        // 3. Mentee has a mentoring relationship with the mentor in this project
        $hasAccess = false;
        
        if (!$project->mentee) {
          // General project - any mentee is allowed
          $hasAccess = true;
        } elseif ($project->mentee == $mentee->id) {
          // Project is assigned to this mentee
          $hasAccess = true;
        } else {
          // Check if mentee has mentoring relationship with mentor in this project
          $hasMentoringInProject = Mentoring::where('project_id', $projectId)
              ->where('mentor', $userloginedin->id)
              ->where('mentee', $mentee->id)
              ->exists();
          $hasAccess = $hasMentoringInProject;
        }
        
        if (!$hasAccess) {
          abort(403, 'The selected mentee does not have access to this project');
        }
      } else {
        // If no project, fall back to mentoring relationship check
        $hasRelationship = Mentoring::where('mentor', $userloginedin->id)
            ->where('mentee', $mentee->id)
            ->exists();
        
        if (!$hasRelationship) {
          abort(403, 'You can only view mentees you are mentoring');
        }
      }
    } elseif ($userloginedin->type === 'Mentee') {
      if ($userloginedin->id != $mentee->id) {
        abort(403, 'You can only view your own data');
      }
    }

    // Get all projects available to this user
    if ($userloginedin->type === 'Mentor') {
      $availableProjects = Project::where('owner', $userloginedin->id)
          ->orderBy('project_date', 'desc')
          ->get();
    } else {
      $assignedProjects = Project::where('mentee', $mentee->id)
          ->orderBy('project_date', 'desc')
          ->get();
      
      $mentorIds = Mentoring::where('mentee', $mentee->id)->pluck('mentor')->toArray();
      
      if (count($mentorIds) > 0) {
        $availableProjectsFromMentors = Project::whereNull('mentee')
            ->whereIn('owner', $mentorIds)
            ->orderBy('project_date', 'desc')
            ->get();
      } else {
        $availableProjectsFromMentors = Project::whereNull('mentee')
            ->orderBy('project_date', 'desc')
            ->get();
      }
      
      $availableProjects = $assignedProjects->merge($availableProjectsFromMentors)->sortByDesc('project_date')->values();
    }

    // Get selected project
    $selectedProject = null;
    if ($projectId) {
      $selectedProject = Project::find($projectId);
      // Verify user has access to this project
      if ($selectedProject) {
        if ($userloginedin->type === 'Mentor' && $selectedProject->owner != $userloginedin->id) {
          $selectedProject = null;
        } elseif ($userloginedin->type === 'Mentee' && $selectedProject->mentee != $mentee->id && $selectedProject->mentee != null) {
          $mentorIds = Mentoring::where('mentee', $mentee->id)->pluck('mentor')->toArray();
          if (!in_array($selectedProject->owner, $mentorIds) && $selectedProject->mentee != null) {
            $selectedProject = null;
          }
        }
      }
    }

    // REQUIRE project selection - redirect to project selection if no project selected
    if (!$selectedProject) {
      return redirect()->route('project.select')
          ->with('info', 'Please select a project to access the workspace.');
    }

    // Get all data filtered by project (project is required)
    // Anyone with access to the project can see all items in that project
    if ($userloginedin->type === 'Mentor') {
      // Mentors see all items in their projects
      $queryTask = Task::where('project_id', $selectedProject->id);
      $queryDocument = Document::where('project_id', $selectedProject->id);
      $queryMentoring = Mentoring::where('project_id', $selectedProject->id);
      $queryMeeting = Meeting::where('project_id', $selectedProject->id);
      $queryChat = Chat::where('project_id', $selectedProject->id);
    } else {
      // Mentees see all items in projects they have access to
      // For tasks/meetings: show items where they are the mentee OR where project is general
      $queryTask = Task::where('project_id', $selectedProject->id)
          ->where(function($q) use ($mentee) {
              $q->where('mentee', $mentee->id)
                ->orWhereNull('mentee'); // General tasks
          });
      $queryDocument = Document::where('project_id', $selectedProject->id);
      $queryMentoring = Mentoring::where('project_id', $selectedProject->id);
      $queryMeeting = Meeting::where('project_id', $selectedProject->id)
          ->where(function($q) use ($mentee) {
              $q->where('mentee', $mentee->id)
                ->orWhereNull('mentee'); // General meetings
          });
      // Mentees see ALL chats in the project, not just their own
      $queryChat = Chat::where('project_id', $selectedProject->id);
    }

    $task = $queryTask->get();
    $document = $queryDocument->get();
    $mentoring = $queryMentoring->get();
    $meeting = $queryMeeting->get();
    $chats = $queryChat->orderBy('created_at', 'desc')->get();

    // Get the mentor for display (first mentoring relationship's mentor)
    $mentor = null;
    if ($mentoring->isNotEmpty()) {
      $mentor = User::find($mentoring->first()->mentor);
    } elseif ($userloginedin->type === 'Mentor') {
      // If user is a mentor viewing their own page, show themselves
      $mentor = $userloginedin;
    }

    return view('welcome', [
      'meetingrequests' => $meeting,
      'mentorings' => $mentoring,
      'tasks' => $task,
      'currentuser' => $userloginedin,
      'mentee' => $mentee,
      'mentor' => $mentor,
      'chats' => $chats,
      'documents' => $document,
      'projects' => $availableProjects ?? collect(),
      'selectedProject' => $selectedProject,
    ]);
  }
}
