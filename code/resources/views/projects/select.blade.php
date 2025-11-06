<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Select Project - ShareHub</title>
    
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .selection-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 800px;
            width: 100%;
        }
        
        .selection-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .selection-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 10px;
        }
        
        .selection-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .project-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 2px solid transparent;
            cursor: pointer;
        }
        
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-color: var(--primary-color);
        }
        
        .project-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
        }
        
        .project-meta {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .btn-select-project {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-select-project:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .badge-active {
            background: #10b981;
            color: white;
        }
        
        .badge-completed {
            background: #6c757d;
            color: white;
        }
        
        .badge-cancelled {
            background: #dc3545;
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: #6c757d;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="selection-card">
        <div class="selection-header">
            <h1 class="selection-title">
                <i class="fas fa-folder-open me-2"></i>Select a Project
            </h1>
            <p class="selection-subtitle">
                Choose a project to access your workspace and dashboard
            </p>
        </div>

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
            <div class="projects-list">
                @foreach($projects as $project)
                    <div class="project-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-grow-1">
                                <h3 class="project-title">{{ $project->title }}</h3>
                                <div class="project-meta">
                                    <i class="fas fa-calendar me-2"></i>{{ $project->project_date->format('M d, Y') }}
                                    @if($project->status)
                                        <span class="status-badge 
                                            @if($project->status === 'active') badge-active
                                            @elseif($project->status === 'completed') badge-completed
                                            @elseif($project->status === 'cancelled') badge-cancelled
                                            @endif ms-2">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    @endif
                                </div>
                                @if($project->description)
                                    <p class="text-muted mb-3">{{ Str::limit($project->description, 150) }}</p>
                                @endif
                                @if($user->type === 'Mentor')
                                    @if($project->mentee)
                                        <p class="mb-0">
                                            <i class="fas fa-user me-2"></i>
                                            <strong>Assigned to:</strong> {{ $project->menteeUser->name ?? 'N/A' }}
                                        </p>
                                    @else
                                        <p class="mb-0">
                                            <i class="fas fa-users me-2"></i>
                                            <strong>General Project</strong> (Not assigned)
                                        </p>
                                    @endif
                                @else
                                    @if($project->mentee == $user->id)
                                        <p class="mb-0">
                                            <span class="badge bg-success">Assigned to You</span>
                                        </p>
                                    @else
                                        <p class="mb-0">
                                            <i class="fas fa-user-tie me-2"></i>
                                            <strong>From:</strong> {{ $project->ownerUser->name ?? 'Mentor' }}
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('home', ['project_id' => $project->id]) }}" class="btn btn-select-project flex-fill">
                                <i class="fas fa-arrow-right me-2"></i>Select This Project
                            </a>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-folder-open empty-state-icon"></i>
                <h3>No Projects Available</h3>
                <p class="text-muted mb-4">
                    @if($user->type === 'Mentor')
                        You haven't created any projects yet. Create your first project to get started!
                    @else
                        No projects are available for you at the moment. Contact your mentor to get assigned to a project.
                    @endif
                </p>
                @if($user->type === 'Mentor')
                    <a href="{{ route('projects.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>Create Your First Project
                    </a>
                @endif
            </div>
        @endif

        <div class="text-center mt-4">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

