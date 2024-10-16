@extends('front.layouts.app')

@section('main')
<section class="section-0 lazy d-flex bg-image-style dark align-items-center "   class="" data-bg="{{asset('assets/images/banner5.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-8">
                <h1>Find your dream job</h1>
                <p>Thounsands of jobs available.</p>
                <div class="banner-btn mt-5"><a href="{{route('jobs')}}" class="btn btn-primary mb-4 mb-sm-0">Explore Now</a></div>
            </div>
        </div>
    </div>
</section>
<section class="section-1 py-5 "> 
    <div class="container">
    @if(Auth::check())
     <form action="" name="searchForm" id="searchForm">
        <div class="card border-0 shadow p-5">
            <div class="row">
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keywords">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <input type="text" class="form-control" name="location" id="location" placeholder="Location">
                </div>
                <div class="col-md-3 mb-3 mb-sm-3 mb-lg-0">
                    <select name="category" id="category" class="form-control">
                        <option value="">Select a Category</option>
                        @if($categories)
                        @foreach($categories as $category)
                         <option {{(Request::get('category')==$category->id)?'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
                
                <div class=" col-md-3 mb-xs-3 mb-sm-3 mb-lg-0">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                    </div>
                    
                </div>
            </div>            
        </div>
    </form>
    @endif
    </div>
</section>

<section class="section-2 bg-2 py-5">
    <div class="container">
        <h2>Popular Categories</h2>
        <div class="row pt-5">
            @if($categories->isNotEmpty())
            @foreach($categories as $category)            
            <div class="col-lg-4 col-xl-3 col-md-6">
                <div class="single_catagory">
                    <a href="{{route('jobs').'?category='.$category->id}}"><h4 class="pb-2">{{$category->name}}</h4></a>
                    <p class="mb-0"> <span>{{$category->jobs->count()}}</span> Available position</p>
                </div>
            </div>
          @endforeach
          @endif
        </div>
    </div>
</section>

<section class="section-3  py-5">
    <div class="container">
        <h2>Featured Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if($featuredJobs->isNotEmpty())
                        @foreach($featuredJobs as $featuredJob)
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="px border-0 fs-5 pb-2 mb-0">{{$featuredJob->title}}</h3>
                                    <p class="desc_height">{{ Str::words($featuredJob->description,5)}}</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{$featuredJob->location}}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{$featuredJob->jobType->name}}</span>
                                        </p>
                                        @if(!empty($featuredJob->salary))
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{$featuredJob->salary}}</span>
                                        </p>
                                        @endif
                                    </div>

                                    @if(Auth::check())
                                    <div class="d-grid mt-3">
                                        <a href="{{route('details',$featuredJob->id)}}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                    @else
                                    <div class="d-grid mt-3">
                                        <a href="{{route("account.login")}}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>  
                        @endforeach
                        @endif                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .desc_height{
        height: 50px
    }
</style>
<section class="section-3 bg-2 py-5">
    <div class="container">
        <h2>Latest Jobs</h2>
        <div class="row pt-5">
            <div class="job_listing_area">                    
                <div class="job_lists">
                    <div class="row">
                        @if($latestJobs->isNotEmpty())
                        @foreach($latestJobs as $latestJob)
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="px border-0 fs-5 pb-2 mb-0">{{$latestJob->title}}</h3>
                                    <p class="desc_height">{{ Str::words($latestJob->description,5)}}</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{$latestJob->location}}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{$latestJob->jobType->name}}</span>
                                        </p>
                                        @if(!empty($latestJob->salary))
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{$latestJob->salary}}</span>
                                        </p>
                                        @endif
                                    </div>
                                    @if(Auth::check())
                                    <div class="d-grid mt-3">
                                        <a href="{{route('details',$latestJob->id)}}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                    @else
                                    <div class="d-grid mt-3">
                                        <a href="{{route("account.login")}}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>  
                        @endforeach
                        @endif                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
<script>
  $("#searchForm").submit(function(e) {
    e.preventDefault();

    var url = '{{ route("jobs") }}';
    var keyword = $("#keyword").val();
    var location = $("#location").val();
    var category = $("#category").val();

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

    window.location.href = url;
});


    </script>
@endsection
