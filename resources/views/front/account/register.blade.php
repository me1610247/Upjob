@extends('front.layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        
        <!-- Success Message (for non-AJAX submission) -->
        @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow border-0 p-5" style="border-radius: 20px; background: linear-gradient(145deg, #ffffff, #f8f9fa);">
                    <div class="text-center mb-4">
                        <h1 class="h3 fw-bold text-gradient-primary">Create Your Account</h1>
                        <p class="text-muted">Join us today and start your journey</p>
                    </div>
                    
                    <form action="{{ route('account.RegisterProcess') }}" method="post" name="registrationForm" id="registrationForm">
                        @csrf
                        
                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-user text-primary"></i>
                                </span>
                                <input type="text" name="name" id="name" class="form-control border-start-0 ps-2" placeholder="Enter Your Full Name">
                            </div>
                            <p class="error-message invalid-feedback mt-1"></p>
                        </div> 
                        
                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-envelope text-primary"></i>
                                </span>
                                <input type="text" name="email" id="email" class="form-control border-start-0 ps-2" placeholder="Enter Your Email">
                            </div>
                            <p class="error-message invalid-feedback mt-1"></p>
                        </div> 
                        
                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control border-start-0 ps-2" placeholder="Create Password">
                                <span class="input-group-text bg-transparent border-start-0 cursor-pointer toggle-password">
                                    <i class="fas fa-eye text-primary"></i>
                                </span>
                            </div>
                            <p class="error-message invalid-feedback mt-1"></p>
                        </div> 
                        
                        <!-- Confirm Password Field -->
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="fas fa-lock text-primary"></i>
                                </span>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control border-start-0 ps-2" placeholder="Confirm Password">
                                <span class="input-group-text bg-transparent border-start-0 cursor-pointer toggle-password">
                                    <i class="fas fa-eye text-primary"></i>
                                </span>
                            </div>
                            <p class="error-message invalid-feedback mt-1"></p>
                        </div> 
                        
                        <!-- Terms and Conditions -->
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">I agree to the <a href="#" class="text-decoration-none">Terms & Conditions</a></label>
                        </div>
                        
                        <!-- Register Button -->
                        <div class="mb-4">
                            <button class="btn btn-primary btn-lg w-100 py-2 fw-bold shadow-sm" type="submit">
                                <span class="me-2">Register Now</span>
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>
                    </form>                    
                </div>
                
                <!-- Login Link -->
                <div class="mt-4 text-center">
                    <p class="text-muted">Already have an account? <a href="{{route('account.login')}}" class="text-decoration-none fw-semibold text-primary">Login Here</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
$(document).ready(function() {
    // Toggle Password Visibility
    $(".toggle-password").click(function() {
        const input = $(this).closest('.input-group').find('input');
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Form Submission
    $("#registrationForm").submit(function(e) {
        e.preventDefault();
        
        // Clear previous errors
        $(".error-message").html("").removeClass('d-block');
        $(".is-invalid").removeClass('is-invalid');
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'post',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response) {
                if (response.status == false) {
                    // Handle errors
                    $.each(response.errors, function(key, value) {
                        $("#"+key).addClass('is-invalid')
                            .siblings('.error-message')
                            .addClass('d-block')
                            .html(value);
                    });
                } else {
                    // Success - redirect to login
                    window.location.href = '{{ route("account.login") }}';
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred. Please try again.");
            }
        });
    });
});
</script>
@endsection