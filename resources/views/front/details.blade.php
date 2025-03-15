@extends('front.layouts.app')

@section('main')
<section class="section-4 bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-white rounded-3 p-3 shadow-sm">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('jobs') }}" class="text-decoration-none text-secondary">
                                <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Properties
                            </a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container job_details_area mt-4">
        <div class="row pb-5">
            @include('front.layouts.message')
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <!-- Job Image -->
                    @if($job->image)
                    <div class="text-center"> <!-- Center the image horizontally -->
                        <img src="{{ asset('storage/' . $job->image) }}" alt="Job Image" class="card-img-top" style="border-radius: 10px 10px 0 0; width: 400px; object-fit: cover;">
                    </div>                    
                    @endif

                    <div class="job_details_header bg-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="jobs_left">
                                <h2 class="fw-bold mb-3">{{ $job->title }}</h2>
                                @if($job->user_id == Auth::user()->id)
                                    <span class="badge bg-danger">Note: Your Own Property</span>
                                @endif
                                <div class="d-flex align-items-center mt-3">
                                    <p class="mb-0 me-3 text-muted"><i class="fa fa-map-marker"></i> {{ $job->location }}</p>
                                    <p class="mb-0 me-3 text-muted"><i class="fa fa-clock-o"></i> {{ $job->jobType->name }}</p>
                                    <p class="mb-0 text-muted"><i class="fa fa-tags"></i> {{ $job->category->name }}</p>
                                </div>
                            </div>
                            <div class="text-success">
                                <a class="heart_mark text-decoration-none" href="javascript:void(0)" onclick="favJob({{ $job->id }})">
                                    <i class="fa fa-heart-o fa-2x"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="descript_wrap bg-white p-4">
                        <!-- Residential Type (if found) -->
                        @if($job->residential_type)
                            <div class="single_wrap mb-4">
                                <h4 class="fw-bold mb-3">Residential Type</h4>
                                <p class="text-muted">{{ ucfirst($job->residential_type) }}</p>
                            </div>
                        @endif

                        @if(!empty($job->description))
                            <div class="single_wrap mb-4">
                                <h4 class="fw-bold mb-3">Property Description</h4>
                                <p class="text-muted">{{ $job->description }}</p>
                            </div>
                        @endif

                        @if(!empty($job->responsibility))
                            <div class="single_wrap mb-4">
                                <h4 class="fw-bold mb-3">Property Features</h4>
                                <ul class="list-unstyled text-muted">
                                    <li>{{ $job->responsibility }}</li>
                                </ul>
                            </div>
                        @endif

                        @if(!empty($job->qualifications))
                            <div class="single_wrap mb-4">
                                <h4 class="fw-bold mb-3">Additional Information</h4>
                                <ul class="list-unstyled text-muted">
                                    <li>{{ $job->qualifications }}</li>
                                </ul>
                            </div>
                        @endif

                        @if(!empty($job->benefits))
                            <div class="single_wrap mb-4">
                                <h4 class="fw-bold mb-3">Nearby Amenities</h4>
                                <p class="text-muted">{{ $job->benefits }}</p>
                            </div>
                        @endif

                        <div class="border-bottom mb-3"></div>
                        <div class="d-flex justify-content-end gap-3">
                            <a href="#" onclick="favJob({{ $job->id }})" class="btn btn-outline-dark">Favourite</a>
                            @if(Auth::check())
                                <a onclick="applyJob({{ $job->id }})" class="btn btn-primary">Apply</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 mb-4">
                    <div class="job_sumary bg-white p-4">
                        <h3 class="fw-bold mb-4">Property Summary</h3>
                        <ul class="list-unstyled text-muted">
                            <li class="mb-3"><strong>Published on:</strong> <span>{{ \Carbon\Carbon::parse($job->created_at)->format('d M Y') }}</span></li>
                            @if($job->vacancy)
                            <li class="mb-3"><strong>No. of Rooms:</strong> <span>{{ $job->vacancy }}</span></li>
                            @endif                           
                            @if($job->bathrooms)
                            <li class="mb-3"><strong>No. of Bathrooms:</strong> <span>{{ $job->bathrooms }}</span></li>
                            @endif                           
                         <li class="mb-3"><strong>Salary:</strong> <span>{{ number_format($job->salary) }} EGP</span></li>
                            <li class="mb-3"><strong>Location:</strong> <span>{{ $job->location }}</span></li>
                            <li class="mb-3"><strong>Property Nature:</strong> <span>{{ $job->jobType->name }}</span></li>    
                        </ul>
                    </div>
                </div>

                <div class="card shadow border-0">
                    <div class="job_sumary bg-white p-4">
                        <h3 class="fw-bold mb-4">Agency Details</h3>
                        <ul class="list-unstyled text-muted">
                            <li class="mb-3"><strong>Name:</strong> <span>{{ $job->company_name }}</span></li>
                            @if(!empty($job->company_location))
                                <li class="mb-3"><strong>Location:</strong> <span>{{ $job->company_location }}</span></li>
                            @endif
                            @if(!empty($job->company_website))
                                <li class="mb-3"><strong>Website:</strong> <span>{{ $job->company_website }}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="applyJobModal" tabindex="-1" aria-labelledby="applyJobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="applyJobModalLabel">Confirm Application</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to apply for this property?</p>
                <div id="error-message" class="text-danger mt-2" style="display:none;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmApplyButton" class="btn btn-primary">Apply Now</button>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .job_details_header {
        border-bottom: 1px solid #e9ecef;
    }
    .descript_wrap {
        border-top: 1px solid #e9ecef;
    }
    .heart_mark:hover {
        color: #dc3545 !important;
    }
    .modal-content {
        border-radius: 10px;
    }
    .modal-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
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

@section('customJs')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    function applyJob(id) {
        var applyJobModal = new bootstrap.Modal(document.getElementById('applyJobModal'));

        document.getElementById('confirmApplyButton').onclick = function() {
            $.ajax({
                url: '{{ route("applyJob") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: { id: id }, // Send only the job ID
                dataType: 'json',
                success: function(response) {
                    if (response.status === true) {
                        applyJobModal.hide();
                        window.scrollTo(0, 0);
                        window.location.reload();
                    } else {
                        localStorage.setItem('errorMessage', response.errors || 'Something went wrong!');
                        window.location.reload();
                    }
                },
                error: function(xhr, status, errors) {
                    document.getElementById('error-message').style.display = 'block';
                    document.getElementById('error-message').innerHTML = 'Failed to apply. Please try again later.';
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

    function favJob(id) {
        $.ajax({
            url: '{{ route("favJob") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                window.location.href = "{{ url()->current() }}";
            }
        });
    }
</script>
@endsection