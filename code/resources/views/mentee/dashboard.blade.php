<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Mentee Dashboard - ShareHub</title>
    
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
        
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0 40px;
            margin-bottom: 40px;
        }
        
        .dashboard-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .dashboard-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        
        .stat-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .action-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        
        .action-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            color: inherit;
            text-decoration: none;
        }
        
        .action-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        .action-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 10px;
        }
        
        .action-description {
            color: #6c757d;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .section-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 30px;
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

        .project-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
        }
        
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
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
                        <a class="nav-link" href="{{ route('userDashboard', ['project_id' => $selectedProject->id ?? '']) }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}">My Workspace</a>
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

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <h1 class="dashboard-title">Welcome, {{ $user->name }}!</h1>
            <p class="dashboard-subtitle">
                Mentee Dashboard - {{ $selectedProject->title ?? 'No Project Selected' }}
                @if(isset($selectedProject))
                    <span class="badge bg-light text-dark ms-2">{{ ucfirst($selectedProject->status) }}</span>
                @endif
            </p>
            @if(isset($selectedProject))
            <div class="mt-3">
                <a href="{{ route('project.select') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-exchange-alt me-1"></i>Change Project
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
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

        <!-- Statistics Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-user-tie stat-icon"></i>
                    <div class="stat-number">{{ $stats['mentors_count'] }}</div>
                    <div class="stat-label">My Mentors</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-tasks stat-icon"></i>
                    <div class="stat-number">{{ $stats['tasks_count'] }}</div>
                    <div class="stat-label">Total Tasks</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-clock stat-icon"></i>
                    <div class="stat-number">{{ $stats['pending_tasks'] }}</div>
                    <div class="stat-label">Pending Tasks</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-check-circle stat-icon" style="color: var(--secondary-color);"></i>
                    <div class="stat-number">{{ $stats['completed_tasks'] }}</div>
                    <div class="stat-label">Completed</div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card text-center">
                    <i class="fas fa-folder-open stat-icon"></i>
                    <div class="stat-number">{{ $stats['projects_count'] }}</div>
                    <div class="stat-label">My Projects</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card text-center">
                    <i class="fas fa-file-alt stat-icon"></i>
                    <div class="stat-number">{{ $stats['documents_count'] }}</div>
                    <div class="stat-label">Documents</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card text-center">
                    <i class="fas fa-calendar-check stat-icon"></i>
                    <div class="stat-number">{{ $stats['meetings_count'] }}</div>
                    <div class="stat-label">Meetings</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <h2 class="section-title">Quick Actions</h2>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-briefcase action-icon"></i>
                        <h3 class="action-title">My Workspace</h3>
                        <p class="action-description">
                            Access your main workspace to view tasks, development areas, documents, and chat with your mentors.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('projects.index') }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-folder-open action-icon"></i>
                        <h3 class="action-title">My Projects</h3>
                        <p class="action-description">
                            View all your assigned projects and available projects from your mentors.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-tasks action-icon"></i>
                        <h3 class="action-title">View My Tasks</h3>
                        <p class="action-description">
                            See all your tasks, track progress, and mark tasks as completed.
                        </p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Learning & Development Section -->
        <h2 class="section-title">Learning & Development</h2>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-project-diagram action-icon"></i>
                        <h3 class="action-title">Development Areas</h3>
                        <p class="action-description">
                            View development areas set by your mentors and track your progress.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-file-alt action-icon"></i>
                        <h3 class="action-title">Shared Documents</h3>
                        <p class="action-description">
                            Access documents shared by your mentors. Download resources and materials.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-chart-line action-icon"></i>
                        <h3 class="action-title">Track Progress</h3>
                        <p class="action-description">
                            Monitor your progress across all development areas and completed tasks.
                        </p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Communication Section -->
        <h2 class="section-title">Communication</h2>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-comments action-icon"></i>
                        <h3 class="action-title">Live Chat</h3>
                        <p class="action-description">
                            Communicate with your mentors in real-time. Get instant feedback and answers.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-calendar-plus action-icon"></i>
                        <h3 class="action-title">Request Meeting</h3>
                        <p class="action-description">
                            Request meetings with your mentors. Schedule sessions and track meeting status.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-calendar-alt action-icon"></i>
                        <h3 class="action-title">View Meetings</h3>
                        <p class="action-description">
                            View all your meeting requests and their current status.
                        </p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Current Active Project Section -->
        @php
            $activeProject = \App\Models\Project::where('mentee', $user->id)
                ->where('status', 'active')
                ->first();
        @endphp
        @if($activeProject)
        <h2 class="section-title">Current Active Project</h2>
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h4 class="mb-0">{{ $activeProject->title }}</h4>
                        <span class="badge bg-success">Active</span>
                    </div>
                    @if($activeProject->description)
                    <p class="text-muted mb-3">{{ Str::limit($activeProject->description, 150) }}</p>
                    @endif
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-user-tie me-1"></i>
                            Mentor: {{ $activeProject->ownerUser->name ?? 'N/A' }}
                        </small>
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $activeProject->project_date->format('M d, Y') }}
                        </small>
                    </div>
                    <a href="{{ route('projects.show', $activeProject) }}" class="btn btn-primary">
                        <i class="fas fa-eye me-1"></i>View Project Details
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Available Projects Section -->
        @if(isset($availableProjects) && $availableProjects->count() > 0 && !$activeProject)
        <h2 class="section-title">Available Projects</h2>
        <div class="row g-4 mb-5">
            @foreach($availableProjects as $project)
                <div class="col-md-4">
                    <div class="project-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h4 class="mb-0">{{ Str::limit($project->title, 30) }}</h4>
                            <span class="badge bg-warning text-dark">Available</span>
                        </div>
                        @if($project->description)
                        <p class="text-muted mb-3">{{ Str::limit($project->description, 100) }}</p>
                        @endif
                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-user-tie me-1"></i>
                                From: {{ $project->ownerUser->name ?? 'Mentor' }}
                            </small>
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $project->project_date->format('M d, Y') }}
                            </small>
                            @if($project->file)
                            <br>
                            <small class="text-success">
                                <i class="fas fa-file me-1"></i>
                                File attached
                            </small>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>View
                            </a>
                            <form method="POST" action="{{ route('projects.requestJoin', $project) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-hand-paper me-1"></i>Join
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @elseif(isset($availableProjects) && $availableProjects->count() > 0 && $activeProject)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            You have an active project. Complete your current project before joining another one.
        </div>
        @endif

        <!-- Task Completion Summary -->
        @if($stats['tasks_count'] > 0)
        <h2 class="section-title">Task Completion Summary</h2>
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="stat-card">
                    <h4 class="mb-4">
                        <i class="fas fa-chart-pie me-2" style="color: var(--primary-color);"></i>
                        Progress Overview
                    </h4>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Tasks:</span>
                            <strong>{{ $stats['tasks_count'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>In Progress:</span>
                            <strong class="text-warning">{{ $stats['pending_tasks'] }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Completed:</span>
                            <strong class="text-success">{{ $stats['completed_tasks'] }}</strong>
                        </div>
                        @php
                            $completion_rate = $stats['tasks_count'] > 0 ? round(($stats['completed_tasks'] / $stats['tasks_count']) * 100) : 0;
                        @endphp
                        <div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Completion Rate:</span>
                                <strong>{{ $completion_rate }}%</strong>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                     style="width: {{ $completion_rate }}%" 
                                     aria-valuenow="{{ $completion_rate }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ $completion_rate }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
