@extends('front.layouts.app')

@section('main')
<section class="section-3 py-5 bg-2 ">
    <div class="container">     
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Jobs</h2>  
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                        <option value="1" {{(Request::get('sort')=='1')?'selected':''}}>Latest</option>
                        <option value="0" {{(Request::get('sort')=='0')?'selected':''}}>Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">
                <form action="" name="searchForm" id="searchForm">
                <div class="card border-0 shadow p-4">
                    <div class="mb-4">
                        <h2>Keywords</h2>
                        <input value="{{Request::get('keyword')}}" type="text" name="keyword" id="keyword" placeholder="Keywords" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Location</h2>
                        <input value="{{Request::get('location')}}" type="text" name="location" id="location" placeholder="Location" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h2>Category</h2>
                        <select name="category" id="category" class="form-control">
                            <option value="">Select a Category</option>
                            @if($categories)
                            @foreach($categories as $category)
                             <option {{(Request::get('category')==$category->id)?'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>                   

                <!--    <div class="mb-4">
                        <h2>Job Type</h2>
                        if($jobTypes->isNotEmpty())
                        foreach($jobTypes as $jobType)
                        <div class="form-check mb-2"> 
                            <input class="form-check-input " name="job_type" type="checkbox" value="$jobType->id}}" id="job-type-$jobType->id}}">    
                            <label class="form-check-label " for="job-type-$jobType->id}}">$jobType->name}}</label>
                        </div>
                        endforeach
                        endif
                    </div> !-->

                    <div class="mb-4">
                        <h2>Experience</h2>
                        <select name="experience" id="experience" class="form-control">
                            <option value="">Select Experience</option>
                            <option value="1" {{(Request::get('experience')==1)}} >1 Year</option>
                            <option value="2" {{(Request::get('experience')==2)}}>2 Years</option>
                            <option value="3" {{(Request::get('experience')==3)}}>3 Years</option>
                            <option value="4" {{(Request::get('experience')==4)}}>4 Years</option>
                            <option value="5" {{(Request::get('experience')==5)}}>5 Years</option>
                            <option value="6" {{(Request::get('experience')==6)}}>6 Years</option>
                            <option value="7" {{(Request::get('experience')==7)}}>7 Years</option>
                            <option value="8" {{(Request::get('experience')==8)}}>8 Years</option>
                            <option value="9" {{(Request::get('experience')==9)}}>9 Years</option>
                            <option value="10"{{(Request::get('experience')==10)}}>10 Years</option>
                            <option value="10_plus" {{(Request::get('experience')=='10_plus')}}>10+ Years</option>
                        </select>
                    </div>  
                    <button type="submit" class="btn btn-primary">Search</button>                  
                    <a href="{{route("jobs")}}" class="btn btn-secondary mt-3">Reset</a>                  
                </div>
            </form>
            </div>
            <div class="col-md-8 col-lg-9 ">
                <div class="job_listing_area">                    
                    <div class="job_lists">
                    <div class="row">
                        @if($jobs->isNotEmpty())
                        @foreach($jobs as $job)
                        <div class="col-md-4">
                            <div class="card border-0 p-3 shadow mb-4">
                                <div class="card-body">
                                    <h3 class="title_height border-0 fs-5 pb-2 mb-0">{{$job->title}}</h3>
                                    <p class="desc_height">{{ Str::words($job->description,6)}}</p>
                                    <div class="bg-light p-3 border">
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                            <span class="ps-1">{{$job->location}}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                            <span class="ps-1">{{$job->jobType->name}}</span>
                                        </p>
                                        @if(!empty($job->keywords))
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-key"></i></span>
                                            <span class="ps-1">{{$job->keywords}}</span>
                                        </p>
                                        @endif
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                            <span class="ps-1">{{$job->salary}}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-cogs"></i></span>
                                            <span class="ps-1">{{$job->category->name}}</span>
                                        </p>
                                        <p class="mb-0">
                                            <span class="fw-bolder"><i class="fa fa-briefcase"></i></span>
                                            <span class="ps-1">{{$job->experience}} Years</span>
                                        </p>
                                    </div>
                                    @if(Auth::check())
                                    <div class="d-grid mt-3">
                                        <a href="{{route('details',$job->id)}}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                    @else
                                    <div class="d-grid mt-3">
                                        <a href="{{route('account.login')}}" class="btn btn-primary btn-lg">Details</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="col-md-12">No Jobs Found</div>
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
    .desc_height{
        height: 50px
    }
    .title_height{
        height: 50px
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
    url += '&sort='+sort;

    window.location.href = url;
});
    $("#sort").change(function(){
        $("#searchForm").submit();
    });
    $("#experience").change(function(){
        $("#searchForm").submit();
    });
    </script>
@endsection