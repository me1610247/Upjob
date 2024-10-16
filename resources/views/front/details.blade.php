@extends('front.layouts.app')

@section('main')
<section class="section-4 bg-2">    
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{route("jobs")}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div> 
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            @include('front.layouts.message')
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4>{{$job->title}}</h4>
                                    </a>
                                    @if($job->user_id == Auth::user()->id)
                                    <span class="mt-3 text-danger">Note : (Your own Job)</span>
                                    @endif
                                    <div class="my-3 links_locat d-flex align-items-center">
                                        <div class="location">
                                            <p class="text-dark"> <i class="fa fa-map-marker"></i> {{$job->location}}</p>
                                        </div>
                                        <div class="location">
                                            <p class="text-dark"> <i class="fa fa-clock-o"></i> {{$job->jobType->name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-success">
                                <div class="apply_now">
                                    <a class="heart_mark" href="javascript:void(0)" onclick="favJob({{$job->id}})" > <i class="fa fa-heart-o" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($job->description))
                    <div class="descript_wrap white-bg">
                        <div class="single_wrap">
                            <h4>Description</h4>
                            <h4>{{$job->description}}</h4>
                        </div>
                        @endif
                        @if(!empty($job->responsibility))
                        <div class="single_wrap">
                            <h4>Responsibility</h4>
                            <ul>
                                <li>{{$job->responsibility}}</li>
                            </ul>
                        </div>
                        @endif
                        @if(!empty($job->qualifications))
                        <div class="single_wrap">
                            <h4>Qualifications</h4>
                            <ul>
                                <li>{{$job->qualifications}}</li>                                
                            </ul>
                        </div>
                        @endif
                        @if(!empty($job->benefits))
                        <div class="single_wrap">
                            <h4>Benefits</h4>
                            <p>{{$job->benefits}}</p>
                        </div>
                        @endif
                        <div class="border-bottom"></div>
                        <div class="pt-3 text-end">
                            <a href="#" onclick="favJob({{$job->id}})" class="btn btn-secondary">Save</a>
                            @if(Auth::check())
                            <a  onclick="applyJob({{$job->id}})" class="btn btn-primary">Apply</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Job Summery</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Published on: <span>{{\Carbon\Carbon::parse($job->created_at)->format('d,M Y')}}</span></li>
                                <li>Vacancy: <span>{{$job->vacancy}}</span></li>
                                <li>Salary: <span>{{$job->salary}}</span></li>
                                <li>Location: <span>{{$job->location}}</span></li>
                                <li>Job Nature: <span>{{$job->jobType->name}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-4">
                            <h3>Company Details</h3>
                        </div>
                        <div class="job_content pt-3">
                            <ul>
                                <li>Name: <span>{{$job->company_name}}</span></li>
                                @if(!empty($job->company_location))
                                <li>Locaion: <span>{{$job->company_location}}</span></li>
                                @endif
                                @if(!empty($job->company_website))
                                <li>Webite: <span>{{$job->company_website}}</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="applyJobModalLabel">Confirm Application</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to apply for this job?</p>
                <label for="resume">Upload Resume To Get Your Chance easier</label>
                <input type="file" name="resume" id="resume" accept=".pdf,.doc,.docx" required>
                <!-- Error message container -->
                <div id="error-message" class="text-danger" style="display:none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmApplyButton" class="btn btn-primary">Apply Now</button>
            </div>
        </div>
    </div>
</div>

</section>
@endsection
<style>
    .modal-content {
        border-radius: 10px;
    }
    .modal-header {
        background-color: #28a745;
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    .modal-footer .btn-primary {
        background-color: #28a745;
        border: none;
    }
    .modal-footer .btn-secondary {
        background-color: #6c757d;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
@section('customJs')
<script type="text/javascript">
   function applyJob(id){
    var applyJobModal = new bootstrap.Modal(document.getElementById('applyJobModal'));

    document.getElementById('confirmApplyButton').onclick = function() {
        var formData = new FormData();
        formData.append('id', id);
        var resumeInput = document.getElementById('resume');
        formData.append('resume', resumeInput.files[0]);
        $.ajax({
            url: '{{ route("applyJob") }}', 
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if(response.status === true){
                    applyJobModal.hide();
                    window.scrollTo(0, 0);
                    window.location.reload(); // Reload the page on success
                } else {
                    localStorage.setItem('errorMessage', response.errors || 'Something went wrong!');
                    window.location.reload(); // Reload the page after storing the message
                }
            },
            error: function(xhr, status,errors) {
                if (resumeInput.files.length === 0) {
                    document.getElementById('error-message').style.display = 'block';
                    document.getElementById('error-message').innerHTML = 'Upload Your Resume Please.';
                }else{
                    document.getElementById('error-message').style.display = 'block';
                    document.getElementById('error-message').innerHTML = 'Failed To apply , please try again later.'
                }
            }
        });
    };

    applyJobModal.show();
}

$(document).ready(function() {
    var errorMessage = localStorage.getItem('errorMessage');
    if (errorMessage) {
        $('#global-error-message').text(errorMessage).fadeIn();
        window.scrollTo(0, 0);
        localStorage.removeItem('errorMessage');
    }
});
 function favJob(id){
    $.ajax({
            url: '{{ route("favJob") }}', 
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {id:id},
            dataType: 'json',
            success: function(response) {
                window.location.href="{{url()->current()}}";
            }
    })
 }
</script>

@endsection
