@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
               @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.layouts.message')
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Applied Properties</h3>
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Image</th> <!-- New column for property image -->
                                        <th scope="col">Title</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($jobsApplications->isNotEmpty())
                                        @foreach ($jobsApplications as $jobsApplication)
                                            <tr>
                                                <!-- Property Image -->
                                                <td>
                                                    @if($jobsApplication->job->image)
                                                        <img src="{{ asset('storage/' . $jobsApplication->job->image) }}" alt="Property Image" class="img-fluid rounded" style="width: 120px; height: 100px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('assets/images/default-property.jpg') }}" alt="Default Property Image" class="img-fluid rounded" style="width: 80px; height: 60px; object-fit: cover;">
                                                    @endif
                                                </td>
                        
                                                <!-- Title and Location -->
                                                <td>
                                                    <div class="job-name fw-500">{{ $jobsApplication->job->title }}</div>
                                                    <div class="text-muted small">{{ $jobsApplication->job->jobType->name }} · {{ $jobsApplication->job->location }}</div>
                                                </td>
                    
                                                <!-- Price -->
                                                <td>
                                                    <div class="fw-500">${{ number_format($jobsApplication->job->salary) }}</div>
                                                </td>
                        
                        
                                                <!-- Applicants -->
                                                <td>
                                                    <div class="text-muted small">{{ $jobsApplication->job->applications->count() }} Applications</div>
                                                </td>
                        
                                                <!-- Action -->
                                                <td>
                                                    <a class="btn btn-sm btn-primary" href="{{ route('details', $jobsApplication->job_id) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <h4 class="text-muted">No Applied Properties Yet</h4>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $jobsApplications->links('vendor.pagination.bootstrap-5') }}
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
    function deleteJob(jobId){
        if(confirm("Are You Sure You Want To Delete This Job ?")){
            $.ajax({
                url:'{{route("account.deleteJob")}}',
                type:'POST',
                data:{jobId:jobId},
                dataType:'json',
                success:function(response){
                    window.location.href='{{route("account.myJobs")}}'
                }
            })
        }
    }
</script>
@endsection