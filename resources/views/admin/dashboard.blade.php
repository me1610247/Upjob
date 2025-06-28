@extends('front.layouts.app')

@section('main')
    <section class="admin-dashboard">
        <!-- Gradient Background Section -->
        <div class="dashboard-header py-5 background:silver">

        </div>

        <!-- Dashboard Content Section -->
        <div class="dashboard-content py-5">
            <div class="container">
                @include('front.layouts.message')
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!-- Welcome Card -->
                        <div class="card border-0 shadow-lg mb-5 animate__animated animate__fadeIn"
                            style="border-radius: 15px; margin-top: -50px; border: none;">
                            <div class="card-body p-4 text-center">
                                <div class="avatar-container mb-3">
                                    <div class="avatar-circle">
                                        <i class="fas fa-user-shield text-white"></i>
                                    </div>
                                </div>
                                <h2 class="h1 mb-3 text-gradient"
                                    style="background: linear-gradient(135deg, #66ea9d 0%, #4ba24f 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                    Welcome Admin</h2>
                                <p class="lead text-muted">Manage your platform efficiently</p>

                                <!-- Upload Excel Form -->
                                <form action="{{ route('admin.jobs.import') }}" method="POST" enctype="multipart/form-data"
                                    class="mt-4">
                                    @csrf
                                    <div class="input-group mb-3 w-75 mx-auto">
                                        <input type="file" name="excel_file" class="form-control" accept=".xlsx,.xls"
                                            required>
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-upload me-1"></i> Upload Properties Sheet
                                        </button>
                                    </div>
                                    @if (session('success'))
                                        <div class="alert alert-success mt-3">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>


                        <!-- Stats Cards -->
                        <div class="row g-4">
                            <!-- Users Card -->
                            <div class="col-md-4">
                                <div class="card stat-card h-100 border-0 shadow-sm hover-effect"
                                    style="border-radius: 12px; border-left: 4px solid #4e73df;">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="icon-circle bg-primary-light">
                                                <i class="fas fa-users text-primary"></i>
                                            </div>
                                            <h5 class="card-title ms-3 mb-0">Manage Users</h5>
                                        </div>
                                        <p class="card-text text-muted">View, edit, and manage all registered users on your
                                            platform.</p>
                                        <a href="{{ route('admin.users') }}" class="btn btn-primary btn-sm stretched-link">
                                            Go to Users <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Jobs Card -->
                            <div class="col-md-4">
                                <div class="card stat-card h-100 border-0 shadow-sm hover-effect"
                                    style="border-radius: 12px; border-left: 4px solid #1cc88a;">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="icon-circle bg-success-light">
                                                <i class="fas fa-home text-success"></i>
                                            </div>
                                            <h5 class="card-title ms-3 mb-0">Manage Property</h5>
                                        </div>
                                        <p class="card-text text-muted">Review and manage all Property listings posted on your
                                            platform.</p>
                                        <a href="{{ route('admin.jobs') }}" class="btn btn-success btn-sm stretched-link">
                                            Go to Property <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Applications Card -->
                            <div class="col-md-4">
                                <div class="card stat-card h-100 border-0 shadow-sm hover-effect"
                                    style="border-radius: 12px; border-left: 4px solid #f6c23e;">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="icon-circle bg-warning-light">
                                                <i class="fas fa-file-alt text-warning"></i>
                                            </div>
                                            <h5 class="card-title ms-3 mb-0">Applications</h5>
                                        </div>
                                        <p class="card-text text-muted">Monitor and manage all job applications submitted by
                                            users.</p>
                                        <a href="{{ route('admin.applications') }}"
                                            class="btn btn-warning btn-sm stretched-link">
                                            Go to Applications <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Stats Section -->
                        <div class="row mt-4 g-4">
                            <!-- Quick Stats -->
                            <div class="col-md-6">
                                <a href="{{ route('charts.view') }}" style="text-decoration: none; color: inherit;">
                                    <div class="card border-0 shadow-sm h-100"
                                        style="border-radius: 12px; transition: 0.3s; cursor: pointer;">
                                        <div class="card-body p-4">
                                            <h5 class="card-title mb-4 d-flex align-items-center">
                                                <i class="fas fa-chart-line text-info me-2"></i> Platform Statistics
                                            </h5>
                                            <div class="row text-center">
                                                <div class="col-6 mb-4">
                                                    <div class="stat-number text-primary">{{ $stats['total_users'] }}</div>
                                                    <div class="stat-label">Total Users</div>
                                                </div>
                                                <div class="col-6 mb-4">
                                                    <div class="stat-number text-success">{{ $stats['active_jobs'] }}</div>
                                                    <div class="stat-label">Active Properties</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="stat-number text-warning">{{ $stats['applications'] }}</div>
                                                    <div class="stat-label">Applications</div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="stat-number text-info">92%</div>
                                                    <div class="stat-label">Satisfaction</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>


                            <!-- Recent Activity -->
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                                    <div class="card-body p-4">
                                        <h5 class="card-title mb-4 d-flex align-items-center">
                                            <i class="fas fa-bell text-danger me-2"></i> Recent Activity
                                        </h5>
                                        <div class="activity-list">
                                            <div class="activity-item mb-3">
                                                <div class="activity-icon bg-primary-light">
                                                    <i class="fas fa-user-plus text-primary"></i>
                                                </div>
                                                <div class="activity-content">
                                                    <span class="fw-semibold">5 new users</span> registered today
                                                    <div class="activity-time text-muted small">2 hours ago</div>
                                                </div>
                                            </div>
                                            <div class="activity-item mb-3">
                                                <div class="activity-icon bg-success-light">
                                                    <i class="fas fa-briefcase text-success"></i>
                                                </div>
                                                <div class="activity-content">
                                                    <span class="fw-semibold">12 new jobs</span> posted
                                                    <div class="activity-time text-muted small">5 hours ago</div>
                                                </div>
                                            </div>
                                            <div class="activity-item">
                                                <div class="activity-icon bg-warning-light">
                                                    <i class="fas fa-file-alt text-warning"></i>
                                                </div>
                                                <div class="activity-content">
                                                    <span class="fw-semibold">28 applications</span> submitted
                                                    <div class="activity-time text-muted small">Today</div>
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
        </div>
    </section>
@endsection

@section('customCss')
    <style>
        /* Custom CSS for Admin Dashboard */
        .admin-dashboard {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-header {
            color: white;
            margin-bottom: 50px;
        }

        .avatar-container {
            display: flex;
            justify-content: center;
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .hover-effect:hover {
            transform: translateY(-3px);
            transition: all 0.3s ease;
        }

        .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .bg-primary-light {
            background-color: rgba(78, 115, 223, 0.1);
        }

        .bg-success-light {
            background-color: rgba(28, 200, 138, 0.1);
        }

        .bg-warning-light {
            background-color: rgba(246, 194, 62, 0.1);
        }

        .bg-info-light {
            background-color: rgba(54, 185, 204, 0.1);
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .activity-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .activity-content {
            flex-grow: 1;
        }

        .activity-time {
            font-size: 0.8rem;
            margin-top: 3px;
        }

        .stretched-link::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1;
            content: "";
        }

        .btn-sm {
            padding: 0.35rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
        }
    </style>
@endsection

@section('customJs')
    <script>
        // Add any custom JavaScript here
        $(document).ready(function() {
            // Animation on page load
            $('.animate__animated').each(function(index) {
                $(this).delay(100 * index).queue(function() {
                    $(this).addClass('animate__fadeIn').dequeue();
                });
            });

            // Tooltip initialization
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
