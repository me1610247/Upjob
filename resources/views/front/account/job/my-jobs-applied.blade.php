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
                                <h3 class="fs-4 mb-1">Applied Jobs</h3>
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Salary</th>
                                        <th scope="col">Applied Date</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($jobsApplications->isNotEmpty())
                                    @foreach ($jobsApplications as $jobsApplication)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{$jobsApplication->job->title}}</div>
                                            <div class="info1">{{$jobsApplication->job->jobType->name}} . {{$jobsApplication->job->location}}</div>
                                        </td>
                                        <td>
                                            <div class="info1">{{$jobsApplication->job->category->name}}</div>
                                        </td>
                                        <td>
                                            <div class="info1">{{$jobsApplication->job->salary}}</div>
                                        </td>
                                        <td>{{\Carbon\Carbon::parse($jobsApplication->applied_date)->format('d M, Y')}}</td>
                                        <td>{{$jobsApplication->job->applications->count()}} Applications</td>
                                        <td>
                                            @if($jobsApplication->job->status == 1)
                                            <div class="job-status text-capitalize">Active</div>
                                            @else
                                            <div class="job-status text-capitalize">Complete</div>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="{{route('details',$jobsApplication->job_id)}}"><i class="fa fa-eye" aria-hidden="true"></i> View</a>

                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <h2 class="text-center">No Jobs Posted Yet</h2>
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