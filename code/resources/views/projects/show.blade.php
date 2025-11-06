<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $project->title }} - ShareHub</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #10b981;
            --dark-color: #1f2937;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
            color: #333;
        }
        
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
        }
        
        .project-detail-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: #4338ca;
        }
        
        .btn-danger-custom {
            background: #dc3545;
            border: none;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .btn-danger-custom:hover {
            background: #c82333;
        }
        
        .btn-logout {
            background: rgba(255,255,255,0.2);
            border: 2px solid white;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            transition: all 0.3s;
        }
        
        .btn-logout:hover {
            background: white;
            color: var(--primary-color);
        }
        
        .info-item {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-project-diagram me-2"></i>ShareHub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminDashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.index') }}">My Projects</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-logout">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="mb-0"><i class="fas fa-folder me-2"></i>{{ $project->title }}</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="project-detail-card">
                    <!-- Project Info -->
                    <div class="info-item">
                        <strong><i class="fas fa-calendar me-2"></i>Project Date:</strong>
                        {{ $project->project_date->format('F d, Y') }}
                    </div>
                    
                    @if($project->mentee)
                        <div class="info-item">
                            <strong><i class="fas fa-user me-2"></i>Assigned to:</strong>
                            {{ $project->menteeUser->name ?? 'N/A' }} ({{ $project->menteeUser->email ?? 'N/A' }})
                        </div>
                    @else
                        <div class="info-item">
                            <strong><i class="fas fa-users me-2"></i>Type:</strong>
                            General Project (Not assigned to specific mentee)
                        </div>
                    @endif
                    
                    <div class="info-item">
                        <strong><i class="fas fa-info-circle me-2"></i>Status:</strong>
                        @if($project->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @elseif($project->status === 'completed')
                            <span class="badge bg-secondary">Completed</span>
                        @elseif($project->status === 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-primary">{{ ucfirst($project->status ?? 'Active') }}</span>
                        @endif
                    </div>
                    
                    @if($project->description)
                        <div class="info-item">
                            <strong><i class="fas fa-align-left me-2"></i>Description:</strong>
                            <p class="mb-0 mt-2">{{ $project->description }}</p>
                        </div>
                    @endif
                    
                    @if($project->file)
                        <div class="info-item">
                            <strong><i class="fas fa-file me-2"></i>Attached File:</strong>
                            <div class="mt-2">
                                <a href="{{ route('projects.download', $project) }}" class="btn btn-primary-custom text-white">
                                    <i class="fas fa-download me-2"></i>Download {{ $project->filename }}
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Actions -->
                    <div class="d-flex gap-3 mt-4">
                        <a href="{{ $user->type === 'Mentor' ? route('projects.index') : route('userDashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                        
                        @if($user->type === 'Mentee' && $project->mentee === null && $project->status === 'active')
                            @php
                                $hasMentoring = \App\Models\Mentoring::where('mentor', $project->owner)
                                    ->where('mentee', $user->id)
                                    ->exists();
                                // Check if mentee already has an active project
                                $hasActiveProject = \App\Models\Project::where('mentee', $user->id)
                                    ->where('status', 'active')
                                    ->exists();
                            @endphp
                            @if($hasMentoring && !$hasActiveProject)
                                <form method="POST" action="{{ route('projects.requestJoin', $project) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary-custom text-white">
                                        <i class="fas fa-hand-paper me-2"></i>Join This Project
                                    </button>
                                </form>
                            @elseif($hasActiveProject)
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    You can only join one project at a time. Please complete your current project before joining another one.
                                </div>
                            @endif
                        @endif
                        
                        @if($user->type === 'Mentor' && $user->id == $project->owner)
                            <!-- Project Status Control -->
                            <div class="mb-3">
                                <label class="form-label"><strong>Change Project Status:</strong></label>
                                <form method="POST" action="{{ route('projects.updateStatus', $project) }}" class="d-inline-flex gap-2">
                                    @csrf
                                    <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                                        <option value="active" {{ $project->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="completed" {{ $project->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $project->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </div>
                            
                            <form method="POST" action="{{ route('projects.destroy', $project) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger-custom text-white">
                                    <i class="fas fa-trash me-2"></i>Delete Project
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

