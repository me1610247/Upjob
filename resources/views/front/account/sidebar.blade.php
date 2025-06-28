<style>
    /* Custom CSS for Hover Effects */
.hover-effect {
    transition: all 0.3s ease;
}

.hover-effect:hover {
    background-color: #f8f9fa; /* Light gray background on hover */
    transform: translateY(-2px); /* Slight lift effect */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow on hover */
}

/* Hover effect for buttons */
.btn.hover-effect:hover {
    background-color: #0056b3; /* Darker blue for primary button */
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-danger.hover-effect:hover {
    background-color: #c82333; /* Darker red for danger button */
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Hover effect for links */
.list-group-item a:hover {
    color: #007bff; /* Change link color on hover */
}
</style>
<div class="card border-0 shadow mb-4 p-3">
    <!-- Profile Section -->
    <div class="s-body text-center mt-3">
        @if(Auth::check())
            <!-- Profile Picture -->
            @if(Auth::user()->image != '')
                <img src="{{ asset('profile_pic/' . Auth::user()->image) }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
            @else
                <img src="{{ asset('assets/images/avatar7.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
            @endif

            <!-- User Name and Designation -->
            <h5 class="mt-3 pb-0 fw-bold">{{ Auth::user()->name }}</h5>
            <p class="text-muted mb-1 fs-6">{{ Auth::user()->designation }}</p>

            <!-- Change Profile Picture Button -->
            <div class="d-flex justify-content-center mb-2">
                <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary btn-sm hover-effect">
                    Change Profile Picture
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Navigation Links -->
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <!-- Notifications -->
            <li class="list-group-item d-flex justify-content-between align-items-center p-3 hover-effect">
                <a href="{{ route('jobs.applied') }}" class="text-decoration-none text-dark">
                    <i class="fas fa-bell me-2"></i>Notifications
                </a>
            </li>

            <!-- Find a Property -->
            <li class="list-group-item d-flex justify-content-between align-items-center p-3 hover-effect">
                <a href="{{ route('jobs') }}" class="text-decoration-none text-dark">
                    <i class="fas fa-search me-2"></i>Find a Property
                </a>
            </li>

            <!-- My Property -->
            <li class="list-group-item d-flex justify-content-between align-items-center p-3 hover-effect">
                <a href="{{ route('account.myJobs') }}" class="text-decoration-none text-dark">
                    <i class="fas fa-home me-2"></i>My Property
                </a>
            </li>

            <!-- Property Purchased -->
            <li class="list-group-item d-flex justify-content-between align-items-center p-3 hover-effect">
                <a href="{{ route('account.myAppliedJobs') }}" class="text-decoration-none text-dark">
                    <i class="fas fa-shopping-cart me-2"></i>Property Booked
                </a>
            </li>

            <!-- Saved Property -->
            <li class="list-group-item d-flex justify-content-between align-items-center p-3 hover-effect">
                <a href="{{ route('account.savedJobs') }}" class="text-decoration-none text-dark">
                    <i class="fas fa-heart me-2"></i>Saved Property
                </a>
            </li>

            <!-- Logout Button -->
            <li class="list-group-item p-3 hover-effect">
                <button class="btn btn-danger w-100 hover-effect">
                    <a class="text-white text-decoration-none" href="{{ route('account.logout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </button>
            </li>
        </ul>
    </div>
</div>