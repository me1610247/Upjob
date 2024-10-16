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
            <form action="{{ route('account.saveJob') }}" method="POST" id="createJobForm" name="createJobForm">
               @csrf
                <div class="card border-0 shadow mb-4 ">
                    <div class="card-body card-form p-4">
                        <h3 class="fs-4 mb-1">Job Details</h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Title<span class="req">*</span></label>
                                <input type="text" placeholder="Job Title" id="title" name="title" class="form-control">
                                <p></p>
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Category<span class="req">*</span></label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if($categories->isNotEmpty())
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option> 
                                    @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                <select name="jobType" id="jobType" class="form-select">
                                    <option value="">Select a Job Type</option>
                                    @if($job_types->isNotEmpty())
                                    @foreach ($job_types as $job_type)
                                        <option value="{{$job_type->id}}">{{$job_type->name}}</option> 
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                <p></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Expected Salary<span class="req">*</span></label>
                                <input type="number" placeholder="Salary" id="salary" name="salary" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Location<span class="req">*</span></label>
                                <input type="text" placeholder="location" id="location" name="location" class="form-control">
                                <p></p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="" class="mb-2">Description<span class="req">*</span></label>
                            <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description"></textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Benefits</label>
                            <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Responsibility</label>
                            <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility"></textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Qualifications</label>
                            <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications"></textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Experience <span class="req">*</span></label>
                            <select name="experience" id="experience" class="form-control">
                                <option  value="">Select Years of Exp.</option>
                                <option value="0"> 0 Years</option>
                                <option value="1_3">1-3 Years</option>
                                <option value="3_plus">+3 Years</option>
                                <option value="5_plus">+5 Years</option>
                                <option value="8_plus">+8 Years</option>
                                <option value="10_plus">+10 Years</option>
                                <p></p>
                            </select>
                        </div>
                        
                        

                        <div class="mb-4">
                            <label for="" class="mb-2">Keywords<span class="req">*</span></label>
                            <input type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                            <p></p>
                        </div>

                        <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Name<span class="req">*</span></label>
                                <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Location</label>
                                <input type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                                <p></p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="" class="mb-2">Website</label>
                            <input type="text" placeholder="Website" id="company_website" name="company_website" class="form-control">
                            <p></p>
                        </div>
                    </div> 
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-primary">Save Job</button>
                        <a href="{{route("account.createJob")}}" class="btn btn-secondary mx-3">Reset</a>
                    </div>               
                </div>  
            </form>       
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
    $("#createJobForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("account.saveJob") }}', // Update with your saveJob route
            type: 'POST',
            data: $("#createJobForm").serialize(),
            dataType: 'json',
            success: function(response) {
                // If validation fails, display the errors
                if (response.status == false) {
                    var errors = response.errors;
                    // remove the errors text from the fields that doesn't have error
                    $(".form-control").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('');
                        var firstInvalidField = null;
                        // add the error text on the fields that isn't complete yet
                    $.each(errors, function(key, error) {
                      var field = $("#" + key).addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(error[0]); 
                            if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                    }); 
                    // to make the window focus on the error if there is
                    if (firstInvalidField) {
                    $('html, body').animate({
                        scrollTop: firstInvalidField.offset().top - 100 
                    }, 500);

                    firstInvalidField.focus();
                }
                } else {
                    window.location.href = response.redirect_url;
                }
            }
        });
    });
</script>

@endsection