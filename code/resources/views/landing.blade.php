<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>ShareHub - Project Management & Mentoring Platform</title>
    
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
            color: #333;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            min-height: 90vh;
            display: flex;
            align-items: center;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }
        
        .feature-card {
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            padding: 12px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: #4338ca;
            transform: scale(1.05);
        }
        
        .btn-outline-custom {
            border: 2px solid white;
            color: white;
            padding: 12px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .btn-outline-custom:hover {
            background: white;
            color: var(--primary-color);
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 3rem;
            color: var(--dark-color);
        }
        
        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/" style="color: var(--primary-color); font-size: 1.5rem;">
                <i class="fas fa-project-diagram me-2"></i>ShareHub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
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
                                    <a href="{{ route('register') }}" class="btn btn-primary-custom ms-2 text-white">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Manage Projects & Mentor People</h1>
                    <p class="hero-subtitle">
                        ShareHub is your all-in-one platform for effective project management and meaningful mentoring relationships. 
                        Connect mentors with mentees, track progress, and achieve your goals together.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary-custom text-white">
                                <i class="fas fa-rocket me-2"></i>Get Started
                            </a>
                        @endif
                        <a href="#features" class="btn btn-outline-custom">
                            <i class="fas fa-info-circle me-2"></i>Learn More
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <i class="fas fa-users-cog" style="font-size: 15rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5" style="background: #f8f9fa;">
        <div class="container py-5">
            <h2 class="text-center section-title">Powerful Features</h2>
            <div class="row g-4 mt-4">
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center">
                            <i class="fas fa-tasks feature-icon"></i>
                            <h4 class="card-title">Project Management</h4>
                            <p class="card-text">
                                Organize tasks, set priorities, and track progress with our intuitive project management tools. 
                                Keep everything in one place and stay on top of your goals.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center">
                            <i class="fas fa-user-tie feature-icon"></i>
                            <h4 class="card-title">Mentoring Relationships</h4>
                            <p class="card-text">
                                Connect mentors with mentees and build meaningful mentoring relationships. 
                                Track development areas and monitor progress throughout the mentoring cycle.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center">
                            <i class="fas fa-comments feature-icon"></i>
                            <h4 class="card-title">Real-Time Chat</h4>
                            <p class="card-text">
                                Communicate instantly with real-time chat functionality. 
                                Stay connected with your mentor or mentee and get instant feedback.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center">
                            <i class="fas fa-file-alt feature-icon"></i>
                            <h4 class="card-title">Document Sharing</h4>
                            <p class="card-text">
                                Share documents securely with your mentor or mentee. 
                                Upload, download, and manage all your project files in one place.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-check feature-icon"></i>
                            <h4 class="card-title">Meeting Management</h4>
                            <p class="card-text">
                                Schedule and manage meetings with ease. 
                                Track meeting status, set reminders, and keep all meeting details organized.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line feature-icon"></i>
                            <h4 class="card-title">Progress Tracking</h4>
                            <p class="card-text">
                                Visualize your progress with intuitive dashboards and progress bars. 
                                See how far you've come and what's left to achieve.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-5">
        <div class="container py-5">
            <h2 class="text-center section-title">How It Works</h2>
            <div class="row g-4 mt-4">
                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">1</div>
                    </div>
                    <h5>Sign Up</h5>
                    <p>Create your account as a Mentor, Mentee, or Guest. Choose the role that best fits your needs.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">2</div>
                    </div>
                    <h5>Connect</h5>
                    <p>Mentors can connect with mentees and establish mentoring relationships. Start building your network.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">3</div>
                    </div>
                    <h5>Manage Projects</h5>
                    <p>Create tasks, set development areas, share documents, and schedule meetings. Everything in one place.</p>
                </div>
                <div class="col-md-3 text-center">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">4</div>
                    </div>
                    <h5>Achieve Goals</h5>
                    <p>Track your progress, communicate in real-time, and achieve your mentoring and project goals together.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="stat-number">90</div>
                    <p class="mb-0">Day Mentoring Cycles</p>
                </div>
                <div class="col-md-4">
                    <div class="stat-number">24/7</div>
                    <p class="mb-0">Real-Time Communication</p>
                </div>
                <div class="col-md-4">
                    <div class="stat-number">100%</div>
                    <p class="mb-0">Secure & Private</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-project-diagram me-2"></i>ShareHub</h5>
                    <p class="mb-0">Your platform for project management and mentoring relationships.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} ShareHub. All rights reserved.</p>
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

