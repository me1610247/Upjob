@extends('front.layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>

        <!-- Success and Error Messages -->
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p class="mb-0 pb-0">{{ Session::get('error') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row d-flex justify-content-center align-items-center">
            <!-- Image Column (Left Side) -->
            <div class="col-lg-6 col-md-6 order-md-1 d-none d-md-block">
                <div class="text-center">
                    <img src="{{ asset('assets/images/mobile-login-concept-illustration_114360-83.jpg') }}" alt="Login Illustration" class="img-fluid rounded-4 shadow" style="max-width: 100%; height: auto; transform: perspective(1000px) rotateY(-10deg);">
                </div>
            </div>

            <!-- Login Form Column (Right Side) -->
            <div class="col-lg-5 col-md-6 order-md-2">
                <div class="card shadow border-0 p-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f8f9fa);">
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold text-gradient-primary">Welcome Back</h1>
                        <p class="text-muted">Sign in to access your account</p>
                    </div>
                    
                    <form action="{{ route('account.authenticate') }}" method="post">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input type="text" value="{{ old('email') }}" name="email" id="email" class="form-control @error('email') is-invalid @enderror border-start-0 ps-2" placeholder="Enter Your Email">
                            </div>
                            @error('email')
                                <p class="invalid-feedback d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror border-start-0 ps-2" placeholder="Enter Your Password">
                                <span class="input-group-text bg-transparent border-start-0 cursor-pointer" id="togglePassword">
                                    <i class="fas fa-eye text-primary"></i>
                                </span>
                            </div>
                            @error('password')
                                <p class="invalid-feedback d-block">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <a href="{{ route('account.forgetPassword') }}" class="text-decoration-none text-primary fw-semibold">Forgot Password?</a>
                        </div>

                        <!-- Login Button -->
                        <div class="mb-4">
                            <button class="btn btn-primary btn-lg w-100 py-2 fw-bold shadow-sm" type="submit">
                                <span class="me-2">Login</span>
                                <i class="fas fa-sign-in-alt"></i>
                            </button>
                        </div>
                        
                        <!-- Social Login -->
                        <div class="text-center mb-4">
                            <p class="text-muted mb-3">Or sign in with</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="#" class="btn btn-outline-primary rounded-circle p-2 shadow-sm">
                                    <i class="fab fa-google"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary rounded-circle p-2 shadow-sm">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary rounded-circle p-2 shadow-sm">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="btn btn-outline-primary rounded-circle p-2 shadow-sm">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Register Link -->
                <div class="mt-4 text-center">
                    <p class="text-muted">Don't have an account? <a href="{{ route('account.register') }}" class="text-decoration-none fw-semibold text-primary">Register Now</a></p>
                </div>
            </div>
        </div>

        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    // Toggle Password Visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
    
    // Add animation on form load
    document.addEventListener('DOMContentLoaded', function() {
        const card = document.querySelector('.card');
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 100);
    });
</script>
@endsection