<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Collator - Modern Mentorship & Project Management</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #10b981;
            --dark-color: #111827;
            --light-color: #f9fafb;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            color: #374151;
            background-color: var(--light-color);
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.05);
        }

        .hero-section {
            background-color: #fff;
            padding: 8rem 0;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            color: var(--dark-color);
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            color: #6b7280;
        }
        
        .feature-card {
            background-color: #fff;
            padding: 2.5rem;
            border-radius: .75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,.05);
            transition: all .2s ease-in-out;
            height: 100%;
            border: 1px solid #e5e7eb;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: .5rem;
            padding: .75rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
        }
        
        .btn-secondary {
             background-color: #fff;
             border: 1px solid #d1d5db;
             color: #374151;
             border-radius: .5rem;
            padding: .75rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .btn-secondary:hover {
            background-color: #f9fafb;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 4rem;
            color: var(--dark-color);
        }
        
        .footer {
            background: var(--dark-color);
            color: #d1d5db;
            padding: 3rem 0;
            font-size: .9rem;
        }

        .footer a {
            color: #9ca3af;
            text-decoration: none;
        }

        .footer a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/" style="color: var(--primary-color); font-size: 1.5rem;">
                <i class="fas fa-cubes me-2"></i>Collator
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Login</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary ms-3 text-white">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="hero-title">Unlock Your Potential Through Mentorship</h1>
                    <p class="hero-subtitle">
                        Collator is the modern platform for structured mentorship and collaborative project management. 
                        Empower your teams, track progress, and foster growth.
                    </p>
                    <div class="d-flex gap-3 justify-content-center">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary text-white">
                                <i class="fas fa-rocket me-2"></i>Get Started for Free
                            </a>
                        @endif
                        <a href="#features" class="btn btn-secondary">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container py-5">
            <h2 class="text-center section-title">Why Collator?</h2>
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body">
                            <div class="feature-icon"><i class="fas fa-graduation-cap"></i></div>
                            <h4 class="card-title mb-3">Structured Mentoring</h4>
                            <p class="card-text">
                                Establish clear development goals, track milestones, and provide continuous feedback within a structured mentoring framework.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body">
                            <div class="feature-icon"><i class="fas fa-tasks"></i></div>
                            <h4 class="card-title mb-3">Integrated Project Management</h4>
                            <p class="card-text">
                                Manage tasks, share documents, and collaborate on projects seamlessly. Keep mentoring and project work aligned in one place.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body">
                           <div class="feature-icon"><i class="fas fa-chart-pie"></i></div>
                            <h4 class="card-title mb-3">Actionable Insights</h4>
                            <p class="card-text">
                                Gain visibility into progress with intuitive dashboards. Measure the impact of mentorship on skill development and project success.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5 bg-white">
        <div class="container py-5">
            <h2 class="text-center section-title">Get Started in 3 Simple Steps</h2>
            <div class="row g-5 mt-5">
                <div class="col-md-4 text-center">
                    <div class="mb-4">
                        <div class="rounded-circle bg-primary-soft text-primary d-inline-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; font-size: 1.5rem; background-color: #e0e7ff; color: var(--primary-color);">
                             <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                    <h5>1. Create Your Account</h5>
                    <p class="text-muted">Sign up as a Mentor or Mentee and build your profile. It takes less than a minute.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; font-size: 1.5rem; background-color: #e0e7ff; color: var(--primary-color);">
                             <i class="fas fa-link"></i>
                        </div>
                    </div>
                    <h5>2. Connect & Collaborate</h5>
                    <p class="text-muted">Invite your team, connect with a mentor/mentee, and create your first project workspace.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="mb-4">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px; font-size: 1.5rem; background-color: #e0e7ff; color: var(--primary-color);">
                             <i class="fas fa-trophy"></i>
                        </div>
                    </div>
                    <h5>3. Achieve Your Goals</h5>
                    <p class="text-muted">Track progress, manage tasks, and communicate effectively to reach your development and project objectives.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} Collator. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="me-3">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
