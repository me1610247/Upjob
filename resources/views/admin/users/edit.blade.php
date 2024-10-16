@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2 py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Users</li>
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
                        <i class="fas fa-briefcase fa-2x text-secondary mb-3"></i>
                        <h5 class="card-title">Manage Jobs</h5>
                        <p class="card-text">View and edit jobs listed on the platform.</p>
                        <a href="{{route('admin.jobs')}}" class="btn btn-light bg-dark text-light btn-sm">Go to Jobs</a>
                    </div>
                </div>
            </div>
            <!-- Third Card -->
            <div class="col-md-4 mb-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body">
                        <i class="fas fa-file-alt fa-2x text-warning mb-3"></i>
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
                        <h4 class="card-title">User Management</h4>
                        @include('front.layouts.message')
                        <form action="{{route('admin.update',$user->id)}}" method="POST" id="userForm" name="userForm">
                            @csrf
                            @method('PUT')
                             <div class="card-body  p-4">
                             <h3 class="fs-4 mb-1">User with id ({{$user->id}}) Information</h3>
                             <div class="mb-4">
                                 <label for="" class="mb-2">Name</label>
                                 <input type="text" name="name" id="name" readonly class="form-control" value="{{$user->name}}">
                             </div>
                             <div class="mb-4">
                                 <label for="" class="mb-2">Designation</label>
                                 <input type="text" id="designation" name="designation" value="{{$user->designation}}" placeholder="Designation" class="form-control">
                                <p></p>
                                </div>  
                             <div class="mb-4">
                                <label for="role" class="mb-2">Role</label>
                                <select name="role" id="role" class="form-select">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <p></p>
                            </div>
                            
                               
                         </div>
                         <div class="card-footer ">
                            <button type="submit" class="btn btn-primary">Update</button>
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
     $("#userForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: '{{ route("admin.update",$user->id) }}',
            type: 'put',
            data: $("#userForm").serializeArray(),
            dataType: 'json',
            success: function(response){
                if (response.status == false) {
                    var errors=response.errors;
                    if(errors.designation){
                        $("#designation").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.designation)
                    }else{
                        $("#designation").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html(errors.designation)
                    }
                    if(errors.role){
                        $("#role").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback')
                        .html(errors.role)
                    }else{
                        $("#role").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html(errors.role)
                    }
                   
                }else{
                    $("#designation").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('');
                     $("#role").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback')
                        .html('');
                    window.location.href='{{route("admin.users")}}'
                    window.location.reload();

                }
            }
        });
    })
    function goBack() {
        window.history.back();
    }

</script>
@endsection
