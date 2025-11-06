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
    <link rel="stylesheet" href="{{asset('css/model.css')}}">
    <title>Workspace - ShareHub</title>
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #10b981;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }
        .workspace-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
        }
        .progress {
            height: 8px;
        }
        .btn-primary {
            background: var(--primary-color);
            border: none;
        }
        .btn-primary:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>
    <!-- Workspace Header -->
    <div class="workspace-header">
        <div class="container">
            <div class="row justify-content-md-center align-items-center">
                <div class="col-md-auto">
                    <h4 class="mb-0">
                        <i class="fas fa-user-tie me-2"></i>
                        Mentor(@if(isset($mentor) && $mentor){{ $mentor->name }}@else{{ $currentuser->type === 'Mentor' ? $currentuser->name : 'Not Assigned' }}@endif)
                    </h4>
                </div>
                <div class="col-md-auto">
                    <i class="fas fa-equals"></i>
                </div>
                <div class="col-md-auto">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Mentee({{ $mentee->name }})
                    </h4>
                </div>
            </div>
            <div class="row justify-content-md-center mt-3">
                <div class="col-md-auto">
                    <small><i class="fas fa-calendar-alt me-1"></i>Mentoring Cycle: 90 days</small>
                </div>
                <div class="col-md-auto">
                    <small>Time Remaining</small>
                    <div class="progress" style="width: 200px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                @if(isset($projects) && $projects->count() > 0)
                <div class="col-md-auto">
                    <form method="GET" action="{{ route('home') }}" class="d-inline">
                        <select name="project_id" class="form-select form-select-sm" onchange="this.form.submit()" style="width: 200px;">
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}" {{ (isset($selectedProject) && $selectedProject && $selectedProject->id == $project->id) ? 'selected' : '' }}>
                                    {{ $project->title }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @endif
                <div class="col-md-auto">
                    <a href="{{ $currentuser->type === 'Mentor' ? route('adminDashboard', ['project_id' => $selectedProject->id ?? '']) : route('userDashboard', ['project_id' => $selectedProject->id ?? '']) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                    </a>
                </div>
                <div class="col-md-auto">
                    <a href="{{ route('project.select') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-exchange-alt me-1"></i>Change Project
                    </a>
                </div>
                <div class="col-md-auto">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
            @if(isset($selectedProject) && $selectedProject)
            <div class="row justify-content-md-center mt-2">
                <div class="col-md-auto">
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-folder-open me-1"></i>Current Project: {{ $selectedProject->title }}
                    </span>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-md-center">
                <div class="col-md-auto">
                    <div class="card" style="width: 18rem;">
                        <div class="card-header">
                            Areas to Develop
                            @if ($currentuser->type == "Mentor")
                                <button
                                id="BtnAreatoDevelop"
                                class="btn btn-primary float-end"
                                onclick="show_my_receipt()"
                                type="button">+</button>
                                @else
                                <button
                                id="BtnAreatoDevelop"
                                class="btn btn-primary float-end"
                                onclick="show_my_receipt()"
                                disabled
                                type="button">+</button>
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
                                    <form class="ms-2" action="{{ url('/newmentoring', $mentoring->id) }}" method="post">
                                        <input type="hidden" name="mentee" value="{{ $mentoring->mentee ?? $mentee->id }}">
                                        <input type="hidden" name="mentor" value="{{ $currentuser->id }}">
                                        <button type="submit" name="x" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        {{ method_field('DELETE') }}
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
            <br>
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Tasks
                    @if ($currentuser->type == "Mentor")
                        <button id="BtnAddActivity" class="btn btn-primary float-end" type="button">+</button>
                        @else
                        <button id="BtnAddActivity" disabled class="btn btn-primary float-end" type="button">+</button>
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
                                    <form class="d-inline" action="{{ url('/newtask', $task->id) }}" method="post">
                                        <input type="hidden" name="mentee" value="{{ $task->mentee }}">
                                        <input type="hidden" name="mentor" value="{{ $task->mentor }}">
                                        @if(isset($selectedProject) && $selectedProject)
                                        <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">
                                        @endif
                                        <button type="submit" name="Done" class="btn btn-warning btn-sm">
                                            <i class="fas fa-check me-1"></i>Mark Done
                                        </button>
                                        {{ method_field('put') }}
                                        {{ csrf_field() }}
                                    </form>
                                @endif
                                @if ($currentuser->type == "Mentor" && $task->mentor == $currentuser->id)
                                    <form class="d-inline" action="{{ url('/newtask', $task->id) }}" method="post">
                                        <input type="hidden" name="mentee" value="{{ $task->mentee }}">
                                        <input type="hidden" name="mentor" value="{{ $currentuser->id }}">
                                        @if(isset($selectedProject) && $selectedProject)
                                        <input type="hidden" name="project_id" value="{{ $selectedProject->id }}">
                                        @endif
                                        <button type="submit" name="x" class="btn btn-danger btn-sm" title="Delete task">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        {{ method_field('DELETE') }}
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
            <br>
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Documents

                        <button id="BtnAddProject" class="btn btn-primary float-end" type="button">+</button>

                </div>
                <ul class="list-group list-group-flush">
                    @if (isset($documents))
                    @foreach ($documents as $document )
                   <li class="list-group-item">
                       <div class="d-flex justify-content-between align-items-center">
                           <div>
                               <a href="{{ route('document.download', $document) }}" class="text-decoration-none">
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
        <div class="col-md-auto">
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Projects
                    <a href="{{ route('projects.index') }}" class="btn btn-primary btn-sm float-end">
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
            <br>
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Live Chat
                        <button id="BtnLiveChat" class="btn btn-primary float-end" type="button">+</button>
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
            <br>
            <div class="card" style="width: 18rem;">
                <div class="card-header">
                    Meetings
                        <button id="BtnMeetings" class="btn btn-primary float-end" type="button">+</button>
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

                        <div class="card <?php echo $back;?> text-center mb-3" style="max-width: 18rem;">
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
                                <form action="{{ url('/newmeeting', $meetingrequest->id) }}" method="post" class="d-inline">
                                    {{ method_field('PUT') }}
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
                                <form action="{{ url('/newmeeting', $meetingrequest->id) }}" method="post" class="d-inline">
                                    {{ method_field('PUT') }}
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
                                <form action="{{ url('/newmeeting', $meetingrequest->id) }}" method="post" class="d-inline">
                                    {{ method_field('PUT') }}
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
                                
                                <form action="{{ url('/newmeeting', $meetingrequest->id) }}" method="post" class="d-inline">
                                    {{ method_field('DELETE') }}
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
            <span class="close">&times;</span>
            <h2>Add Area to Develop</h2>
        </div>
        <div class="modal-body">
            <form
            class="form-horizontal"
            action="{{ url('/newmentoring') }}"
            method="post"
            role="form">
            <input type='text' class='form-control' placeholder='title' name='title'>
            <input value="Add" type='submit' class="btn btn-primary">
            <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
            <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
            @if(isset($selectedProject) && $selectedProject)
            <input type = "hidden" name = 'project_id' value = '{{ $selectedProject->id }}'>
            @endif
            {{ csrf_field() }}
        </form>
    </div>
    <div class="modal-footer">

    </div>
</div>
</div>

<div id="myModal2" class="modal">
    <!-- Modal content -->
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">

            <h2>Add Task</h2>
        </div>
        <div class="modal-body">
            <form
            class="form-horizontal"
            action="{{ url('/newtask') }}"
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
                    <select name='mentee' class="form-control" required>
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
                    <select name='mentee' class="form-control" disabled>
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
                <select name='mentoring_id' class="form-control">
                    <option value="">No specific area</option>
                    @foreach ($mentorings as $mentoring)
                        <option value="{{$mentoring->id}}">{{ ucfirst($mentoring->title) }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            
            <div class="mb-3">
                <label class="form-label"><strong>Priority *</strong></label>
                <select class="form-control" name='priority' required>
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
    <div class="modal-footer">

    </div>
</div>
</div>

<div id="myModal3" class="modal">
    <!-- Modal content -->
    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">

            <h2>Adding Document</h2>
        </div>
        <div class="modal-body">

        <form  id="upload-file" action="{{ url('/documentsadd') }}" method="post" enctype="multipart/form-data">
            
        <input type='text' class='form-control' placeholder='title' name='title'>
        <input class="form-control" name="document" type="file" id="document">
        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe the doc"></textarea>
        
        <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
        <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
        @if(isset($selectedProject) && $selectedProject)
        <input type = "hidden" name = 'project_id' value = '{{ $selectedProject->id }}'>
        @endif
        {!! csrf_field() !!}
        <input type="submit" value="Save" class="btn btn-success">
        

        </form>


            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>

    <div id="myModal4" class="modal">
        <!-- Modal content -->
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">

                <h2>Live Chat</h2>
            </div>
            <div class="modal-body">
            <form
            class="form-horizontal"
            id="chatForm"
            action="{{ url('/newchat') }}"
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
                    <button type='button' class="btn btn-secondary mt-2" onclick="document.getElementById('myModal4').style.display='none'">Close</button>
            </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>

        <div id="myModal5" class="modal">
            <!-- Modal content -->
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">

                    <h2>Meetings</h2>
                </div>
                <div class="modal-body">
                    <form
                    class="form-horizontal"
                    action="{{ url('/newmeeting') }}"
                    method="post"
                    role="form">
                   
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe why needed this meeting"></textarea>
                    <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="notes"></textarea>
                    <input type='text' class='form-control' placeholder='URL for Meeting' name='URL'>
                    <input type='date' class='form-control' placeholder='Date' name='date'>
                    <input type = "hidden" name = 'mentee' value = '{{ $mentee->id }}'>
            <input type = "hidden" name = 'mentor' value = '{{ $currentuser->id }}'>
            @if(isset($selectedProject) && $selectedProject)
            <input type = "hidden" name = 'project_id' value = '{{ $selectedProject->id }}'>
            @endif

                    <input value="Add" type='submit' class="btn btn-primary">
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="{{ URL::asset('js/model.js') }}"></script>
    
    <script>
    // Real-time chat functionality
    let lastChatId = 0;
    let chatRefreshInterval;
    
    // Initialize chat refresh on page load
    document.addEventListener('DOMContentLoaded', function() {
        initializeChatRefresh();
        setupChatForm();
        
        // Get the last chat ID for initial load
        const chatMessages = document.querySelectorAll('[data-chat-id]');
        if (chatMessages.length > 0) {
            lastChatId = Math.max(...Array.from(chatMessages).map(el => parseInt(el.getAttribute('data-chat-id'))));
        }
    });
    
    function initializeChatRefresh() {
        const mentorId = document.getElementById('chatMentor')?.value || '{{ $currentuser->id }}';
        const menteeId = document.getElementById('chatMentee')?.value || '{{ $mentee->id }}';
        
        // Refresh chat every 2 seconds
        chatRefreshInterval = setInterval(function() {
            fetchChatMessages(mentorId, menteeId);
        }, 2000);
    }
    
    function fetchChatMessages(mentorId, menteeId) {
        const projectId = document.getElementById('chatProjectId')?.value || '';
        let url;
        
        // If project_id is available, use it to get all messages in the project
        if (projectId) {
            url = `/chat/messages?project_id=${projectId}`;
        } else {
            // Fallback to mentor/mentee conversation
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
        
        // Get current user ID from the page
        const currentUserIsMentor = {{ $currentuser->type === 'Mentor' ? 'true' : 'false' }};
        const currentUserId = {{ $currentuser->id }};
        
        // Get current message IDs
        const currentIds = Array.from(chatBox.querySelectorAll('[data-chat-id]'))
            .map(el => parseInt(el.getAttribute('data-chat-id')));
        
        // Add new messages
        messages.forEach(function(message) {
            if (!currentIds.includes(message.id)) {
                // Determine if message is from current user
                const isCurrentUser = (currentUserIsMentor && message.mentor == currentUserId) || 
                                     (!currentUserIsMentor && message.mentee == currentUserId);
                
                // Get sender name
                const senderName = currentUserIsMentor ? 
                    (message.mentor == currentUserId ? 'You' : message.mentor_name) :
                    (message.mentee == currentUserId ? 'You' : message.mentee_name);
                
                const messageDiv = document.createElement('div');
                messageDiv.className = `alert ${isCurrentUser ? 'alert-success' : 'alert-primary'}`;
                messageDiv.setAttribute('role', 'alert');
                messageDiv.setAttribute('data-chat-id', message.id);
                
                // Format date
                const date = new Date(message.created_at);
                const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
                
                messageDiv.innerHTML = `
                    <strong>${escapeHtml(senderName)}:</strong> ${escapeHtml(message.message)}
                    <small class="d-block text-muted mt-1">${formattedDate}</small>
                `;
                chatBox.appendChild(messageDiv);
                
                // Scroll to bottom
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
                    // Add message immediately to chat box
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
                    
                    // Clear input
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
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
    
    // Clean up interval when page is hidden
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