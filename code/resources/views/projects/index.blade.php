<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>My Projects - Collator</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .project-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: .75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,.05);
            transition: all .2s ease-in-out;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,.1);
        }
        .project-card-img-top {
            height: 180px;
            object-fit: cover;
            border-top-left-radius: .75rem;
            border-top-right-radius: .75rem;
        }
        .project-card-body {
            flex-grow: 1;
            padding: 1.5rem;
        }
        .project-card-title {
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: .5rem;
        }
        .project-card-author {
            color: #6c757d;
            font-size: .9rem;
            margin-bottom: 1rem;
        }
        .project-card-footer {
            padding: 1rem 1.5rem;
            background-color: #fff;
            border-top: 1px solid #e9ecef;
            border-bottom-left-radius: .75rem;
            border-bottom-right-radius: .75rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2">My Projects</h1>
            <div>
                @if($user->type === 'Mentor')
                <a href="{{ route('projects.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create New Project
                </a>
                @endif
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                </a>
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

        <div class="row">
            @if($projects->count() > 0)
                @foreach($projects as $project)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="project-card">
                            <img src="https://via.placeholder.com/350x150" class="project-card-img-top" alt="{{ $project->title }}">
                            <div class="project-card-body">
                                <h5 class="project-card-title">{{ $project->title }}</h5>
                                <p class="project-card-author">
                                    @if($user->type === 'Mentor')
                                        @if($project->mentee)
                                            Assigned to: {{ $project->menteeUser->name ?? 'N/A' }}
                                        @else
                                            General Project
                                        @endif
                                    @else
                                        From: {{ $project->ownerUser->name ?? 'Mentor' }}
                                    @endif
                                </p>
                                <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                            </div>
                            <div class="project-card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-primary btn-sm">View Project</a>
                                        @if($project->file)
                                            <a href="{{ route('projects.download', $project) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                    <div>
                                    @if($user->type === 'Mentor' && $user->id == $project->owner)
                                        <form class="d-inline" action="{{ route('projects.destroy', $project) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
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
                </div>
            @endif
        </div>
    </div>

    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>