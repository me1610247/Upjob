@extends('front.layouts.app')

@section('main')
<section class="section-0 lazy d-flex bg-image-style dark align-items-center" style="background-image: url('{{asset('assets/images/banner.webp')}}'); background-size: cover; background-position: center; min-height: 100vh;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <h1 class="display-4 text-white fw-bold">Find Your Dream Home</h1>
                <p class="lead text-white">Thousands of properties available.</p>
                <div class="banner-btn mt-5">
                    <a href="{{route('jobs')}}" class="btn btn-primary btn-lg px-5 py-3">Explore Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-1 py-5 bg-light"> 
    <div class="container">
        @if(Auth::check())
        <form action="" name="searchForm" id="searchForm">
            <div class="card border-0 shadow p-5">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control " name="keyword" id="keyword" placeholder="Search by keyword">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="location" id="location" placeholder="Search by location">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Search by Agency name">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Search</button>
                    </div>
                </div>            
            </div>
        </form>
        @endif
    </div>
</section>

<section class="section-2 py-5">
    <div class="container">
        <h2 class="text-center mb-5">Popular Property Types</h2>
        <div class="row g-4">
            @if($categories->isNotEmpty())
            @foreach($categories as $category)            
            <div class="col-lg-4 col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center p-4">
                    <a href="{{route('jobs').'?category='.$category->id}}" class="text-decoration-none">
                        <h4 class="mb-3">{{$category->name}}</h4>
                        <p class="mb-0 text-muted"> <span class="fw-bold">{{$category->jobs->count()}}</span> Available listings</p>
                    </a>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

<section class="section-3 py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Featured Properties (Premium)</h2>
        <div class="row g-4">
            @if($featuredJobs->isNotEmpty())
            @foreach($featuredJobs as $featuredJob)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h3 class="card-title fs-5 fw-bold">{{$featuredJob->title}}</h3>
                        <p class="card-text text-muted ">By {{ Str::words($featuredJob->company_name,5)}}</p>
                        <p class="card-text text-muted desc_height">{{ Str::words($featuredJob->description,5)}}</p>
                        @if($featuredJob->image)
                        <img src="{{ asset('storage/' . $featuredJob->image) }}" class="card-img-top" alt="{{ $featuredJob->title }}" style="height: 200px; object-fit: cover;">
                        @else
                        <img src="{{ asset('assets/images/default-property.jpg') }}" class="card-img-top" alt="Default Property Image" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="bg-light p-3 border rounded">
                            <p class="mb-2">
                                <span class="fw-bold"><i class="fa fa-map-marker"></i></span>
                                <span class="ps-1">{{$featuredJob->location}}</span>
                            </p>
                            <p class="mb-2">
                                <span class="fw-bold"><i class="fa fa-home"></i></span>
                                <span class="ps-1">{{$featuredJob->jobType->name}}</span>
                            </p>
                            <p class="mb-2">
                                <span class="fw-bold"><i class="fa fa-category"></i></span>
                                <span class="ps-1">{{$featuredJob->category->name}}</span>
                            </p>
                            @if(!empty($featuredJob->salary))
                            <p class="mb-0">
                                <span class="ps-1">EGP {{ number_format($featuredJob->salary) }}</span>
                            </p>
                            @endif
                        </div>
                        <div class="d-grid mt-3">
                            <a href="{{route('details',$featuredJob->id)}}" class="btn btn-primary btn-lg">View Details</a>
                        </div>
                    </div>
                </div>
            </div>  
            @endforeach
            @endif                       
        </div>
    </div>
</section>
<section class="section-4 py-5">
    <div class="container">
        <h2 class="text-center mb-5">Latest Listings</h2>
        <div class="row g-4">
            @if($latestJobs->isNotEmpty())
            @foreach($latestJobs as $latestJob)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h3 class="card-title fs-5 fw-bold">{{ $latestJob->title }}</h3>
                        <p class="card-text text-muted ">By {{ Str::words($latestJob->company_name,5)}}</p>
                        <p class="card-text text-muted desc_height">Description :{{ Str::words($latestJob->description, 5) }}</p>
                          <!-- Property Image -->
                    @if($latestJob->image)
                    <img src="{{ asset('storage/' . $latestJob->image) }}" class="card-img-top" alt="{{ $latestJob->title }}" style="height: 200px; object-fit: cover;">
                    @else
                    <img src="{{ asset('assets/images/default-property.jpg') }}" class="card-img-top" alt="Default Property Image" style="height: 200px; object-fit: cover;">
                    @endif
                        <div class="bg-light p-3 border rounded">
                            <p class="mb-2">
                                <span class="fw-bold"><i class="fa fa-map-marker"></i></span>
                                <span class="ps-1">{{ $latestJob->location }}</span>
                            </p>
                            <p class="mb-2">
                                <span class="fw-bold"><i class="fa fa-home"></i></span>
                                <span class="ps-1">{{ $latestJob->jobType->name }}</span>
                            </p>
                            <p class="mb-2">
                                <span class="fw-bold"><i class="fa fa-cogs"></i></span>
                                <span class="ps-1">{{ $latestJob->category->name }}</span>
                            </p>
                            @if(!empty($latestJob->salary))
                            <p class="mb-0">
                                <span class="ps-1">EGP {{ number_format($latestJob->salary) }}</span>
                            </p>
                            @endif
                        </div>
                        <div class="d-grid mt-3">
                            <a href="{{ route('details', $latestJob->id) }}" class="btn btn-primary btn-lg">View Details</a>
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
    var companyName = $("#company_name").val(); // Get company name value

    var queryString = [];

    if (keyword != "") {
        queryString.push('keyword=' + encodeURIComponent(keyword));
    }
    if (location != "") {
        queryString.push('location=' + encodeURIComponent(location));
    }
    if (companyName != "") {
        queryString.push('company_name=' + encodeURIComponent(companyName)); // Add company name to query string
    }

    if (queryString.length > 0) {
        url += '?' + queryString.join('&');
    }

    window.location.href = url;
});
    </script>
@endsection
