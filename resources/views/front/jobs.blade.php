@extends('front.layouts.app')

@section('main')
<section class="property-listing py-5">
    <div class="container">
        <!-- Header with Sorting -->
        <div class="row align-items-center mb-4">
            <div class="col-6 col-md-10">
                <h2 class="fw-bold fs-3 mb-0 text-primary">Find Your Dream Property</h2>
            </div>
            <div class="col-6 col-md-2">
                <select name="sort" id="sort" class="form-select shadow-sm border-primary">
                    <option value="1" {{ Request::get('sort') == '1' ? 'selected' : '' }}>Latest</option>
                    <option value="0" {{ Request::get('sort') == '0' ? 'selected' : '' }}>Oldest</option>
                </select>
            </div>
        </div>

        <div class="row pt-4">
            <!-- Sidebar Filters -->
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="" name="searchForm" id="searchForm">
                    <div class="card border-0 shadow-lg p-4 rounded-4">
                        <h3 class="fs-5 fw-bold mb-4 text-secondary border-bottom pb-2">Search Filters</h3>
                        
                        <div class="mb-4">
                            <label for="keyword" class="form-label fw-semibold">Keywords</label>
                            <input value="{{ Request::get('keyword') }}" type="text" name="keyword" id="keyword"
                                placeholder="e.g. 'pool', 'garden'" class="form-control border-secondary">
                        </div>

                        <div class="mb-4">
                            <label for="location" class="form-label fw-semibold">Location</label>
                            <input value="{{ Request::get('location') }}" type="text" name="location" id="location"
                                placeholder="Enter location" class="form-control border-secondary">
                        </div>

                        <div class="mb-4">
                            <label for="category" class="form-label fw-semibold">Property Type</label>
                            <select name="category" id="category" class="form-select border-secondary">
                                <option value="">All Types</option>
                                @if ($categories)
                                    @foreach ($categories as $category)
                                        <option {{ Request::get('category') == $category->id ? 'selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">
                            <i class="fas fa-search me-2"></i> Search
                        </button>
                        <a href="{{ route('jobs') }}" class="btn btn-outline-secondary w-100 mt-3 py-2 rounded-pill">
                            <i class="fas fa-sync-alt me-2"></i> Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Main Content -->
            <div class="col-md-8 col-lg-9">
                <!-- Price Filter Bar -->
                <div class="card border-0 shadow-sm mb-4 rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-light">
                        <form action="{{ route('jobs') }}" method="GET" id="filterForm">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="min_price" class="form-label fw-semibold small">Min Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">EGP</span>
                                        <input type="number" class="form-control border-start-0" name="min_price"
                                            id="min_price" placeholder="0" value="{{ request('min_price') }}">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="max_price" class="form-label fw-semibold small">Max Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">EGP</span>
                                        <input type="number" class="form-control border-start-0" name="max_price"
                                            id="max_price" placeholder="Any" value="{{ request('max_price') }}">
                                    </div>
                                </div>

                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">
                                        <i class="fas fa-filter me-2"></i> Apply
                                    </button>
                                </div>

                                <div class="col-md-3 d-flex align-items-end">
                                    <a href="{{ route('jobs') }}" class="btn btn-outline-secondary w-100 py-2 rounded-pill">
                                        Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Property Listings -->
                <div class="property-listings">
                    @if ($jobs->isNotEmpty())
                        <div class="row g-4">
                            @foreach ($jobs as $job)
                                <div class="col-md-6 col-lg-4 mb-4 d-flex">
                                    <div class="card border-0 shadow-sm flex-fill h-100 property-card">
                                        <!-- Property Image with Badge -->
                                        <div class="position-relative">
                                            @php
                                                $staticImages = [
                                                    'assets/properties/prop1 (1).jpg',
                                                    'assets/properties/prop1 (2).jpg',
                                                    'assets/properties/prop1 (3).jpg',
                                                    'assets/properties/prop1 (4).jpg',
                                                    'assets/properties/prop1 (5).jpg',
                                                    'assets/properties/prop1 (6).jpg',
                                                    'assets/properties/prop1 (7).jpg',
                                                    'assets/properties/prop1 (8).jpg',
                                                    'assets/properties/prop1 (9).jpg',
                                                    'assets/properties/prop1 (10).jpg',
                                                ];
                                                $randomImage = $staticImages[array_rand($staticImages)];
                                            @endphp
                                            
                                            <img src="{{ asset($randomImage) }}" alt="{{ $job->title }}"
                                                class="card-img-top property-image">
                                            
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-success bg-opacity-90 text-white">
                                                    {{ $job->jobType->name }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Property Details -->
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h3 class="card-title fw-bold mb-1 text-dark">{{ $job->title }}</h3>
                                              
                                            </div>
                                            @if($job->salary)
                                            <span class="text-primary fw-bold">EGP {{ number_format($job->salary) }}</span>
                                            @else
                                            <button type="submit" class="btn btn-primary m-2 fw-bold rounded-pill">
                                             Contact Owner
                                            </button>
                                            @endif
                                            <p class="text-muted small mb-3">
                                                <i class="fas fa-building me-1 text-secondary"></i> 
                                                {{ Str::words($job->company_name, 4) }}
                                            </p>
                                            
                                            <p class="card-text text-muted mb-3 property-description">
                                                {{ Str::words($job->description, 12) }}
                                            </p>

                                            <!-- Property Features -->
                                            <div class="property-features mb-3">
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-map-marker-alt text-secondary me-2"></i>
                                                            <span class="small">{{ $job->location }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-home text-secondary me-2"></i>
                                                            <span class="small">{{ $job->category->name }}</span>
                                                        </div>
                                                    </div>
                                                    @if($job->residential_type)
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-door-open text-secondary me-2"></i>
                                                            <span class="small">{{ $job->residential_type }}</span>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($job->vacancy)
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-bed text-secondary me-2"></i>
                                                            <span class="small">{{ $job->vacancy }} Rooms</span>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($job->bathrooms)
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fas fa-bath text-secondary me-2"></i>
                                                            <span class="small">{{ $job->bathrooms }} Bath</span>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- View Details Button -->
                                            <div class="mt-auto pt-2">
                                                <a href="{{ route('details', $job->id) }}" 
                                                   class="btn btn-primary w-100 rounded-pill fw-semibold">
                                                   View Details <i class="fas fa-arrow-right ms-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-md-12">
                            <div class="alert alert-info text-center rounded-3" role="alert">
                                <i class="fas fa-info-circle me-2"></i> No properties match your search criteria
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $jobs->onEachSide(1)->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Custom Styles */
    .property-listing {
        background-color: #f8f9fa;
    }
    
    .property-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .property-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
    
    .property-image {
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .property-card:hover .property-image {
        transform: scale(1.03);
    }
    
    .property-features {
        background-color: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
    }
    
    .property-description {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .text-primary {
        color: #2c3e50 !important;
    }
    
    .btn-primary {
        background-color: #2c3e50;
        border-color: #2c3e50;
    }
    
    .btn-primary:hover {
        background-color: #1a252f;
        border-color: #1a252f;
    }
    
    .btn-outline-secondary {
        color: #2c3e50;
        border-color: #2c3e50;
    }
    
    .btn-outline-secondary:hover {
        background-color: #2c3e50;
        color: white;
    }
    
    .sidebar .card {
        position: sticky;
        top: 20px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.25rem rgba(44, 62, 80, 0.25);
    }
    
    .pagination .page-item.active .page-link {
        background-color: #2c3e50;
        border-color: #2c3e50;
    }
    
    .pagination .page-link {
        color: #2c3e50;
    }
</style>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

@endsection

@section('customJs')
    <script>
        $("#searchForm").submit(function(e) {
            e.preventDefault();

            var url = '{{ route('jobs') }}';
            var keyword = $("#keyword").val();
            var location = $("#location").val();
            var category = $("#category").val();
            var sort = $("#sort").val();
            var queryString = [];

            if (keyword != "") {
                queryString.push('keyword=' + encodeURIComponent(keyword));
            }
            if (location != "") {
                queryString.push('location=' + encodeURIComponent(location));
            }
            if (category != "") {
                queryString.push('category=' + encodeURIComponent(category));
            }

            if (queryString.length > 0) {
                url += '?' + queryString.join('&');
            }
            url += '&sort=' + sort;

            window.location.href = url;
        });

        $("#sort").change(function() {
            $("#searchForm").submit();
        });

        $("#experience").change(function() {
            $("#searchForm").submit();
        });
    </script>
@endsection
