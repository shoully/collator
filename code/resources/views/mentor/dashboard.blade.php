<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Mentor Dashboard - ShareHub</title>
    
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
                        <a class="nav-link" href="{{ route('adminDashboard', ['project_id' => $selectedProject->id ?? '']) }}">Dashboard</a>
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
                Mentor Dashboard - {{ $selectedProject->title ?? 'No Project Selected' }}
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
        <!-- Statistics Section -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-number">{{ $stats['mentees_count'] }}</div>
                    <div class="stat-label">Mentees</div>
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
                <a href="{{ route('home2') }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-users action-icon"></i>
                        <h3 class="action-title">View My Mentees</h3>
                        <p class="action-description">
                            View and manage all your mentees. See their progress, tasks, and development areas.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-briefcase action-icon"></i>
                        <h3 class="action-title">My Workspace</h3>
                        <p class="action-description">
                            Access your main workspace to create tasks, manage mentorings, and view documents.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('projects.create') }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-folder-plus action-icon"></i>
                        <h3 class="action-title">Create New Project</h3>
                        <p class="action-description">
                            Create a new project to organize and manage work with your mentees. Add files and track progress.
                        </p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Management Actions Section -->
        <h2 class="section-title">Management Actions</h2>
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <a href="{{ route('projects.index') }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-folder-open action-icon"></i>
                        <h3 class="action-title">My Projects</h3>
                        <p class="action-description">
                            View and manage all your projects. Organize work, track progress, and share with mentees.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-project-diagram action-icon"></i>
                        <h3 class="action-title">Areas to Develop</h3>
                        <p class="action-description">
                            Create and manage development areas for your mentees. Track progress and set goals.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-tasks action-icon"></i>
                        <h3 class="action-title">Create Tasks</h3>
                        <p class="action-description">
                            Assign tasks to your mentees with priorities and track their completion status.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-file-alt action-icon"></i>
                        <h3 class="action-title">Share Documents</h3>
                        <p class="action-description">
                            Upload and share documents with your mentees. Keep all resources organized.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-comments action-icon"></i>
                        <h3 class="action-title">Live Chat</h3>
                        <p class="action-description">
                            Communicate with your mentees in real-time. Get instant feedback and answers.
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('home', ['project_id' => $selectedProject->id ?? '']) }}" class="action-card">
                    <div class="text-center">
                        <i class="fas fa-calendar-alt action-icon"></i>
                        <h3 class="action-title">Manage Meetings</h3>
                        <p class="action-description">
                            View and manage meeting requests. Update status and schedule sessions.
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
                            Monitor your mentees' progress across all development areas and tasks.
                        </p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

