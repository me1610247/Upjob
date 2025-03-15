@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-light">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-white rounded-3 p-3 mb-4 shadow-sm">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-secondary">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Success/Error Messages -->
                @include('front.layouts.message')

                <!-- Profile Update Form -->
                <div class="card border-0 shadow mb-4">
                    <form action="{{ route('account.updateProfile') }}" method="POST" id="userForm" name="userForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-4 fw-bold">My Profile</h3>
                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold">Name*</label>
                                <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" value="{{ $user->name }}">
                                <p class="text-danger mt-1" id="name-error"></p>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">Email*</label>
                                <input type="text" name="email" id="email" value="{{ $user->email }}" placeholder="Enter Email" class="form-control">
                                <p class="text-danger mt-1" id="email-error"></p>
                            </div>
                            <div class="mb-4">
                                <label for="designation" class="form-label fw-bold">Designation</label>
                                <input type="text" name="designation" value="{{ $user->designation }}" placeholder="Designation" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label for="mobile" class="form-label fw-bold">Mobile</label>
                                <input type="text" name="mobile" value="{{ $user->mobile }}" placeholder="Mobile" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer p-4 bg-light">
                            <button type="submit" class="btn btn-primary btn-lg">Update</button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Form -->
                <div class="card border-0 shadow mb-4">
                    <form action="" method="post" name="changePasswordForm" id="changePasswordForm">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-4 fw-bold">Change Password</h3>
                            <div class="mb-4">
                                <label for="old_password" class="form-label fw-bold">Old Password*</label>
                                <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                <p class="text-danger mt-1" id="old_password-error"></p>
                            </div>
                            <div class="mb-4">
                                <label for="new_password" class="form-label fw-bold">New Password* <span class="text-muted">(must be at least 6 chars and have numbers & symbols)</span></label>
                                <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                <p class="text-danger mt-1" id="new_password-error"></p>
                            </div>
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label fw-bold">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control">
                                <p class="text-danger mt-1" id="confirm_password-error"></p>
                            </div>
                        </div>
                        <div class="card-footer p-4 bg-light">
                            <button type="submit" class="btn btn-primary btn-lg">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
    $("#userForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("account.updateProfile") }}',
            type: 'put',
            data: $("#userForm").serializeArray(),
            dataType: 'json',
            success: function(response){
                if (response.status == false) {
                    var errors=response.errors;
                    if(errors.name){
                        $("#name").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.name)
                    }else{
                        $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html(errors.name)
                    }
                    if(errors.email){
                        $("#email").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.email)
                    }else{
                        $("#email").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html(errors.email)
                    }
                   
                }else{
                    $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('');
                     $("#email").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('');
                    window.location.href='{{route("account.profile")}}'

                }
            }
        });
    })
    $("#changePasswordForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("account.updatePassword") }}',
            type: 'post',
            data: $("#changePasswordForm").serializeArray(),
            dataType: 'json',
            success: function(response) {
                // If validation fails, display the errors
                if (response.status == false) {
                    var errors = response.errors;
                    // remove the errors text from the fields that doesn't have error
                    $(".form-control").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        var firstInvalidField = null;
                        // add the error text on the fields that isn't complete yet
                    $.each(errors, function(key, error) {
                      var field = $("#" + key).addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(error[0]); 
                            if (!firstInvalidField) {
                            firstInvalidField = field;
                    }
                    }); 
                    // to make the window focus on the error if there is
                    if (firstInvalidField) {
                    $('html, body').animate({
                        scrollTop: firstInvalidField.offset().top - 100 
                    }, 500);

                    firstInvalidField.focus();
                }
                } else {
                    window.location.href = response.redirect_url;
                }
            }
        });
    })

</script>
@endsection