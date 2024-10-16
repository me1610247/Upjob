@extends('front.layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        @if(Session::has('success'))
        <div class="alert alert-success">
            <p class="mb-0 pb-0">{{Session::get('success')}}</p>
        </div>
        @endif
        @if(Session::has('error'))
        <div class="alert alert-danger">
            <p class="mb-0 pb-0">{{Session::get('error')}}</p>
        </div>
        @endif
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <p>we w'll send a link to your email, use that link to reset password</p>
                    <form action="{{route('account.forgetPasswordPost')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" class="form-control @error('email')
                                is-invalid
                            @enderror" placeholder="Enter Your Email">

                        </div> 
                        <div class="justify-content-between d-flex">
                        <button type="submit" class="btn btn-primary mt-2">Reset</button>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>
@endsection