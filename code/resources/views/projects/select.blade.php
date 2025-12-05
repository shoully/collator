<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Select Project - Collator</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/collator.css') }}">
    
    <style>
        body {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h1 class="fw-bold mb-0">Select a Project</h1>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if(session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($projects->count() > 0)
                        <div class="list-group">
                            @foreach($projects as $project)
                                <a href="{{ route('workspace', $project) }}" class="list-group-item list-group-item-action flex-column align-items-start mb-3 rounded-3 shadow-sm">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $project->title }}</h5>
                                        <small>{{ $project->project_date->format('M d, Y') }}</small>
                                    </div>
                                    <p class="mb-1">{{ Str::limit($project->description, 150) }}</p>
                                    <div>
                                        @if($project->status)
                                            <span class="badge 
                                                @if($project->status === 'active') bg-success
                                                @elseif($project->status === 'completed') bg-secondary
                                                @elseif($project->status === 'cancelled') bg-danger
                                                @endif">
                                                {{ ucfirst($project->status) }}
                                            </span>
                                        @endif
                                        @if($user->type === 'Mentor')
                                            @if($project->mentee)
                                                <small class="text-muted ms-2">
                                                    <i class="fas fa-user me-1"></i>
                                                    Assigned to: {{ $project->menteeUser->name ?? 'N/A' }}
                                                </small>
                                            @else
                                                <small class="text-muted ms-2">
                                                    <i class="fas fa-users me-1"></i>
                                                    General Project
                                                </small>
                                            @endif
                                        @else
                                            @if($project->mentee == $user->id)
                                                <span class="badge bg-primary ms-2">Assigned to You</span>
                                            @else
                                                <small class="text-muted ms-2">
                                                    <i class="fas fa-user-tie me-1"></i>
                                                    From: {{ $project->ownerUser->name ?? 'Mentor' }}
                                                </small>
                                            @endif
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                            <h3>No Projects Available</h3>
                            <p class="text-muted mb-4">
                                @if($user->type === 'Mentor')
                                    You haven't created any projects yet. Create your first project to get started!
                                @else
                                    No projects are available for you at the moment. Contact your mentor to get assigned to a project.
                                @endif
                            </p>
                            @if($user->type === 'Mentor')
                                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Create Your First Project
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

