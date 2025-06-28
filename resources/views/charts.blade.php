@extends('front.layouts.app')

@section('main')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-5 fw-bold text-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                Platform Analytics Dashboard
            </h1>
            <p class="lead text-muted">Visual insights into your platform data</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Price Distribution Chart Card -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h3 class="h5 mb-0 d-flex align-items-center">
                        <i class="fas fa-chart-bar text-primary me-2"></i>
                        Price Distribution by Location
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 400px;">
                        <canvas id="priceChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Shows average salaries across different locations
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h3 class="h5 mb-0 d-flex align-items-center">
                        <i class="fas fa-tachometer-alt text-success me-2"></i>
                        Key Metrics
                    </h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column h-100 justify-content-between">
                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-primary-light me-3">
                                    <i class="fas fa-users text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Total Users</h6>
                                    <p class="h3 fw-bold mb-0">{{ $platformStats['total_users'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-warning-light me-3">
                                    <i class="fas fa-briefcase text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Active Properties</h6>
                                    <p class="h3 fw-bold mb-0">{{ $platformStats['active_jobs'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-circle bg-info-light me-3">
                                    <i class="fas fa-file-alt text-info"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Total Applications</h6>
                                    <p class="h3 fw-bold mb-0">{{ $platformStats['applications'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Popular Locations Chart Card -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h3 class="h5 mb-0 d-flex align-items-center">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                        Property Distribution by Location
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="locationChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Shows Property concentration across different areas
                </div>
            </div>
        </div>

        <!-- Job Types Distribution -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h3 class="h5 mb-0 d-flex align-items-center">
                        <i class="fas fa-tasks text-info me-2"></i>
                        Property Types Distribution
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 350px;">
                        <canvas id="jobTypeChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3 text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Breakdown of Properties by contract type
                </div>
            </div>
        </div>
    </div>
</div>

@section('customCss')
<style>
    .text-gradient {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    
    .bg-primary-light {
        background-color: rgba(78, 115, 223, 0.1);
    }
    
    .bg-warning-light {
        background-color: rgba(246, 194, 62, 0.1);
    }
    
    .bg-info-light {
        background-color: rgba(54, 185, 204, 0.1);
    }
    
    .card {
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Price Distribution Chart
        const priceCtx = document.getElementById('priceChart').getContext('2d');
        const priceChart = new Chart(priceCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($priceDistribution->pluck('location')) !!},
                datasets: [{
                    label: 'Average Salary',
                    data: {!! json_encode($priceDistribution->pluck('avg_salary')) !!},
                    backgroundColor: 'rgba(78, 115, 223, 0.7)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Avg Salary: $${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Location Distribution Chart
        const locationCtx = document.getElementById('locationChart').getContext('2d');
        const locationChart = new Chart(locationCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($popularLocations->pluck('location')) !!},
                datasets: [{
                    label: 'Property Count',
                    data: {!! json_encode($popularLocations->pluck('total')) !!},
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e',
                        '#e74a3b', '#858796', '#f8f9fc', '#5a5c69',
                        '#3a3b45', '#b7b9cc'
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} Properties (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Job Type Distribution Chart (example - you'll need to pass this data from controller)
        const jobTypeCtx = document.getElementById('jobTypeChart').getContext('2d');
        const jobTypeChart = new Chart(jobTypeCtx, {
            type: 'pie',
            data: {
                labels: ['Apartment', 'Townhouse', 'Villa', 'Duplex', 'Penthouse'],
                datasets: [{
                    label: 'Job Types',
                    data: [35, 25, 20, 15, 5],
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    });
</script>
@endsection
@endsection