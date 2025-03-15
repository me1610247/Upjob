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
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Saved Properties</h3>
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" scope="col">Title</th>
                                        <th class="text-center" scope="col">Category</th>
                                        <th class="text-center" scope="col">Applied Date</th>
                                        <th class="text-center" scope="col">Applicants</th>
                                        <th class="text-center" scope="col">Status</th>
                                        <th class="text-center" scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($SavedJobs->isNotEmpty())
                                    @foreach ($SavedJobs as $SavedJob)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">{{$SavedJob->job->title}}</div>
                                            <div class="info1">{{$SavedJob->job->jobType->name}} . {{$SavedJob->job->location}}</div>
                                        </td>
                                        <td>
                                            <div class="info1">{{$SavedJob->job->category->name}}</div>
                                        </td>
                                        <td>{{\Carbon\Carbon::parse($SavedJob->applied_date)->format('d M, Y')}}</td>
                                        <td>{{$SavedJob->job->applications->count()}} Applications</td>
                                        <td>
                                            @if($SavedJob->job->status == 1)
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
                                                    <li><a class="dropdown-item" href="{{route('details',$SavedJob->job_id)}}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li class="text-danger"><a class=" dropdown-item" onclick="unSaveJobs({{$SavedJob->id}})"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
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
                            {{ $SavedJobs->links() }}
                        </div>
                        
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>
@endsection
<style>
    .btn-action {
        display: inline-block;
        margin-right: 5px;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn i {
        margin-right: 5px;
    }

    /* Optional: For table row hover effect */
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    .action-buttons {
    display: flex;
    gap: 10px; /* Space between buttons */
}

.btn-action {
    font-size: 12px; /* Smaller font size */
    padding: 5px 10px; /* Adjust padding */
}

.btn-action i {
    margin-right: 5px; /* Space between icon and text */
}

td {
    white-space: nowrap; /* Prevent buttons from wrapping */
}

</style>

@section('customJs')
<script type="text/javascript">
    function unSaveJobs(id){
        if(confirm("Are You Sure You Want To Delete This Job ?")){
            $.ajax({
                url: '{{route("account.unSaveJobs")}}',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response) {
                    if(response.status === true){
                        // Remove the job row dynamically without reloading the page
                        $('tr[data-id="' + id + '"]').remove();
                        window.location.href='{{route("account.savedJobs")}}'
                    } 
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while trying to remove the job. Please try again.');
                }
            });
        }
    }
</script>

@endsection