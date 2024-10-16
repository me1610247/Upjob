@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2 py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Jobs</li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <!-- Three Cards Side by Side -->
        <div class="row">
            <!-- First Card -->
            <div class="col-md-4 mb-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-tachometer-alt fa-2x text-danger mb-3"></i>
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">Manage registered users on the platform.</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm">Go To Dashboard</a>
                    </div>
                </div>
            </div>
            
            <!-- Second Card -->
            <div class="col-md-4 mb-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-briefcase fa-2x text-primary mb-3"></i>
                        <h5 class="card-title">Manage Jobs</h5>
                        <p class="card-text">Manage job postings and vacancies.</p>
                        <a href="{{route('admin.jobs')}}" class="btn btn-primary btn-sm">Go to Jobs</a>
                    </div>
                </div>
            </div>
            
            <!-- Third Card -->
            <div class="col-md-4 mb-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-2x text-warning mb-3"></i>
                        <h5 class="card-title">Applications</h5>
                        <p class="card-text">View user applications and applied on.</p>
                        <a href="{{route('admin.applications')}}" class="btn btn-warning btn-sm">Go to Applications</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Management Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Jobs Management</h4>
                        @include('front.layouts.message')
                        <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" id="editJobForm" name="editJobForm">
                            @csrf
                            @method('PUT')
                             <div class="card border-0 shadow mb-4 ">
                                 <div class="card-body card-form p-4">
                                     <h3 class="fs-4 mb-1">Edit Job Details</h3>
                                     <div class="row">
                                         <div class="col-md-6 mb-4">
                                             <label for="" class="mb-2">Title<span class="req">*</span></label>
                                             <input type="text" value="{{$job->title}}" placeholder="Job Title" id="title" name="title" class="form-control">
                                             <p></p>
                                         </div>
                                         <div class="col-md-6  mb-4">
                                             <label for="" class="mb-2">Category<span class="req">*</span></label>
                                             <select name="category" id="category" class="form-control">
                                                 <option value="">Select a Category</option>
                                                 @if($categories->isNotEmpty())
                                                 @foreach ($categories as $category)
                                                     <option {{($job->category_id==$category->id)?'selected':''}} value="{{$category->id}}">{{$category->name}}</option> 
                                                 @endforeach
                                                 @endif
                                             </select>
                                             <p></p>
                                         </div>
                                     </div>
                                     
                                     <div class="row">
                                         <div class="col-md-6 mb-4">
                                             <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                             <select name="jobType" id="jobType" class="form-select">
                                                 <option value="">Select a Job Type</option>
                                                 @if($job_types->isNotEmpty())
                                                 @foreach ($job_types as $job_type)
                                                     <option {{($job->job_type_id==$job_type->id)?'selected':''}} value="{{$job_type->id}}">{{$job_type->name}}</option> 
                                                 @endforeach
                                                 @endif
                                             </select>
                                         </div>
                                         <div class="col-md-6  mb-4">
                                             <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                             <input type="number" value="{{$job->vacancy}}" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                             <p></p>
                                         </div>
                                     </div>
             
                                     <div class="row">
                                         <div class="mb-4 col-md-6">
                                             <label for="" class="mb-2">Salary</label>
                                             <input type="text" value="{{$job->salary}}" placeholder="Salary" id="salary" name="salary" class="form-control">
                                             <p></p>
                                         </div>
             
                                         <div class="mb-4 col-md-6">
                                             <label for="" class="mb-2">Location<span class="req">*</span></label>
                                             <input type="text" value="{{$job->location}}" placeholder="location" id="location" name="location" class="form-control">
                                             <p></p>
                                         </div>
                                     </div>
                                     <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <div class="form-check">
                                                <input {{ $job->isFeatured == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" value="1" id="isFeatured" name="isFeatured">
                                                <label class="form-check-label" for="isFeatured">
                                                    Featured
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-4 col-md-6 d-flex align-items-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="1" id="status-active" name="status" 
                                                       {{ $job->status == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status-active">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="0" id="status-not" name="status" 
                                                       {{ $job->status == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="status-not">Not Active</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                     <div class="mb-4">
                                         <label for="" class="mb-2">Description<span class="req">*</span></label>
                                         <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description">{{$job->description}}</textarea>
                                         <p></p>
                                     </div>
                                     <div class="mb-4">
                                         <label for="" class="mb-2">Benefits</label>
                                         <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{$job->benefits}}</textarea>
                                         <p></p>
                                     </div>
                                     <div class="mb-4">
                                         <label for="" class="mb-2">Responsibility</label>
                                         <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{$job->responsibility}}</textarea>
                                         <p></p>
                                     </div>
                                     <div class="mb-4">
                                         <label for="" class="mb-2">Qualifications</label>
                                         <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{$job->qualifications}}</textarea>
                                         <p></p>
                                     </div>
                                     <div class="mb-4">
                                         <label for="" class="mb-2">Experience <span class="req">*</span></label>
                                         <select name="experience" id="experience" class="form-control">
                                             <option  value="">Select Years of Exp.</option>
                                             <option value="0" {{($job->experience) == '0' ? 'selected' : '' }}>0 Years</option>
                                             <option value="1_3" {{($job->experience) == '1_3' ? 'selected' : '' }}>1-3 Years</option>
                                             <option value="3_plus" {{($job->experience) == '3_plus' ? 'selected' : '' }}>+3 Years</option>
                                             <option value="5_plus" {{($job->experience) == '5_plus' ? 'selected' : '' }}>+5 Years</option>
                                             <option value="8_plus" {{($job->experience) == '8_plus' ? 'selected' : '' }}>+8 Years</option>
                                             <option value="10_plus" {{($job->experience) == '10_plus' ? 'selected' : '' }}>+10 Years</option>
                                             <p></p>
                                         </select>
                                     </div>
                                     
                                     
             
                                     <div class="mb-4">
                                         <label for="" class="mb-2">Keywords<span class="req">*</span></label>
                                         <input type="text" value="{{$job->keywords}}" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                                         <p></p>
                                     </div>
             
                                     <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>
             
                                     <div class="row">
                                         <div class="mb-4 col-md-6">
                                             <label for="" class="mb-2">Name<span class="req">*</span></label>
                                             <input type="text" value="{{$job->company_name}}" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                             <p></p>
                                         </div>
             
                                         <div class="mb-4 col-md-6">
                                             <label for="" class="mb-2">Location</label>
                                             <input type="text" value="{{$job->company_location}}" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                             <p></p>
                                         </div>
                                        </div>
                                     <div class="mb-4">
                                         <label for="" class="mb-2">Website</label>
                                         <input type="text" value="{{$job->company_website}}" placeholder="Website" id="company_website" name="company_website" class="form-control">
                                         <p></p>
                                     </div>
                                 </div> 
                                 <div class="card-footer  p-4">
                                     <button type="submit" class="btn btn-primary">Update Job</button>
                                 </div>               
                             </div>  
                    </form>  
                    <div class="card-footer"> 
                    <button type="button" class="btn btn-secondary" onclick="goBack()">Back</button> 
                    </div>
                    </div>
                </div>              
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<script type="text/javascript">
   $("#editJobForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("admin.jobs.update",$job->id) }}',
            type: 'put',
            data: $("#editJobForm").serializeArray(),
            dataType: 'json',
            success: function(response){
    // Reset all fields to remove error classes and messages
    $(".form-control").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
    if (response.status == false) {
        var errors = response.errors;
        
        // Check and show errors
        if (errors.title) {
            $("#title").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.title);
        }
        
        if (errors.location) {
            $("#location").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.location);
        }

        if (errors.company_name) {
            $("#company_name").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.company_name);
        }
        if (errors.keywords) {
            $("#keywords").addClass('is-invalid')
                .siblings('p')
                .addClass('invalid-feedback')
                .html(errors.keywords);
        }
    } else {
        // If the update is successful, redirect
        window.location.href = response.redirect_url;
    }
}

        });
    })



</script>
@endsection
