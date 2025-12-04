<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Register - Collator</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/collator.css') }}">

    <style>
        body {
            background-color: #f3f4f6;
        }
    </style>
    
</head>
<body>
<div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h2 class="fw-bold mb-0">Collator</h2>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title text-center mb-4">Create Your Account</h3>
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
                                <label for="name" class="form-label">Full Name</label>
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
                                <label for="email" class="form-label">Email Address</label>
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
                                <label for="phone" class="form-label">Phone <small class="text-muted">(Optional)</small></label>
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
                                <label for="bio" class="form-label">Bio <small class="text-muted">(Optional)</small></label>
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
                                <label for="type" class="form-label">User Type</label>
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
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
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
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
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
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                Already have an account? <strong>Login</strong>
                            </a>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="{{ url('/') }}" class="text-decoration-none">
                                <i class="fas fa-arrow-left me-1"></i>Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
