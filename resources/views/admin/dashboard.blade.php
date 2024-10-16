@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4 bg-white shadow-sm">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <section class="section-5 bg-2 d-flex align-items-center justify-content-center">
            <div class="container">
            <div class="row justify-content-center">
            <div class="col-lg-9 text-center">
                @include('front.layouts.message')
                <div class="card border-0 shadow mb-4">
                    <div class="card-body text-center dashboard">
                        <p class="h2 mb-4">Welcome Admin</p>
                        <div class="row equal-height-cards">
                            <div class="col-md-4 mb-4">
                                <div class="card stat-card shadow-sm">
                                    <div class="card-body">
                                        <i class="fas fa-users fa-2x text-success mb-3"></i>
                                        <h5 class="card-title">Manage Users</h5>
                                        <p class="card-text">Manage registered users on the platform.</p>
                                        <a href="{{route('admin.users')}}" class="btn btn-success btn-sm">Go to Users</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card stat-card shadow-sm">
                                    <div class="card-body">
                                        <i class="fas fa-briefcase fa-2x text-secondary mb-3"></i>
                                        <h5 class="card-title">Manage Jobs</h5>
                                        <p class="card-text">View and edit jobs listed on the platform.</p>
                                        <a href="{{route('admin.jobs')}}" class="btn btn-light bg-dark text-light btn-sm">Go to Jobs</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card stat-card shadow-sm">
                                    <div class="card-body">
                                        <i class="fas fa-file-alt fa-2x text-warning mb-3"></i>
                                        <h5 class="card-title">Applications</h5>
                                        <p class="card-text">View user applications and applied on.</p>
                                        <a href="{{route('admin.applications')}}" class="btn btn-warning btn-sm">Go to Application</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>              
            </div>
        </div>
    </div>
</div>
</section>
</section>

@endsection

@section('customJs')
<!-- Add custom JS here if needed -->
@endsection
