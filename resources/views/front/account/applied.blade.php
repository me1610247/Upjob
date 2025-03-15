@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-light">
    <div class="container py-5">
        <!-- Breadcrumb -->
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="bg-white rounded-3 p-3 mb-4 shadow-sm">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-secondary">Home</a></li>
                        <li class="breadcrumb-item active">Applied Properties</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h4 class="fw-bold mb-4">Properties You've Received Applications</h4>

                        @if(!empty($appliedJobs))
                            @foreach($appliedJobs as $appliedJob)
                                <div class="card mb-4 border-0 shadow-sm">
                                    <div class="card-body">
                                        <!-- Property Details -->
                                        <div class="row">
                                            <!-- Property Image -->
                                            <div class="col-md-3">
                                                @if($appliedJob['job']->image)
                                                    <img src="{{ asset('storage/' . $appliedJob['job']->image) }}" alt="Property Image" class="img-fluid rounded" style="width: 100%; height: 150px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets/images/default-property.jpg') }}" alt="Default Property Image" class="img-fluid rounded" style="width: 100%; height: 150px; object-fit: cover;">
                                                @endif
                                            </div>

                                            <!-- Property Info -->
                                            <div class="col-md-9">
                                                <h5 class="fw-bold">{{ $appliedJob['job']->title }}</h5>
                                                <div class="text-muted mb-2">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $appliedJob['job']->location }}
                                                </div>
                                                <div class="text-muted mb-2">
                                                    <i class="fas fa-tags"></i> {{ $appliedJob['job']->category->name }}
                                                </div>
                                                <div class="text-muted mb-2">
                                                    <i class="fas fa-dollar-sign"></i> {{ number_format($appliedJob['job']->salary) }}
                                                </div>

                                                <!-- Show Bathrooms and Residential Type if found -->
                                                @if($appliedJob['job']->bathrooms || $appliedJob['job']->residential_type)
                                                    <div class="text-muted mb-2">
                                                        @if($appliedJob['job']->bathrooms)
                                                            <i class="fas fa-bath"></i> {{ $appliedJob['job']->bathrooms }} Bathrooms
                                                        @endif
                                                        @if($appliedJob['job']->residential_type)
                                                            <i class="fas fa-home"></i> {{ ucfirst($appliedJob['job']->residential_type) }}
                                                        @endif
                                                    </div>

                                                    <!-- Show Vacancy if Bathrooms or Residential Type are found -->
                                                    <div class="text-muted mb-2">
                                                        <i class="fas fa-bed"></i> {{ $appliedJob['job']->vacancy }} Rooms
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Applications -->
                                        <div class="mt-4">
                                            <h6 class="fw-bold">Applications:</h6>
                                            <ul class="list-group">
                                                @foreach($appliedJob['applications'] as $application)
                                                    <li class="list-group-item border-0 shadow-sm mb-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <h6 class="fw-bold mb-1">{{ $application->user->name }}</h6>
                                                                <div class="text-muted small">
                                                                    <i class="fas fa-envelope"></i> {{ $application->user->email }}
                                                                </div>
                                                            </div>
                                                        
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info" role="alert">
                                No applications for your properties yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection