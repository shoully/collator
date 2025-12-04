<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/model.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>My Projects - ShareHub</title>
</head>
<body>
    <br>
    <div class="container">
        <div class="row justify-content-md-center mb-4">
            <div class="col-md-auto">
                <h2>My Projects</h2>
            </div>
            @if($user->type === 'Mentor')
            <div class="col-md-auto">
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create New Project
                </a>
            </div>
            @endif
            <div class="col-md-auto">
                <a href="{{ $user->type === 'Mentor' ? route('adminDashboard') : route('userDashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>
            <div class="col-md-auto">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-md-center">
            @if($projects->count() > 0)
                @foreach($projects as $project)
                    <div class="col-md-auto mb-3">
                        <div class="card" style="width: 18rem;">
                            <div class="card-header">
                                {{ $project->title }}
                                @if($user->type === 'Mentor' && $user->id == $project->owner)
                                    <form class="d-inline float-end" action="{{ route('projects.destroy', $project) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="x" name="x" class="btn btn-danger btn-sm">
                                    </form>
                                @endif
                            </div>
                            <ul class="list-group list-group-flush">
                                @if($project->description)
                                <li class="list-group-item">
                                    <small class="text-muted">{{ Str::limit($project->description, 80) }}</small>
                                </li>
                                @endif
                                <li class="list-group-item">
                                    <i class="fas fa-calendar me-1"></i>
                                    <small>{{ $project->project_date->format('M d, Y') }}</small>
                                </li>
                                @if($user->type === 'Mentor')
                                    <li class="list-group-item">
                                        <strong>Status:</strong>
                                        @if($project->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($project->status === 'completed')
                                            <span class="badge bg-secondary">Completed</span>
                                        @elseif($project->status === 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                        @if($user->id == $project->owner)
                                            <form method="POST" action="{{ route('projects.updateStatus', $project) }}" class="d-inline float-end">
                                                @csrf
                                                <select name="status" class="form-select form-select-sm" style="width: auto; display: inline-block;" onchange="this.form.submit()">
                                                    <option value="active" {{ $project->status === 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                    <option value="cancelled" {{ $project->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                </select>
                                            </form>
                                        @endif
                                    </li>
                                    @if($project->mentee)
                                        <li class="list-group-item">
                                            <i class="fas fa-user me-1"></i>
                                            <small>Assigned to: {{ $project->menteeUser->name ?? 'N/A' }}</small>
                                        </li>
                                    @else
                                        <li class="list-group-item">
                                            <i class="fas fa-users me-1"></i>
                                            <small>General Project</small>
                                        </li>
                                    @endif
                                @else
                                    <li class="list-group-item">
                                        @if($project->mentee == $user->id)
                                            <span class="badge rounded-pill bg-success">Assigned to You</span>
                                        @else
                                            <span class="badge rounded-pill bg-warning text-dark">Available</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fas fa-user-tie me-1"></i>
                                        <small>From: {{ $project->ownerUser->name ?? 'Mentor' }}</small>
                                    </li>
                                @endif
                                @if($project->file)
                                <li class="list-group-item">
                                    <i class="fas fa-file me-1"></i>
                                    <small class="text-success">File attached</small>
                                </li>
                                @endif
                                <li class="list-group-item">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-primary btn-sm flex-fill">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        @if($project->file)
                                            <a href="{{ route('projects.download', $project) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                        @if($user->type === 'Mentee' && $project->mentee === null && $project->status === 'active')
                                            @php
                                                $hasMentoring = \App\Models\Mentoring::where('mentor', $project->owner)
                                                    ->where('mentee', $user->id)
                                                    ->exists();
                                                $hasActiveProject = \App\Models\Project::where('mentee', $user->id)
                                                    ->where('status', 'active')
                                                    ->exists();
                                            @endphp
                                            @if(($hasMentoring || count(\App\Models\Mentoring::where('mentee', $user->id)->pluck('mentor')->toArray()) == 0) && !$hasActiveProject)
                                                <form method="POST" action="{{ route('projects.requestJoin', $project) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-hand-paper me-1"></i>Join
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h4>No Projects Yet</h4>
                    @if($user->type === 'Mentor')
                        <p class="text-muted mb-4">Get started by creating your first project!</p>
                        <a href="{{ route('projects.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create Your First Project
                        </a>
                    @else
                        <p class="text-muted mb-4">No projects have been assigned to you yet. Check available projects in your dashboard.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
