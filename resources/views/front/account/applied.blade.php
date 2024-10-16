@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Applied Jobs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h4>Jobs You've Received Applications -</h4>
                        @if(!empty($appliedJobs))
                            @foreach($appliedJobs as $appliedJob)
                                <h5>Job Title: {{ $appliedJob['job']->title }}</h5>
                                <ul class="list-group">
                                    @foreach($appliedJob['applications'] as $application)
                                        <li class="list-group-item">
                                            <h5>Employee Name: {{ $application->user->name }}</h5>
                                            @if($application->resume)
                                            <!-- Link to download or view the resume -->
                                            {{-- php artisan storage:link must be run in the terminal first  --}}
                                            <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" class="btn btn-sm btn-outline-success">View Resume</a>
                                            @else
                                            <span class="text-muted">No resume uploaded</span>
                                        @endif                           
                                      </li>
                                      <hr>
                                    @endforeach
                                </ul>
                            @endforeach
                        @else
                            <p>No applications for your jobs yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
