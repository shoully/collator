<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Mentee Dashboard - Collator</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/collator.css') }}">
    
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}" style="color: #4f46e5; font-size: 1.5rem;">
                <i class="fas fa-cubes me-2"></i>Collator
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard', ['project_id' => $selectedProject->id ?? '']) }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('workspace', $selectedProject) }}">Workspace</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary ms-2">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="project-header">
        <div class="container">
            <h1 class="display-5 fw-bold">Welcome, {{ $user->name }}!</h1>
            <p class="fs-4">
                Mentee Dashboard - {{ $selectedProject->title ?? 'No Project Selected' }}
                @if(isset($selectedProject))
                    <span class="badge bg-light text-dark ms-2">{{ ucfirst($selectedProject->status) }}</span>
                @endif
            </p>
            @if(isset($selectedProject))
            <div class="mt-3">
                <a href="{{ route('projects.select') }}" class="btn btn-outline-light">
                    <i class="fas fa-exchange-alt me-1"></i>Change Project
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
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
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-user-tie fa-3x text-primary mb-3"></i>
                        <h3 class="card-title h1 fw-bold">{{ $stats['mentors_count'] }}</h3>
                        <p class="card-text text-muted">My Mentors</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-tasks fa-3x text-primary mb-3"></i>
                        <h3 class="card-title h1 fw-bold">{{ $stats['tasks_count'] }}</h3>
                        <p class="card-text text-muted">Total Tasks</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                        <h3 class="card-title h1 fw-bold">{{ $stats['pending_tasks'] }}</h3>
                        <p class="card-text text-muted">Pending Tasks</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h3 class="card-title h1 fw-bold">{{ $stats['completed_tasks'] }}</h3>
                        <p class="card-text text-muted">Completed</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <h2 class="mb-4">Quick Actions</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-briefcase me-2 text-primary"></i>
                            <a href="{{ route('workspace', $selectedProject) }}" class="text-decoration-none">My Workspace</a>
                        </h5>
                        <p class="card-text">Access your main workspace to view tasks, development areas, documents, and chat with your mentors.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-folder-open me-2 text-primary"></i>
                            <a href="{{ route('projects.index') }}" class="text-decoration-none">My Projects</a>
                        </h5>
                        <p class="card-text">View all your assigned projects and available projects from your mentors.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-tasks me-2 text-primary"></i>
                            <a href="{{ route('workspace', $selectedProject) }}" class="text-decoration-none">View My Tasks</a>
                        </h5>
                        <p class="card-text">See all your tasks, track progress, and mark tasks as completed.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
