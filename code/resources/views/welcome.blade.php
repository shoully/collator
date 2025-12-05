@php
function Prioritiespill($whichone) {
    if ($whichone == 'Low') //1
    echo "<span class='badge rounded-pill bg-success'>Low</span>";
    if ($whichone == 'Medium') //3
    echo "<span class='badge rounded-pill bg-warning text-dark'>Medium</span>";
    if ($whichone == 'High') //5
    echo "<span class='badge rounded-pill bg-danger'>High</span>";
}
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="{{asset('css/collator.css')}}">
    <title>Workspace - Collator</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-cubes me-2"></i><strong>Collator</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard', ['project_id' => $selectedProject->id ?? '']) }}">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.select') }}">
                            <i class="fas fa-exchange-alt me-1"></i>Change Project
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="project-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">
                        @if(isset($selectedProject) && $selectedProject)
                            {{ $selectedProject->title }}
                        @else
                            Workspace
                        @endif
                    </h2>
                    <p class="mb-0">
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-user-tie me-1"></i>
                            Mentor: @if(isset($mentor) && $mentor){{ $mentor->name }}@else{{ $currentuser->type === 'Mentor' ? $currentuser->name : 'Not Assigned' }}@endif
                        </span>
                        <span class="badge bg-light text-dark ms-2">
                            <i class="fas fa-user me-1"></i>
                            Mentee: {{ $mentee->name }}
                        </span>
                    </p>
                </div>
                <div>
                    @if(isset($projects) && $projects->count() > 0)
                        <form method="GET" action="{{ route('workspace') }}" class="d-inline">
                            <select name="project_id" class="form-select" onchange="this.form.submit()">
                                <option value="">Select a Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ (isset($selectedProject) && $selectedProject && $selectedProject->id == $project->id) ? 'selected' : '' }}>
                                        {{ $project->title }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    @endif
                </div>
            </div>
            <div class="d-flex align-items-center mt-3">
                <small class="me-3"><i class="fas fa-calendar-alt me-1"></i>Mentoring Cycle: 90 days</small>
                <div class="progress flex-grow-1" style="max-width: 300px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Areas to Develop</span>
                        @if ($currentuser->type == "Mentor")
                            <button
                            id="BtnAreatoDevelop"
                            class="btn btn-primary btn-sm"
                            onclick="show_my_receipt()"
                            type="button"><i class="fas fa-plus"></i></button>
                            @else
                            <button
                            id="BtnAreatoDevelop"
                            class="btn btn-primary btn-sm"
                            onclick="show_my_receipt()"
                            disabled
                            type="button"><i class="fas fa-plus"></i></button>
                            @endif
                    </div>
                    <ul class="list-group list-group-flush">
                    @if (isset($mentorings)) 
                    @foreach ($mentorings as $mentoring)
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <strong>{{ ($mentoring->title) }}</strong>
                                @if($currentuser->type == "Mentor" && $mentoring->menteeUser)
                                    <small class="text-muted d-block">
                                        <i class="fas fa-user me-1"></i>For: {{ $mentoring->menteeUser->name }}
                                    </small>
                                @elseif($currentuser->type == "Mentee" && $mentoring->mentorUser)
                                    <small class="text-muted d-block">
                                        <i class="fas fa-user-tie me-1"></i>With: {{ $mentoring->mentorUser->name }}
                                    </small>
                                @endif
                            </div>
                            @if ($currentuser->type == "Mentor")
                                <form class="ms-2" action="{{ route('mentorings.destroy', $mentoring->id) }}" method="post">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="mentee" value="{{ $mentoring->mentee ?? $mentee->id }}">
                                    <input type="hidden" name="mentor" value="{{ $currentuser->id }}">
                                    <button type="submit" name="x" class="btn btn-danger btn-sm">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    {{ csrf_field() }}
                                </form>
                            @endif
                        </div>
                        <div class="progress mt-2">
                            <div
                            class="progress-bar"
                            role="progressbar"
                            style="width:0%"
                            aria-valuenow="25"
                            aria-valuemin="0"
                            aria-valuemax="100"></div>
                        </div>
                    </li>
                @endforeach
                
                    @endif
                
                
                    
            </ul>

        </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Tasks</span>
                    @if ($currentuser->type == "Mentor")
                        <button id="BtnAddActivity" class="btn btn-primary btn-sm" type="button"><i class="fas fa-plus"></i></button>
                        @else
                        <button id="BtnAddActivity" disabled class="btn btn-primary btn-sm" type="button"><i class="fas fa-plus"></i></button>
                    @endif

                </div>
                <ul class="list-group list-group-flush">
                    @if (isset($tasks)) @foreach ($tasks as $task)

                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <strong>{{ ($task->title) }}</strong>
                                {{ Prioritiespill($task->priority) }}
                                @if($currentuser->type == "Mentor" && $task->mentee)
                                    <small class="text-muted d-block">
                                        <i class="fas fa-user me-1"></i>Assigned to: {{ $task->menteeUser->name ?? 'Mentee' }}
                                    </small>
                                @endif
                                @if($task->description)
                                    <small class="text-muted d-block mt-1">
                                        {{ Str::limit($task->description, 100) }}
                                    </small>
                                @endif
                                @if($task->status == "Done")
                                    <span class="badge bg-success mt-1">Completed</span>
                                @else
                                    <span class="badge bg-warning text-dark mt-1">{{ $task->status }}</span>
                                @endif
                            </div>
                            <div class="ms-2">
                                @if($task->status != "Done" && $currentuser->type == "Mentee" && $task->mentee == $currentuser->id)
                                    <form class="d-inline" action="{{ route('tasks.update', $task->id) }}" method="post">
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="mentee" value="{{ $task->mentee }}">
                                        <input type="hidden" name="mentor" value="{{ $task->mentor }}">
                                        @if(isset($selectedProject) && $selectedProject)
                                        <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">
                                        @endif
                                        <button type="submit" name="Done" class="btn btn-warning btn-sm">
                                            <i class="fas fa-check me-1"></i>Mark Done
                                        </button>
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                                @if ($currentuser->type == "Mentor" && $task->mentor == $currentuser->id)
                                    <form class="d-inline" action="{{ route('tasks.destroy', $task->id) }}" method="post">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="mentee" value="{{ $task->mentee }}">
                                        <input type="hidden" name="mentor" value="{{ $currentuser->id }}">
                                        @if(isset($selectedProject) && $selectedProject)
                                        <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">
                                        @endif
                                        <button type="submit" name="x" class="btn btn-danger btn-sm" title="Delete task">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                            </div>
                        </div>
                    </li>

                    @endforeach
                    
                    @endif

                
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Documents</span>
                        <button id="BtnAddProject" class="btn btn-primary btn-sm" type="button"><i class="fas fa-plus"></i></button>

                </div>
                <ul class="list-group list-group-flush">
                    @if (isset($documents))
                    @foreach ($documents as $document )
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ route('documents.download', $document) }}" class="text-decoration-none">
                                <i class="fas fa-file me-1"></i>{{ $document->filename }}
                            </a>
                            @if($currentuser->type == "Mentor" && $document->menteeUser)
                                <small class="text-muted d-block">
                                    <i class="fas fa-user me-1"></i>Shared with: {{ $document->menteeUser->name }}
                                </small>
                            @endif
                        </div>
                        <small class="text-muted">{{ $document->created_at->format('M d') }}</small>
                    </div>
                </li>
                    @endforeach
                @endif
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Projects</span>
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
                <ul class="list-group list-group-flush">
                    @if (isset($projects) && $projects->count() > 0)
                        @foreach ($projects->take(5) as $project)
                            <li class="list-group-item">
                                <a href="{{ route('projects.show', $project) }}" class="text-decoration-none">
                                    <i class="fas fa-folder me-1"></i>{{ Str::limit($project->title, 20) }}
                                </a>
                                @if($currentuser->type === 'Mentee')
                                    @if($project->mentee == $currentuser->id)
                                        <span class="badge bg-success float-end">Assigned</span>
                                    @else
                                        <span class="badge bg-warning text-dark float-end">Available</span>
                                    @endif
                                @else
                                    @if($project->mentee)
                                        <small class="text-muted float-end">{{ $project->menteeUser->name ?? 'N/A' }}</small>
                                    @else
                                        <span class="badge bg-secondary float-end">General</span>
                                    @endif
                                @endif
                            </li>
                        @endforeach
                        @if($projects->count() > 5)
                            <li class="list-group-item text-center">
                                <a href="{{ route('projects.index') }}" class="text-decoration-none">
                                    View All ({{ $projects->count() }})
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="list-group-item text-center text-muted">
                            <small>No projects yet</small>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Live Chat</span>
                        <button id="BtnLiveChat" class="btn btn-primary btn-sm" type="button"><i class="fas fa-plus"></i></button>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div id="chatBox" style="max-height: 400px; overflow-y: auto;">
                            @if (isset($chats))
                            @foreach ($chats as $chat )
                            @php
                                $isSender = ($currentuser->id == $chat->mentor);
                                $senderName = $chat->mentorUser->name ?? 'Mentor';
                                $receiverName = $chat->menteeUser->name ?? 'Mentee';
                            @endphp
                            <div class="alert {{ $isSender ? 'alert-success' : 'alert-primary' }}" role="alert" data-chat-id="{{ $chat->id }}">
                                <strong>{{ $isSender ? 'You' : $senderName }}:</strong> {{ $chat->message }}
                                <small class="d-block text-muted mt-1">{{ $chat->created_at->format('M d, H:i:s') }}</small>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Meetings</span>
                        <button id="BtnMeetings" class="btn btn-primary btn-sm" type="button"><i class="fas fa-plus"></i></button>
                </div>
                <ul class="list-group list-group-flush">
                    @if (isset($meetingrequests)) @foreach ($meetingrequests as $meetingrequest)
                        @php
                            $meetingMenteeName = $meetingrequest->menteeUser->name ?? 'Mentee';
                            $meetingMentorName = $meetingrequest->mentorUser->name ?? 'Mentor';
                            $back="";
                            $textcolor="";
                            if ($meetingrequest->status == "requested")
                            {  
                                $back=" border-info";
                                $textcolor="text-info";
                            }
                            elseif ($meetingrequest->status == "ongoing")
                            {
                                $back=" border-success";
                                $textcolor="text-success";
                            }
                            elseif ($meetingrequest->status == "declined")
                            {
                                $back=" border-danger";
                                $textcolor="text-danger";
                            }
                            elseif ($meetingrequest->status == "done")
                            { 
                                $back=" border-dark";
                                $textcolor="text-dark";
                            }   
                        @endphp

                        <div class="card <?php echo $back;?> text-center mb-3">
                            <div class="card-header <?php echo $textcolor;?>">
                                <strong>{{ $meetingrequest->description }}</strong>
                                <small class="d-block mt-1">
                                    @if($currentuser->type == "Mentor")
                                        With: {{ $meetingMenteeName }}
                                    @else
                                        With: {{ $meetingMentorName }}
                                    @endif
                                </small>
                                <span class="badge bg-secondary mt-1">{{ ucfirst($meetingrequest->status) }}</span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $meetingrequest->URL }}</h5>
                                <p class="card-text">{{ $meetingrequest->notes}}.</p>
                            </div>
                        <div class="card-footer bg-transparent border-primary">
                            <div class="d-flex gap-2 justify-content-center flex-wrap">
                                @if($meetingrequest->status != 'ongoing')
                                <form action="{{ route('meetings.update', $meetingrequest->id) }}" method="post" class="d-inline">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="status" value="ongoing">
                                    <input type="hidden" name="mentee" value="{{ $mentee->id }}">
                                    <input type="hidden" name="mentor" value="{{ $currentuser->id }}">
                                    <input type="hidden" name="project_id" value="{{ $selectedProject->id ?? '' }}">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-play"></i> Ongoing
                                    </button>
                                </form>
                                @endif
                                
                                @if($meetingrequest->status != 'declined')
                                <form action="{{ route('meetings.update', $meetingrequest->id) }}" method="post" class="d-inline">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="status" value="declined">
                                    <input type="hidden" name="mentee" value="{{ $mentee->id }}">
                                    <input type="hidden" name="mentor" value="{{ $currentuser->id }}">
                                    <input type="hidden" name="project_id" value="{{ $selectedProject->id ?? '' }}">
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-times-circle"></i> Declined
                                    </button>
                                </form>
                                @endif
                                
                                @if($meetingrequest->status != 'done')
                                <form action="{{ route('meetings.update', $meetingrequest->id) }}" method="post" class="d-inline">
                                    <input type="hidden" name="_method" value="PUT">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="status" value="done">
                                    <input type="hidden" name="mentee" value="{{ $mentee->id }}">
                                    <input type="hidden" name="mentor" value="{{ $currentuser->id }}">
                                    <input type="hidden" name="project_id" value="{{ $selectedProject->id ?? '' }}">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="fas fa-check-circle"></i> Done
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('meetings.destroy', $meetingrequest->id) }}" method="post" class="d-inline">
                                    <input type="hidden" name="_method" value="DELETE">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="mentee" value="{{ $mentee->id }}">
                                    <input type="hidden" name="mentor" value="{{ $currentuser->id }}">
                                    <input type="hidden" name="project_id" value="{{ $selectedProject->id ?? '' }}">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this meeting?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        
                        </div>
                        <div class="card-footer text-muted">
                          {{ $meetingrequest->date }}
                        </div>
                      </div>
                      <br>
                
                @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Area to Develop</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form
            class="form-horizontal"
            action="{{ route('mentorings.store') }}"
            method="post"
            role="form">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type='text' class='form-control' placeholder='Enter title' name='title' id="title">
            </div>
            <input value="Add" type='submit' class="btn btn-primary">
            <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
            <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
            @if(isset($selectedProject) && $selectedProject)
            <input type = "hidden" name = 'project_id' value = '{{ $selectedProject->id }}'>
            @endif
            {{ csrf_field() }}
        </form>
    </div>
</div>
</div>

<div id="myModal2" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form
            class="form-horizontal"
            action="{{ route('tasks.store') }}"
            method="post"
            role="form">
            <div class="mb-3">
                <label class="form-label"><strong>Task Title *</strong></label>
                <input type='text' class='form-control' placeholder='Enter task title' name='title' required>
            </div>
            
            <div class="mb-3">
                <label class="form-label"><strong>Description</strong></label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe the task..."></textarea>
            </div>

            @if($currentuser->type == "Mentor")
            <div class="mb-3">
                <label class="form-label"><strong>Assign to Mentee *</strong></label>
                @php
                    // Get all mentees available for this project
                    // Tasks are related to projects, so we get mentees from:
                    // 1. The project's assigned mentee (if project has a specific mentee)
                    // 2. All mentees from mentoring relationships in this project
                    $projectMentees = collect();
                    
                    // First, check if project has an assigned mentee
                    if(isset($selectedProject) && $selectedProject && $selectedProject->mentee) {
                        $assignedMentee = \App\Models\User::find($selectedProject->mentee);
                        if($assignedMentee && $assignedMentee->type === 'Mentee') {
                            $projectMentees->push($assignedMentee);
                        }
                    }
                    
                    // Then, get mentees from mentoring relationships in this project
                    if(isset($mentorings) && $mentorings->count() > 0) {
                        foreach($mentorings as $m) {
                            $menteeUser = $m->menteeUser;
                            if ($menteeUser && $menteeUser->type === 'Mentee') {
                                $projectMentees->push($menteeUser);
                            }
                        }
                    }
                    
                    // Remove duplicates and get unique mentees
                    $projectMentees = $projectMentees->unique(function($user) {
                        return $user->id;
                    })->values();
                @endphp
                @if($projectMentees->count() > 0)
                    <select name='mentee' class="form-select" required>
                        <option value="">Select a mentee...</option>
                        @foreach($projectMentees as $menteeOption)
                            <option value="{{ $menteeOption->id }}">
                                {{ $menteeOption->name }} ({{ $menteeOption->email }})
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Select which mentee this task should be assigned to</small>
                @else
                    <div class="alert alert-warning">
                        <strong>No valid mentees found in this project.</strong>
                        <br><br>Tasks are assigned to mentees who have access to this project. To create a task, you need:
                        <ul class="mb-0 mt-2">
                            <li>Either assign a mentee to this project (via project settings), OR</li>
                            <li>Create mentoring relationships with mentees in this project</li>
                        </ul>
                        @if(isset($selectedProject) && $selectedProject && !$selectedProject->mentee && (!isset($mentorings) || $mentorings->count() == 0))
                            <br><small>This project currently has no assigned mentee and no mentoring relationships.</small>
                        @endif
                    </div>
                    <select name='mentee' class="form-select" disabled>
                        <option value="">No valid mentees available</option>
                    </select>
                @endif
            </div>
            @else
                <input type="hidden" name="mentee" value="{{ $mentee->id }}">
            @endif

            @if (isset($mentorings) && $mentorings->count() > 0)
            <div class="mb-3">
                <label class="form-label"><strong>Area to Develop (Optional)</strong></label>
                <select name='mentoring_id' class="form-select">
                    <option value="">No specific area</option>
                    @foreach ($mentorings as $mentoring)
                        <option value="{{$mentoring->id}}">{{ ucfirst($mentoring->title) }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            
            <div class="mb-3">
                <label class="form-label"><strong>Priority *</strong></label>
                <select class="form-select" name='priority' required>
                    <option value="High">High</option>
                    <option value="Medium" selected>Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            
            <input type="hidden" name="mentor" value="{{ $currentuser->id }}">
            @if(isset($selectedProject) && $selectedProject)
            <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">
            @endif
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Create Task</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('myModal2')">Cancel</button>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>
</div>

<div id="myModal3" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Adding Document</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

        <form  id="upload-file" action="{{ route('documents.store') }}" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="doc_title" class="form-label">Title</label>
            <input type='text' class='form-control' placeholder='Enter title' name='title' id="doc_title">
        </div>
        <div class="mb-3">
            <label for="document" class="form-label">Document</label>
            <input class="form-control" name="document" type="file" id="document">
        </div>
        <div class="mb-3">
            <label for="doc_description" class="form-label">Description</label>
            <textarea class="form-control" id="doc_description" name="description" rows="3" placeholder="Describe the doc"></textarea>
        </div>
        
        <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
        <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
        @if(isset($selectedProject) && $selectedProject)
        <input type = "hidden" name = 'project_id' value = '{{ $selectedProject->id }}'>
        @endif
        {!! csrf_field() !!}
        <button type="submit" class="btn btn-success">Save</button>
        

        </form>


            </div>
        </div>
    </div>

    <div id="myModal4" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Live Chat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form
            class="form-horizontal"
            id="chatForm"
            action="{{ route('chats.store') }}"
            method="post"
            role="form">
                
                <textarea class="form-control" id="message" name="message" rows="3" placeholder="Type Your Message "></textarea>
            <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}' id="chatMentee">
            <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}' id="chatMentor">
            @if(isset($selectedProject) && $selectedProject)
            <input type = "hidden" name = 'project_id' value = '{{ $selectedProject->id }}' id="chatProjectId">
            @endif
            {{ csrf_field() }}
                    <button type='submit' class="btn btn-primary mt-2">Send</button>
            </form>
                </div>
            </div>
        </div>

        <div id="myModal5" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Meetings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form
                    class="form-horizontal"
                    action="{{ route('meetings.store') }}"
                    method="post"
                    role="form">
                   <div class="mb-3">
                        <label for="meet_description" class="form-label">Description</label>
                        <textarea class="form-control" id="meet_description" name="description" rows="3" placeholder="Describe why needed this meeting"></textarea>
                   </div>
                   <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="notes"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="URL" class="form-label">URL for Meeting</label>
                        <input type='text' class='form-control' placeholder='URL for Meeting' name='URL' id="URL">
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type='date' class='form-control' placeholder='Date' name='date' id="date">
                    </div>
                    <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
            <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
            @if(isset($selectedProject) && $selectedProject)
            <input type = "hidden" name = 'project_id' value = '{{ $selectedProject->id }}'>
            @endif

                    <button value="Add" type='submit' class="btn btn-primary">Add</button>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset('js/model.js') }}"></script>
    
    <script>
    // Real-time chat functionality
    let lastChatId = 0;
    let chatRefreshInterval;
    
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('myModal'), {});
        var myModal2 = new bootstrap.Modal(document.getElementById('myModal2'), {});
        var myModal3 = new bootstrap.Modal(document.getElementById('myModal3'), {});
        var myModal4 = new bootstrap.Modal(document.getElementById('myModal4'), {});
        var myModal5 = new bootstrap.Modal(document.getElementById('myModal5'), {});

        document.getElementById('BtnAreatoDevelop').addEventListener('click', function() {
            myModal.show();
        });
        document.getElementById('BtnAddActivity').addEventListener('click', function() {
            myModal2.show();
        });
        document.getElementById('BtnAddProject').addEventListener('click', function() {
            myModal3.show();
        });
        document.getElementById('BtnLiveChat').addEventListener('click', function() {
            myModal4.show();
        });
        document.getElementById('BtnMeetings').addEventListener('click', function() {
            myModal5.show();
        });

        initializeChatRefresh();
        setupChatForm();
        
        const chatMessages = document.querySelectorAll('[data-chat-id]');
        if (chatMessages.length > 0) {
            lastChatId = Math.max(...Array.from(chatMessages).map(el => parseInt(el.getAttribute('data-chat-id'))));
        }
    });
    
    function initializeChatRefresh() {
        const mentorId = document.getElementById('chatMentor')?.value || '{{ $currentuser->id }}';
        const menteeId = document.getElementById('chatMentee')?.value || '{{ $mentee->id }}';
        
        chatRefreshInterval = setInterval(function() {
            fetchChatMessages(mentorId, menteeId);
        }, 2000);
    }
    
    function fetchChatMessages(mentorId, menteeId) {
        const projectId = document.getElementById('chatProjectId')?.value || '';
        let url;
        
        if (projectId) {
            url = `/chat/messages?project_id=${projectId}`;
        } else {
            url = `/chat/messages?mentor=${mentorId}&mentee=${menteeId}`;
        }
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.messages.length > 0) {
                updateChatBox(data.messages, mentorId);
            }
        })
        .catch(error => {
            console.error('Error fetching messages:', error);
        });
    }
    
    function updateChatBox(messages, currentUserId) {
        const chatBox = document.getElementById('chatBox');
        if (!chatBox) return;
        
        const currentUserIsMentor = {{ $currentuser->type === 'Mentor' ? 'true' : 'false' }};
        const currentUserId = {{ $currentuser->id }};
        
        const currentIds = Array.from(chatBox.querySelectorAll('[data-chat-id]'))
            .map(el => parseInt(el.getAttribute('data-chat-id')));
        
        messages.forEach(function(message) {
            if (!currentIds.includes(message.id)) {
                const isCurrentUser = (currentUserIsMentor && message.mentor == currentUserId) || 
                                     (!currentUserIsMentor && message.mentee == currentUserId);
                
                const senderName = currentUserIsMentor ? 
                    (message.mentor == currentUserId ? 'You' : message.mentor_name) :
                    (message.mentee == currentUserId ? 'You' : message.mentee_name);
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `alert ${isCurrentUser ? 'alert-success' : 'alert-primary'}`;
                messageDiv.setAttribute('role', 'alert');
                messageDiv.setAttribute('data-chat-id', message.id);
                
                const date = new Date(message.created_at);
                const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
                
                messageDiv.innerHTML = `
                    <strong>${escapeHtml(senderName)}:</strong> ${escapeHtml(message.message)}
                    <small class="d-block text-muted mt-1">${formattedDate}</small>
                `;
                chatBox.appendChild(messageDiv);
                
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    }
    
    function setupChatForm() {
        const chatForm = document.getElementById('chatForm');
        if (!chatForm) return;
        
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(chatForm);
            const messageInput = document.getElementById('message');
            
            fetch('/newchat', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const chatBox = document.getElementById('chatBox');
                    if (chatBox) {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = `alert ${data.chat.is_sender ? 'alert-success' : 'alert-primary'}`;
                        messageDiv.setAttribute('role', 'alert');
                        messageDiv.setAttribute('data-chat-id', data.chat.id);
                        messageDiv.innerHTML = `
                            ${escapeHtml(data.chat.message)}
                            <small class="d-block text-muted">${data.chat.created_at}</small>
                        `;
                        chatBox.appendChild(messageDiv);
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                    
                    messageInput.value = '';
                } else {
                    alert('Error sending message');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error sending message');
            });
        });
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
    
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (chatRefreshInterval) {
                clearInterval(chatRefreshInterval);
            }
        } else {
            initializeChatRefresh();
        }
    });
    </script>
</body>
</html>