@extends('front.layouts.app')

@section('main')
<section class="section-3 py-5 bg-light">
    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-6 col-md-10">
                <h2 class="fw-bold fs-3">Find Properties</h2>
            </div>
            <div class="col-6 col-md-2">
                <select name="sort" id="sort" class="form-select">
                    <option value="1" {{(Request::get('sort')=='1')?'selected':''}}>Latest</option>
                    <option value="0" {{(Request::get('sort')=='0')?'selected':''}}>Oldest</option>
                </select>
            </div>
        </div>

        <div class="row pt-4">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="" name="searchForm" id="searchForm">
                    <div class="card border-0 shadow p-4">
                        <div class="mb-4">
                            <h3 class="fs-5 fw-bold mb-3">Keywords</h3>
                            <input value="{{Request::get('keyword')}}" type="text" name="keyword" id="keyword" placeholder="Keywords" class="form-control">
                        </div>

                        <div class="mb-4">
                            <h3 class="fs-5 fw-bold mb-3">Location</h3>
                            <input value="{{Request::get('location')}}" type="text" name="location" id="location" placeholder="Location" class="form-control">
                        </div>

                        <div class="mb-4">
                            <h3 class="fs-5 fw-bold mb-3">Category</h3>
                            <select name="category" id="category" class="form-select">
                                <option value="">Select a Category</option>
                                @if($categories)
                                @foreach($categories as $category)
                                <option {{(Request::get('category')==$category->id)?'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                        <a href="{{route('jobs')}}" class="btn btn-secondary w-100 mt-3">Reset</a>
                    </div>
                </form>
            </div>

            <div class="col-md-8 col-lg-9">
                <!-- Filter Bar -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <form action="{{ route('jobs') }}" method="GET" id="filterForm">
                            <div class="row g-3">
                                <!-- Minimum Price -->
                                <div class="col-md-3">
                                    <input type="number" class="form-control form-control-lg" name="min_price" id="min_price" placeholder="Min Price" value="{{ request('min_price') }}">
                                </div>
            
                                <!-- Maximum Price -->
                                <div class="col-md-3">
                                    <input type="number" class="form-control form-control-lg" name="max_price" id="max_price" placeholder="Max Price" value="{{ request('max_price') }}">
                                </div>
            
                                <!-- Submit Button -->
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Filter</button>
                                </div>
            
                                <!-- Reset Button -->
                                <div class="col-md-3">
                                    <a href="{{ route('jobs') }}" class="btn btn-secondary btn-lg w-100">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            
                <!-- Job Listings -->
                <div class="job_listing_area">
                    <div class="job_lists">
                        <div class="row g-4">
                            @if($jobs->isNotEmpty())
                                @foreach($jobs as $job)
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card border-0 shadow-sm h-100">
                                            <!-- Job Image -->
                                            @if($job->image)
                                                <img src="{{ asset('storage/' . $job->image) }}" alt="Job Image" class="card-img-top" style="border-radius: 10px 10px 0 0; height: 200px; object-fit: cover;">
                                            @endif
            
                                            <div class="card-body">
                                                <!-- Job Title -->
                                                <h3 class="card-title fs-5 fw-bold mb-1">{{ $job->title }}</h3>
                                                <!-- Job Agency -->
                                                <span class="card-text text-muted mt-1">By {{ Str::words($job->company_name, 6) }}</span>
                                                <!-- Job Description -->
                                                <p class="card-text text-muted mb-1">{{ Str::words($job->description, 6) }}</p>
            
                                                <!-- Job Details -->
                                                <div class="bg-light p-3 border rounded mb-3">
                                                    <!-- Location -->
                                                    <p class="mb-2">
                                                        <span class="fw-bold"><i class="fa fa-map-marker"></i></span>
                                                        <span class="ps-1">{{ $job->location }}</span>
                                                    </p>
            
                                                    <!-- Job Type -->
                                                    <p class="mb-2">
                                                        <span class="fw-bold"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1">{{ $job->jobType->name }}</span>
                                                    </p>
            
                                                    <!-- Keywords -->
                                                    @if(!empty($job->keywords))
                                                        <p class="mb-2">
                                                            <span class="fw-bold"><i class="fa fa-key"></i></span>
                                                            <span class="ps-1">{{ $job->keywords }}</span>
                                                        </p>
                                                    @endif
            
                                                    <!-- Salary -->
                                                    <p class="mb-2">
                                                        <span class="ps-1">EGP {{ number_format($job->salary) }}</span>
                                                    </p>
            
                                                    <!-- Category -->
                                                    <p class="mb-2">
                                                        <span class="fw-bold"><i class="fa fa-cogs"></i></span>
                                                        <span class="ps-1">{{ $job->category->name }}</span>
                                                    </p>
            
                                                    <!-- Residential Type (if exists) -->
                                                    @if($job->residential_type)
                                                        <p class="mb-2">
                                                            <span class="fw-bold"><i class="fa fa-home"></i></span>
                                                            <span class="ps-1">{{ ucfirst($job->residential_type) }}</span>
                                                        </p>
                                                    @endif
            
                                                    <!-- Vacancy (if exists) -->
                                                    @if($job->vacancy)
                                                        <p class="mb-2">
                                                            <span class="fw-bold"><i class="fa fa-bed"></i></span>
                                                            <span class="ps-1">{{ $job->vacancy }} Rooms</span>
                                                        </p>
                                                    @endif
            
                                                    <!-- Bathrooms (if exists) -->
                                                    @if($job->bathrooms)
                                                        <p class="mb-2">
                                                            <span class="fw-bold"><i class="fa fa-bath"></i></span>
                                                            <span class="ps-1">{{ $job->bathrooms }} Bathrooms</span>
                                                        </p>
                                                    @endif
                                                </div>
            
                                                <!-- Details Button -->
                                                <div class="d-grid mt-3">
                                                    <a href="{{ route('details', $job->id) }}" class="btn btn-primary btn-lg">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12">
                                    <div class="alert alert-info" role="alert">
                                        No Properties Found
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{ $jobs->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .desc_height {
        height: 50px;
        overflow: hidden;
    }
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
@endsection

@section('customJs')
<script>
    $("#searchForm").submit(function(e) {
        e.preventDefault();

        var url = '{{ route("jobs") }}';
        var keyword = $("#keyword").val();
        var location = $("#location").val();
        var category = $("#category").val();
        var experience = $("#experience").val();
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
        if (experience != "") {
            queryString.push('experience=' + encodeURIComponent(experience));
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