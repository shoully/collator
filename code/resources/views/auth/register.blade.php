<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Register - ShareHub</title>
    
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
        
        .auth-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }
        
        .auth-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        
        .auth-header h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .auth-header p {
            margin: 0;
            opacity: 0.9;
        }
        
        .auth-body {
            padding: 40px 30px;
            max-height: 80vh;
            overflow-y: auto;
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
            width: 100%;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.4);
        }
        
        .btn-link-custom {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .btn-link-custom:hover {
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .back-to-home {
            text-align: center;
            margin-top: 20px;
        }
        
        .back-to-home a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-home a:hover {
            text-decoration: underline;
        }
        
        .logo-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        
        .form-text {
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <i class="fas fa-project-diagram logo-icon"></i>
            <h2>Create Account</h2>
            <p>Join ShareHub today</p>
        </div>
        
        <div class="auth-body">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-2"></i>Full Name
                    </label>
                    <input 
                        id="name" 
                        class="form-control" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        required 
                        autofocus
                        placeholder="Enter your full name"
                    />
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>Email Address
                    </label>
                    <input 
                        id="email" 
                        class="form-control" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required
                        placeholder="Enter your email"
                    />
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <label for="phone" class="form-label">
                        <i class="fas fa-phone me-2"></i>Phone <small class="text-muted">(Optional)</small>
                    </label>
                    <input 
                        id="phone" 
                        class="form-control" 
                        type="text" 
                        name="phone" 
                        value="{{ old('phone') }}"
                        placeholder="Enter your phone number"
                    />
                </div>

                <!-- Bio -->
                <div class="mb-3">
                    <label for="bio" class="form-label">
                        <i class="fas fa-info-circle me-2"></i>Bio <small class="text-muted">(Optional)</small>
                    </label>
                    <textarea 
                        id="bio" 
                        class="form-control" 
                        name="bio" 
                        rows="2"
                        placeholder="Tell us about yourself"
                    >{{ old('bio') }}</textarea>
                </div>

                <!-- User Type -->
                <div class="mb-3">
                    <label for="type" class="form-label">
                        <i class="fas fa-user-tag me-2"></i>User Type
                    </label>
                    <select 
                        id="type" 
                        name="type" 
                        class="form-select" 
                        required
                    >
                        <option value="">Select User Type</option>
                        <option value="Mentor" {{ old('type') == 'Mentor' ? 'selected' : '' }}>Mentor</option>
                        <option value="Mentee" {{ old('type') == 'Mentee' ? 'selected' : '' }}>Mentee</option>
                        <option value="guest" {{ old('type') == 'guest' ? 'selected' : '' }}>Guest</option>
                    </select>
                    <div class="form-text">Choose your role in the platform</div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i>Password
                    </label>
                    <input 
                        id="password" 
                        class="form-control"
                        type="password"
                        name="password"
                        required 
                        autocomplete="new-password"
                        placeholder="Enter your password"
                    />
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">
                        <i class="fas fa-lock me-2"></i>Confirm Password
                    </label>
                    <input 
                        id="password_confirmation" 
                        class="form-control"
                        type="password"
                        name="password_confirmation" 
                        required
                        placeholder="Confirm your password"
                    />
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary-custom text-white">
                        <i class="fas fa-user-plus me-2"></i>Register
                    </button>
                </div>
            </form>
            
            <div class="back-to-home">
                <a href="{{ route('login') }}">
                    Already have an account? <strong>Login</strong>
                </a>
            </div>
            
            <div class="back-to-home">
                <a href="{{ url('/') }}">
                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
