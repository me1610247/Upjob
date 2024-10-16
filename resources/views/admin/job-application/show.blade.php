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
                        <h5 class="card-title">Dashboard</h5>
                        <p class="card-text">Manage Your App.</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-sm">Go To Dashboard</a>
                    </div>
                </div>
            </div>
            
            <!-- Second Card -->
            <div class="col-md-4 mb-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-briefcase fa-2x text-primary mb-3"></i>
                        <h5 class="card-title">Manage Users</h5>
                        <p class="card-text">Manage registered users on the platform</p>
                        <a href="{{route('admin.users')}}" class="btn btn-primary btn-sm">Go to Users</a>
                    </div>
                </div>
            </div>
            
            <!-- Third Card -->
            <div class="col-md-4 mb-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-briefcase fa-2x text-secondary mb-3"></i>
                        <h5 class="card-title">Manage Jobs</h5>
                        <p class="card-text">View and edit jobs listed on the platform.</p>
                        <a href="{{route('admin.jobs')}}" class="btn btn-light bg-dark text-light btn-sm">Go to Jobs</a>
                    </div>
                </div>
            </div>

        <!-- User Management Table -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h4 class="card-title">Job Application</h4>
                        @include('front.layouts.message')
                        <button type="button" class="btn btn-secondary" onclick="goBack()">Back</button> 
                        @if($applications->isNotEmpty())
                        <table class="table table-striped table-hover mt-4">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Job Title</th>
                                    <th>Employer</th>
                                    <th>User</th>
                                    <th>Applied Date</th>
                                    <th>Resume</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <p>{{ $application->job->title }}</p>
                                            {{-- <p>Applicants : {{$job->applications->count()}}</p> --}}
                                        </td>
                                        <td>{{ $application->employer->name }}</td>
                                        <td>{{ $application->user->name }}</td>
                                        <td>{{\Carbon\Carbon::parse($application->applied_at)->format('d M, Y')}}</td>
                                        <td>
                                            @if($application->resume)
                                                <!-- Link to download or view the resume -->
                                                {{-- php artisan storage:link must be run in the terminal first  --}}
                                                <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" class="btn btn-sm btn-outline-success">View Resume</a>
                                                @else
                                                <span class="text-muted">No resume uploaded</span>
                                            @endif
                                        </td>                                        <td>
                                            <div class="action-dots float-end">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" onclick="deleteJobApplication({{ $application->id }})" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-center mt-4">No users yet.</p>
                        @endif
                    </div>
                </div>              
            </div>
            {{ $applications->links('vendor.pagination.bootstrap-5') }}
        </div>
    </div>
</section>

<!-- Modal for deleting user -->
<!-- Modal for deleting user -->
<div class="modal fade" id="deleteJobApplicationModal" tabindex="-1" role="dialog" aria-labelledby="deleteJobApplicationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteJobApplicationModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this job application?
            </div>
            <div class="modal-footer">
                <!-- Cancel Button -->
                <button type="button" class="btn btn-secondary" onclick="hideModal()">Cancel</button>
                <form id="deleteForm" action="{{route('admin.applications.destroy', $application->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('customJs')
<script>
    function deleteJobApplication(Id) {
        $('#deleteForm').attr('action', '/admin/jobs-applications/' + Id);
        $('#deleteJobApplicationModal').modal('show');
    }
    function hideModal() {
        // Hide the modal using Bootstrap's modal hide function
        $('#deleteJobApplicationModal').modal('hide');
    }
    function goBack() {
        window.history.back();
    }
    $('#deleteForm').submit(function(e) {
    e.preventDefault(); // Prevent the default form submission

    var formAction = $(this).attr('action');

    $.ajax({
        url: formAction,
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response.status === true) {
                // Redirect to the jobs page on successful deletion
                window.location.href = response.redirect_url;
            } else {
                // Handle any errors if necessary
                alert('Job Application could not be deleted. Please try again.');
            }
        },
        error: function() {
            alert('An error occurred. Please try again.');
        }
    });
});

</script>
@endsection
