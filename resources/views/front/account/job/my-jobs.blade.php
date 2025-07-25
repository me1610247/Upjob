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
                                <h3 class="fs-4 mb-1">Your Properties</h3>
                            </div>
                            @if(Auth::user()->role === 'admin')
                            <div style="margin-top: -10px;">
                                <a href="{{route('account.createJob')}}" class="btn btn-primary">Post a Property</a>
                            </div>
                            @endif
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Job Created</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($jobs->isNotEmpty())
                                    @foreach ($jobs as $job)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-bold text-success fs-5">{{ $job->title }}</div>
                                            <div class="text-muted mt-1">
                                                <span class="fw-semibold">Type:</span> {{ $job->jobType->name }} |
                                                <span class="fw-semibold">Category:</span> {{ $job->category->name }} |
                                                <span class="fw-semibold">Location:</span> {{ $job->location }}
                                            </div>
                                        </td>
                                        
                                        <td>
                                            @if($job->image)
                                            <img src="{{ asset('storage/' . $job->image) }}" alt="Job Image" class="mt-2" width="20" style="border-radius: 20px; width: 200px !important;">
                                            @endif
                                        </td>                                        
                                        
                                        <td>{{\Carbon\Carbon::parse($job->created_at)->format('d M, Y')}}</td>
                                       
                                        <td>
                                            @if($job->status == 1)
                                            <div class="job-status text-capitalize">Active</div>
                                            @else
                                            <div class="job-status text-capitalize">Complete</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{route('account.viewJob',$job->id)}}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="{{route('account.editJob',$job->id)}}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" onclick="deleteJob({{$job->id}})" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <h2 class="text-center">No Properties Posted Yet</h2>
                                    @endif
                                </tbody>
                                
                            </table>
                        </div>
                        <div>
                            {{ $jobs->links('vendor.pagination.bootstrap-5') }}
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