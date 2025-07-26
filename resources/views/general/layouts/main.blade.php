<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Access Computer Shop - {{ $title }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Icons & Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('templates/general-template/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/general-template/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/general-template/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Bootstrap & Custom Styles -->
    <link href="{{ asset('templates/general-template/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('templates/general-template/css/style.css') }}" rel="stylesheet">

    <!-- Custom Enhancements -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            scroll-behavior: smooth;
        }

        .navbar, .topbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .back-to-top {
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: white;
            border: none;
            transition: 0.3s;
        }

        .back-to-top:hover {
            background: linear-gradient(135deg, #0056d2, #4b0ed3);
        }

        .spinner-border {
            border-width: 4px;
        }

        .spinner-border.text-primary {
            color: #6610f2 !important;
        }

        .btn-primary {
            background-color: #6610f2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #4b0ed3;
        }

        a {
            transition: all 0.3s ease;
        }

        a:hover {
            color: #6610f2;
        }

        .card, .section {
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover, .section:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    @include('general.partials.topbar')
    @include('general.partials.navbar')
    @yield('container')
    @include('general.partials.footer')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('templates/general-template/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('templates/general-template/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('templates/general-template/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('templates/general-template/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('templates/general-template/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('templates/general-template/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('templates/general-template/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('templates/general-template/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('templates/general-template/js/main.js') }}"></script>

    <!-- Extra JS -->
    <script>
        new WOW().init(); // animate on scroll
    </script>
</body>

</html>
