<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Dynamic Favicon --}}
    @if($siteSettings && $siteSettings->site_favicon)
        <link rel="icon" href="{{ asset('images/' . $siteSettings->site_favicon) }}" type="image/x-icon">
    @endif

    {{-- Dynamic Title --}}
    <title>@yield('title', $siteSettings->site_name ?? 'My Shop')</title>

    {{-- Dynamic Meta Description --}}
    @if($siteSettings && $siteSettings->site_meta_description)
        <meta name="description" content="{{ $siteSettings->site_meta_description }}">
    @endif

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .navbar-brand img {
            height: 45px;
            width: auto;
        }
        .nav-link {
            font-weight: 500;
            padding: 10px 20px !important;
            border-radius: 6px;
            transition: all 0.3s;
        }
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
        }
        .nav-link.active {
            background: rgba(255,255,255,0.2) !important;
        }
        footer {
            background: #1a1d23 !important;
            color: #b0b5bf;
            padding: 60px 0 30px;
            margin-top: 80px;
        }
        footer h5 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 20px;
        }
        footer a {
            color: #b0b5bf;
            text-decoration: none;
            transition: color 0.3s;
        }
        footer a:hover {
            color: #0d6efd;
        }
        .contact-box {
            background: #2d3139;
            padding: 25px;
            border-radius: 12px;
        }
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .contact-item i {
            font-size: 1.2rem;
            margin-right: 12px;
            margin-top: 3px;
        }
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #0d6efd;
            color: #fff;
            border-radius: 50%;
            margin-right: 10px;
            transition: all 0.3s;
        }
        .social-icons a:hover {
            background: #0b5ed7;
            transform: translateY(-3px);
            color: #fff;
        }
    </style>
</head>
<body>

    {{-- Dynamic Header --}}
    @include('products.header')

    {{-- Page Content --}}
    <main class="container mt-4">
        @yield('content')
    </main>

    {{-- Dynamic Footer --}}
    @include('products.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
