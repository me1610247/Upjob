<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('node_modules/admin-lte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/all.min.css') }}">

    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Include Header -->
        @include('admin.partials.header')

        <!-- Include Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Include Footer -->
        @include('admin.partials.footer')
    </div>

    <!-- AdminLTE JS -->
    <script src="{{ asset('node_modules/admin-lte/dist/js/adminlte.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
