<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Create New Project - ShareHub</title>
    
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
        
        .form-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }
        
        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
        }
        
        .btn-secondary-custom {
            background: #6c757d;
            border: none;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .btn-secondary-custom:hover {
            background: #5a6268;
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
                        <a class="nav-link" href="{{ route('project.select') }}">Dashboard</a>
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
            <h1 class="mb-0"><i class="fas fa-folder-plus me-2"></i>Create New Project</h1>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label">
                                <i class="fas fa-heading me-2"></i>Project Title *
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="title" 
                                name="title" 
                                value="{{ old('title') }}" 
                                required 
                                placeholder="Enter project title"
                            />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left me-2"></i>Description
                            </label>
                            <textarea 
                                class="form-control" 
                                id="description" 
                                name="description" 
                                rows="5"
                                placeholder="Describe the project..."
                            >{{ old('description') }}</textarea>
                        </div>

                        <!-- Project Date -->
                        <div class="mb-4">
                            <label for="project_date" class="form-label">
                                <i class="fas fa-calendar me-2"></i>Project Date *
                            </label>
                            <input 
                                type="date" 
                                class="form-control" 
                                id="project_date" 
                                name="project_date" 
                                value="{{ old('project_date', date('Y-m-d')) }}" 
                                required
                            />
                        </div>

                        <!-- Assign to Mentee (Optional) -->
                        <div class="mb-4">
                            <label for="mentee" class="form-label">
                                <i class="fas fa-user me-2"></i>Assign to Mentee (Optional)
                            </label>
                            <select class="form-select" id="mentee" name="mentee">
                                <option value="">No specific mentee (General project - available to all mentees)</option>
                                @foreach($mentees as $mentee)
                                    <option value="{{ $mentee->id }}" {{ old('mentee') == $mentee->id ? 'selected' : '' }}>
                                        {{ $mentee->name }} ({{ $mentee->email }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                Leave blank for a general project available to all mentees, or assign to a specific mentee. 
                                If you assign a mentee, a mentoring relationship will be automatically created.
                            </small>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <label for="file" class="form-label">
                                <i class="fas fa-file-upload me-2"></i>Project File (Optional)
                            </label>
                            <input 
                                type="file" 
                                class="form-control" 
                                id="file" 
                                name="file"
                                accept=".pdf,.doc,.docx,.txt,.zip,.rar"
                            />
                            <small class="form-text text-muted">Max file size: 10MB. Supported formats: PDF, DOC, DOCX, TXT, ZIP, RAR</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary-custom text-white">
                                <i class="fas fa-save me-2"></i>Create Project
                            </button>
                            <a href="{{ route('projects.index') }}" class="btn btn-secondary-custom text-white">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

