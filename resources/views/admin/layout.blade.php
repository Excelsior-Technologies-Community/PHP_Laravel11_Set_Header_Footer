<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - {{ $siteSettings->site_name ?? 'My Shop' }}</title>

    @if($siteSettings && $siteSettings->site_favicon)
        <link rel="icon" href="{{ asset('images/' . $siteSettings->site_favicon) }}" type="image/x-icon">
    @endif

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: #1a1d23;
            position: fixed;
            width: 260px;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid #2d3139;
        }
        .sidebar-brand h4 {
            color: #fff;
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .sidebar-brand small {
            color: #8b919d;
            font-size: 0.75rem;
        }
        .sidebar-nav {
            padding: 15px 0;
        }
        .sidebar .nav-link {
            color: #b0b5bf;
            padding: 12px 20px;
            border-radius: 0;
            margin: 2px 0;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover {
            background: #2d3139;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background: #0d6efd;
            color: #fff;
            border-radius: 8px;
            margin: 2px 10px;
            padding: 12px 15px;
        }
        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 1.1rem;
        }
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }
        .top-header {
            background: #fff;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .content-area {
            padding: 30px;
        }
        .card-stat {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }
        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .data-table {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .data-table .table {
            margin-bottom: 0;
        }
        .data-table thead {
            background: #f8f9fa;
        }
        .data-table thead th {
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            color: #495057;
            padding: 15px;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .data-table tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #495057;
        }
        .data-table tbody tr:hover {
            background: #f8f9fa;
        }
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
            margin: 2px;
        }
        .form-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 30px;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
            font-size: 0.95rem;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }
        .image-preview {
            max-width: 150px;
            max-height: 150px;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
            padding: 10px;
            margin-top: 10px;
        }
        .alert-custom {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
        }
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px;
                transition: margin-left 0.3s;
            }
            .sidebar.show {
                margin-left: 0;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="sidebar-brand">
            <h4>{{ $siteSettings->site_name ?? 'Admin Panel' }}</h4>
            <small>Management Dashboard</small>
        </div>
        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="bi bi-box"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i> Settings
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <a href="{{ route('products.index') }}" class="nav-link">
                        <i class="bi bi-arrow-left"></i> Back to Site
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Top Header --}}
        <div class="top-header">
            <div>
                <button class="btn btn-dark d-md-none me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu">
                    <i class="bi bi-list"></i>
                </button>
                <h5 class="mb-0 d-inline">@yield('title', 'Dashboard')</h5>
            </div>
            <div>
                <span class="text-muted">Welcome, <strong>Admin</strong></span>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="content-area">
                <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        {{-- Page Content --}}
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
