<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        {{-- Dynamic Brand / Logo --}}
        @if($siteSettings && $siteSettings->site_logo)
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/' . $siteSettings->site_logo) }}" alt="{{ $siteSettings->site_name ?? 'My Shop' }}">
            </a>
        @else
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ $siteSettings->site_name ?? 'My Shop' }}
            </a>
        @endif

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a href="{{ route('products.index') }}" 
                       class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                        <i class="bi bi-box me-1"></i> Products
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 me-1"></i> Admin
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
