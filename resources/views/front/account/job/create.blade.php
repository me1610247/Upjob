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
                <form action="{{ route('account.saveJob') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body card-form p-4">
                            <h3 class="fs-4 mb-1">Property Details</h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                                    <input type="text" placeholder="Property Title" id="title" name="title" class="form-control">
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        let categorySelect = document.getElementById("category");
                                        let residentialTypeDiv = document.getElementById("residentialTypeDiv");
                                        let roomsDiv = document.getElementById("roomsDiv");
                                        let bathroomsDiv = document.getElementById("bathroomsDiv");
                                
                                        function toggleFields() {
                                            let selectedValue = categorySelect.value; // Get the selected value (category ID)
                                            if (selectedValue == 1) { // Compare with the ID of the Residential category
                                                residentialTypeDiv.style.display = "block";
                                                roomsDiv.style.display = "block";
                                                bathroomsDiv.style.display = "block";
                                            } else {
                                                residentialTypeDiv.style.display = "none";
                                                roomsDiv.style.display = "none";
                                                bathroomsDiv.style.display = "none";
                                            }
                                        }
                                
                                        categorySelect.addEventListener("change", toggleFields);
                                        toggleFields(); // Call the function initially to set the correct state
                                    });
                                </script>
                                
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Property Type<span class="req">*</span></label>
                                    <select name="category" id="category" class="form-control">
                                        <option disabled selected value="">Select a Property Type</option>
                                        @if($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-4" id="residentialTypeDiv" style="display: none;">
                                    <label for="" class="mb-2">Residential Type<span class="req">*</span></label>
                                    <select name="residential_type" id="residential_type" class="form-control">
                                        <option disabled selected value="">Select Type</option>
                                        <option value="house">House</option>
                                        <option value="villa">Villa</option>
                                        <option value="studio">Studio</option>
                                        <option value="apartment">Apartment</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-4" id="roomsDiv" style="display: none;">
                                    <label for="" class="mb-2">No. of Rooms<span class="req">*</span></label>
                                    <input type="number" min="1" placeholder="Rooms Available" id="vacancy" name="vacancy" class="form-control">
                                </div>
                                
                                <div class="col-md-6 mb-4" id="bathroomsDiv" style="display: none;">
                                    <label for="" class="mb-2">No. of Bathrooms<span class="req">*</span></label>
                                    <input type="number" min="1" placeholder="No. of Bathrooms" id="bathrooms" name="bathrooms" class="form-control">
                                </div>
                            </div>
                
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="" class="mb-2">Listing Type<span class="req">*</span></label>
                                    <select name="jobType" id="jobType" class="form-select">
                                        <option disabled selected value="">Select Listing Type</option>
                                        @if($job_types->isNotEmpty())
                                            @foreach ($job_types as $job_type)
                                                <option value="{{$job_type->id}}">{{$job_type->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                                    <input type="text" placeholder="Location" id="location" name="location" class="form-control">
                                </div>
                            </div>
                
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Price<span class="req">*</span></label>
                                    <input type="number" placeholder="Price" id="salary" name="salary" class="form-control">
                                </div>
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Property Image<span class="req">*</span></label>
                                    <input type="file" name="image" id="image" class="form-control border border-primary shadow-sm" accept="image/*">
                                </div>
                                
                            </div>
                
                            <div class="mb-4">
                                <label for="" class="mb-2">Property Description<span class="req">*</span></label>
                                <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Property Description"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Property Features</label>
                                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Property Features"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Additional Information</label>
                                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Additional Information"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Nearby Amenities</label>
                                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Nearby Amenities"></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Property Age<span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-control">
                                    <option value="">Select Property Age</option>
                                    <option value="0">New</option>
                                    <option value="1_3">1-3 Years</option>
                                    <option value="3_plus">3+ Years</option>
                                    <option value="5_plus">5+ Years</option>
                                    <option value="8_plus">8+ Years</option>
                                    <option value="10_plus">10+ Years</option>
                                </select>
                            </div>
                
                            <div class="mb-4">
                                <label for="" class="mb-2">Search Keywords<span class="req">*</span></label>
                                <input type="text" placeholder="Keywords" id="keywords" name="keywords" class="form-control">
                            </div>
                
                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Agency Details</h3>
                
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Agency Name<span class="req">*</span></label>
                                    <input type="text" placeholder="Agency Name" id="company_name" name="company_name" class="form-control">
                                </div>
                
                                <div class="mb-4 col-md-6">
                                    <label for="" class="mb-2">Agency Location</label>
                                    <input type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                </div>
                            </div>
                
                            <div class="mb-4">
                                <label for="" class="mb-2">Agency Website</label>
                                <input type="text" placeholder="Website" id="company_website" name="company_website" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Save Property</button>
                            <a href="{{route('account.createJob')}}" class="btn btn-secondary mx-3">Reset</a>
                        </div>
                    </div>
                </form>
                   
            </div>
        </div>
    </div>
</section>
@endsection
