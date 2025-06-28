@extends('front.layouts.app')

@section('main')
<!-- Hero Section - Enhanced -->
<section class="hero-section lazy d-flex align-items-center" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2015&q=80') no-repeat center center; background-size: cover; min-height: 100vh;">    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-12 col-xl-8">
                <h1 class="display-3 text-white fw-bold mb-4" 
                    style="font-family: 'Montserrat', sans-serif; text-shadow: 2px 2px 6px rgba(0,0,0,0.6);">
                    Find Your Dream Home
                </h1>
    
                <p class="lead text-white mb-4" 
                   style="font-size: 1.5rem; font-weight: 300;">
                    Thousands of properties available.
                </p>
    
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ route('jobs') }}" 
                       class="btn btn-primary btn-lg px-5 py-3 rounded-pill" 
                       style="background-color: #2c3e50; border-color: #2c3e50; font-weight: 600; letter-spacing: 0.5px;">
                        Explore Now <i class="fas fa-arrow-right ms-2"></i>
                    </a>
    
                    @if(Auth::check())
                    <button id="detect-location-btn" 
                            class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill" 
                            style="font-weight: 500; letter-spacing: 0.5px;">
                        <i class="fas fa-map-marker-alt me-2"></i> Get Properties By Location   
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</section>
<script>
    document.getElementById("detect-location-btn").addEventListener("click", function () {
        Swal.fire({
            title: 'Location Detection',
            text: 'Your current location will be used to find nearby properties. Do you agree to share your location?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                detectUserLocation();
            }
        });
    });
    
    function detectUserLocation() {
        if (navigator.geolocation) {
            // عرض تحميل أثناء جلب البيانات
            Swal.fire({
                title: 'جاري تحديد موقعك',
                html: 'الرجاء الانتظار...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
    
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    // إخفاء تحميل السابق
                    Swal.close();
                    
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    getAreaFromCoordinates(lat, lon);
                },
                function (error) {
                    Swal.fire({
                        title: 'خطأ',
                        text: getErrorMessage(error.code),
                        icon: 'error'
                    });
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        } else {
            Swal.fire({
                title: 'غير مدعوم',
                text: 'المتصفح الخاص بك لا يدعم تحديد الموقع',
                icon: 'error'
            });
        }
    }
    
    function getAreaFromCoordinates(lat, lon) {
        // عرض تحميل جديد
        Swal.fire({
            title: 'جاري تحديد منطقتك',
            html: 'الرجاء الانتظار...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    
        // استخدام Nominatim API
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json&accept-language=ar`)
            .then(response => response.json())
            .then(data => {
                Swal.close();
                const address = data.address;
                const area = address.suburb || address.city_district || address.city || address.town || address.village;
                
                if (area) {
                    window.location.href = `/properties/nearby?area=${encodeURIComponent(area)}&lat=${lat}&lon=${lon}`;
                } else {
                    Swal.fire({
                        title: 'خطأ',
                        text: 'تعذر تحديد منطقتك بدقة',
                        icon: 'error'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء تحديد الموقع',
                    icon: 'error'
                });
                console.error(error);
            });
    }
    
    function getErrorMessage(code) {
        switch(code) {
            case 1:
                return 'تم رفض الإذن لتحديد الموقع';
            case 2:
                return 'تعذر تحديد موقعك';
            case 3:
                return 'انتهت المهلة قبل تحديد الموقع';
            default:
                return 'حدث خطأ غير معروف';
        }
    }
    </script>
    
    <!-- تأكد من إضافة SweetAlert2 في head -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Search Section - Enhanced -->
<section class="section-1 py-5" style="background-color: #f8f9fa;"> 
    <div class="container">
        @if(Auth::check())
        <form action="" name="searchForm" id="searchForm">
            <div class="card border-0 shadow p-5 rounded-3" style="background-color: #fff; margin-top: -80px;">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-lg" name="keyword" id="keyword" placeholder="Search by keyword" style="border-radius: 8px; border: 1px solid #e0e0e0;">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-lg" name="location" id="location" placeholder="Search by location" style="border-radius: 8px; border: 1px solid #e0e0e0;">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-lg" name="company_name" id="company_name" placeholder="Search by Agency" style="border-radius: 8px; border: 1px solid #e0e0e0;">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill" style="background-color: #3498db; border-color: #3498db; font-weight: 600;">Search</button>
                    </div>
                </div>            
            </div>
        </form>
        @endif
    </div>
</section>

@if(Auth::check())
    <p id="current-area" class="mt-3 text-white fs-5 fw-bold text-center"></p>
    <div id="nearby-properties" class="mt-5 bg-white rounded shadow-sm p-4">
        <!-- سيتم تعبئة البطاقات هنا -->
    </div>
@endif

<!-- Property Types Section - Enhanced -->
<section class="section-2 py-5" style="background-color: #fff;">
    <div class="container">
        <h2 class="text-center mb-5" style="font-family: 'Montserrat', sans-serif; color: #2c3e50; font-weight: 700; position: relative;">
            Popular Property Types
            
            <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background-color: #3498db;"></span>
        </h2>
        <div class="row g-4">
            @if($categories->isNotEmpty())
            @foreach($categories as $category)            
            <div class="col-lg-4 col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 text-center p-4 rounded-3" style="transition: all 0.3s ease; border-top: 4px solid #3498db;">
                    <a href="{{route('jobs').'?category='.$category->id}}" class="text-decoration-none">
                        <div class="icon-container mb-3" style="font-size: 2.5rem; color: #3498db;">
                            <i class="fas fa-home"></i>
                        </div>
                        <h4 class="mb-3" style="color: #2c3e50; font-weight: 600;">{{$category->name}}</h4>
                        <p class="mb-0" style="color: #7f8c8d;"> <span class="fw-bold" style="color: #3498db;">{{$category->jobs->count()}}</span> Available listings</p>
                    </a>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Similar Jobs Section - Enhanced -->
@if(Auth::check() && $similarJobs->isNotEmpty())
    <section class="section-3 py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <h2 class="text-center mb-5" style="font-family: 'Montserrat', sans-serif; color: #2c3e50; font-weight: 700; position: relative;">
                Jobs You Might Like
                <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background-color: #3498db;"></span>
            </h2>
            <div class="row g-4">
                @foreach($similarJobs as $job)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                            @php
                            $staticImages = [
                              'assets/properties/prop1 (1).jpg',
                              'assets/properties/prop1 (2).jpg',
                              'assets/properties/prop1 (3).jpg',
                              'assets/properties/prop1 (4).jpg',
                              'assets/properties/prop1 (5).jpg',
                              'assets/properties/prop1 (6).jpg',
                              'assets/properties/prop1 (7).jpg',
                              'assets/properties/prop1 (8).jpg',
                              'assets/properties/prop1 (9).jpg',
                              'assets/properties/prop1 (10).jpg',
                              'assets/properties/prop1 (11).jpg',
                              'assets/properties/prop1 (12).jpg',
                              'assets/properties/prop1 (13).jpg',
                              'assets/properties/prop1 (14).jpg',
                              'assets/properties/prop1 (15).jpg',
                              'assets/properties/prop1 (16).jpg',
                              'assets/properties/prop1 (17).jpg',
                              'assets/properties/prop1 (18).jpg',
                          ];
                              $randomImage = $staticImages[array_rand($staticImages)];
                          @endphp
                            @if($job->image)
                            <img src="{{ asset($randomImage) }}" class="card-img-top" alt="Static Property Image" style="height: 200px; object-fit: cover;">
                            @else
                            <img src="{{ asset($randomImage) }}" class="card-img-top" alt="Static Property Image" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h3 class="card-title fs-5 fw-bold" style="color: #2c3e50;">{{ $job->title }}</h3>
                                    <span class="badge bg-primary rounded-pill" style="background-color: #3498db;">Featured</span>
                                </div>
                                <p class="card-text text-muted small">By {{ Str::words($job->company_name, 5) }}</p>
                                <p class="card-text text-muted desc_height">{{ Str::words($job->description, 5) }}</p>
                                <div class="property-meta bg-light p-3 rounded-2 mt-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-map-marker-alt me-2" style="color: #3498db;"></i>
                                        <span>{{ $job->location }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-home me-2" style="color: #3498db;"></i>
                                        <span>{{ $job->jobType->name }}</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-tags me-2" style="color: #3498db;"></i>
                                        <span>{{ $job->category->name }}</span>
                                    </div>
                                    @if(!empty($job->salary))
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-bill-wave me-2" style="color: #3498db;"></i>
                                        <span>EGP {{ number_format($job->salary) }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="d-grid mt-4">
                                    <a href="{{ route('details', $job->id) }}" class="btn btn-primary btn-lg rounded-pill" style="background-color: #2c3e50; border-color: #2c3e50;">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- Featured Properties Section - Enhanced -->
<section class="section-3 py-5" style="background-color: #fff;">
    <div class="container">
        <h2 class="text-center mb-5" style="font-family: 'Montserrat', sans-serif; color: #2c3e50; font-weight: 700; position: relative;">
            Featured Properties (Premium)
            <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background-color: #3498db;"></span>
        </h2>
        <div class="row g-4">
            @if($featuredJobs->isNotEmpty())
            @foreach($featuredJobs as $featuredJob)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                    @php
                    $staticImages = [
                      'assets/properties/prop1 (1).jpg',
                      'assets/properties/prop1 (2).jpg',
                      'assets/properties/prop1 (3).jpg',
                      'assets/properties/prop1 (4).jpg',
                      'assets/properties/prop1 (5).jpg',
                      'assets/properties/prop1 (6).jpg',
                      'assets/properties/prop1 (7).jpg',
                      'assets/properties/prop1 (8).jpg',
                      'assets/properties/prop1 (9).jpg',
                      'assets/properties/prop1 (10).jpg',
                      'assets/properties/prop1 (11).jpg',
                      'assets/properties/prop1 (12).jpg',
                      'assets/properties/prop1 (13).jpg',
                      'assets/properties/prop1 (14).jpg',
                      'assets/properties/prop1 (15).jpg',
                      'assets/properties/prop1 (16).jpg',
                      'assets/properties/prop1 (17).jpg',
                      'assets/properties/prop1 (18).jpg',
                  ];
                      $randomImage = $staticImages[array_rand($staticImages)];
                  @endphp
                    <div class="position-relative">
                        @if($featuredJob->image)
                        <img src="{{ asset($randomImage) }}" class="card-img-top" alt="Static Property Image" style="height: 200px; object-fit: cover;">
                        @else
                        <img src="{{ asset($randomImage) }}" class="card-img-top" alt="Static Property Image" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="position-absolute top-0 end-0 bg-warning text-white px-3 py-1 rounded-bl" style="background-color: #e67e22 !important;">
                            <i class="fas fa-crown me-1"></i> Premium
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title fs-5 fw-bold" style="color: #2c3e50;">{{$featuredJob->title}}</h3>
                        <p class="card-text text-muted small">By {{ Str::words($featuredJob->company_name,5)}}</p>
                        <p class="card-text text-muted desc_height">{{ Str::words($featuredJob->description,5)}}</p>
                        <div class="property-meta bg-light p-3 rounded-2 mt-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt me-2" style="color: #3498db;"></i>
                                <span>{{$featuredJob->location}}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-home me-2" style="color: #3498db;"></i>
                                <span>{{$featuredJob->jobType->name}}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-tags me-2" style="color: #3498db;"></i>
                                <span>{{$featuredJob->category->name}}</span>
                            </div>
                            @if(!empty($featuredJob->salary))
                            <div class="d-flex align-items-center">
                                <i class="fas fa-money-bill-wave me-2" style="color: #3498db;"></i>
                                <span>EGP {{ number_format($featuredJob->salary) }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="d-grid mt-4">
                            <a href="{{route('details',$featuredJob->id)}}" class="btn btn-primary btn-lg rounded-pill" style="background-color: #2c3e50; border-color: #2c3e50;">View Details</a>
                        </div>
                    </div>
                </div>
            </div>  
            @endforeach
            @endif                       
        </div>
    </div>
</section>

<!-- Latest Listings Section - Enhanced -->
<section class="section-4 py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <h2 class="text-center mb-5" style="font-family: 'Montserrat', sans-serif; color: #2c3e50; font-weight: 700; position: relative;">
            Latest Listings
            <span style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); width: 80px; height: 3px; background-color: #3498db;"></span>
        </h2>
        <div class="row g-4">
            @if($latestJobs->isNotEmpty())
            @foreach($latestJobs as $latestJob)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden">
                    <div class="position-relative">
                        @php
                        $staticImages = [
                            'assets/properties/prop1 (1).jpg',
                            'assets/properties/prop1 (2).jpg',
                            'assets/properties/prop1 (3).jpg',
                            'assets/properties/prop1 (4).jpg',
                            'assets/properties/prop1 (5).jpg',
                            'assets/properties/prop1 (6).jpg',
                            'assets/properties/prop1 (7).jpg',
                            'assets/properties/prop1 (8).jpg',
                            'assets/properties/prop1 (9).jpg',
                            'assets/properties/prop1 (10).jpg',
                            'assets/properties/prop1 (11).jpg',
                            'assets/properties/prop1 (12).jpg',
                            'assets/properties/prop1 (13).jpg',
                            'assets/properties/prop1 (14).jpg',
                            'assets/properties/prop1 (15).jpg',
                            'assets/properties/prop1 (16).jpg',
                            'assets/properties/prop1 (17).jpg',
                            'assets/properties/prop1 (18).jpg',
                        ];
                        $randomImage = $staticImages[array_rand($staticImages)];
                    @endphp
                    
                    @if($latestJob->image)
                    <img src="{{ asset($randomImage) }}" class="card-img-top" alt="Static Property Image" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset($randomImage) }}" class="card-img-top" alt="Static Property Image" style="height: 200px; object-fit: cover;">
                    @endif
                    
                        <div class="position-absolute top-0 start-0 bg-info text-white px-3 py-1 rounded-br">
                            New
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title fs-5 fw-bold" style="color: #2c3e50;">{{ $latestJob->title }}</h3>
                        <p class="card-text text-muted small">By {{ Str::words($latestJob->company_name,5)}}</p>
                        <p class="card-text text-muted desc_height">Description: {{ Str::words($latestJob->description, 5) }}</p>
                        <div class="property-meta bg-light p-3 rounded-2 mt-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-map-marker-alt me-2" style="color: #3498db;"></i>
                                <span>{{ $latestJob->location }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-home me-2" style="color: #3498db;"></i>
                                <span>{{ $latestJob->jobType->name }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-tags me-2" style="color: #3498db;"></i>
                                <span>{{ $latestJob->category->name }}</span>
                            </div>
                            @if(!empty($latestJob->salary))
                            <div class="d-flex align-items-center">
                                <i class="fas fa-money-bill-wave me-2" style="color: #3498db;"></i>
                                <span>EGP {{ number_format($latestJob->salary) }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="d-grid mt-4">
                            <a href="{{ route('details', $latestJob->id) }}" class="btn btn-primary btn-lg rounded-pill" style="background-color: #2c3e50; border-color: #2c3e50;">View Details</a>
                        </div>
                    </div>
                </div>
            </div>  
            @endforeach
            @else
            <div class="col-md-12">
                <div class="alert alert-info text-center rounded-3" role="alert" style="background-color: #d1ecf1; color: #0c5460; border-color: #bee5eb;">
                    <i class="fas fa-info-circle me-2"></i> No Properties Found
                </div>
            </div>
            @endif                       
        </div>
    </div>
</section>

<style>
    /* Global Styles */
    body {
        font-family: 'Open Sans', sans-serif;
        color: #34495e;
    }
    
    .hero-section {
        background-attachment: fixed;
    }
    
    .desc_height {
        height: 50px;
        overflow: hidden;
    }
    
    .card {
        transition: all 0.3s ease;
        border: none;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
    
    .property-meta {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
    }
    
    .btn-primary {
        background-color: #3498db;
        border-color: #3498db;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #2980b9;
        border-color: #2980b9;
        transform: translateY(-2px);
    }
    
    .btn-outline-primary {
        color: #3498db;
        border-color: #3498db;
        font-weight: 600;
    }
    
    .btn-outline-primary:hover {
        background-color: #3498db;
        color: white;
    }
    
    .rounded-3 {
        border-radius: 1rem !important;
    }
    
    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 2.5rem;
        }
        
        .hero-section p.lead {
            font-size: 1.25rem;
        }
    }
</style>

<!-- Add these in your head section -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
@section('customJs')
<script>
 $("#searchForm").submit(function(e) {
    e.preventDefault();

    var url = '{{ route("jobs") }}';
    var keyword = $("#keyword").val();
    var location = $("#location").val();
    var companyName = $("#company_name").val(); // Get company name value

    var queryString = [];

    if (keyword != "") {
        queryString.push('keyword=' + encodeURIComponent(keyword));
    }
    if (location != "") {
        queryString.push('location=' + encodeURIComponent(location));
    }
    if (companyName != "") {
        queryString.push('company_name=' + encodeURIComponent(companyName)); // Add company name to query string
    }

    if (queryString.length > 0) {
        url += '?' + queryString.join('&');
    }

    window.location.href = url;
});
    </script>
@endsection
