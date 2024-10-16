<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{route('account.profile')}}">Users</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{route('account.createJob')}}">Jobs</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{route('account.myJobs')}}">Jobs Applications</a>
            </li>                                                      
            <button class="btn btn-danger my-3 mb-3 ">
                <a class="text-white p-2" href="{{route('account.logout')}}">Logout</a>    
            </button>                                                     
        </ul>
    </div>
</div>