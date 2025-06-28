<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Find the best properties with Nile Nest">
    <meta name="pinterest" content="nopin">
    <meta name="HandheldFriendly" content="True">
    <title>Nile Nest | Find Best Properties</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="#" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Fonts and Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body data-instant-intensity="mousedown">

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand fw-bold fs-3" href="{{ route('home') }}" style="color: #2c3e50; font-family: 'Poppins', sans-serif;">Nile Nest</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link fs-5" href="{{ route('home') }}">Home</a>
                    </li>
                    @if(Auth::check())
                        <li class="nav-item">
                            <a class="nav-link fs-5" href="{{ route('jobs') }}">Find Properties</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 text-danger" href="{{ route('account.logout') }}">Logout</a>
                        </li>
                    @endif
                </ul>

                @if(!Auth::check())
                    <a class="btn btn-outline-primary me-2 fs-5" href="{{ route('account.login') }}">Login</a>
                @else
                    @if(Auth::user()->role == 'admin')
                        <a class="btn btn-primary me-2 fs-5" href="{{ route('account.createJob') }}">Post a Property</a>
                        <a class="btn btn-outline-primary me-2 fs-5" href="{{ route('admin.dashboard') }}">Admin</a>
                    @endif
                    <a class="btn btn-outline-primary fs-5" href="{{ route('account.profile') }}">Account</a>
                @endif
            </div>
        </div>
    </nav>
</header>

<main>
    @yield('main')
</main>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="profilePicForm" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <p class="text-danger" id="image-error"></p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<footer class="bg-dark py-4 mt-5">
    <div class="container text-center">
        <p class="text-white mb-0">&copy; 2025 Nile Nest. All rights reserved.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#profilePicForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '{{ route("account.updateProfilePic") }}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === false) {
                    $('#image-error').text(response.errors.image || '');
                } else {
                    window.location.reload();
                }
            }
        });
    });
</script>

@yield('customJs')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
</body>
</html>
