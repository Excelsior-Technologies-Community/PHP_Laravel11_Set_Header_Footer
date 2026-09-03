@extends('products.layout')

@section('title', 'Products')

@section('content')

<div class="container mt-4">

    {{-- Success Message --}}
    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>
    </div>

    @endif

    {{-- Validation Errors --}}
    @if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif


    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Our Products
            </h2>

            <p class="text-muted mb-0">
                Explore our collection of products
            </p>

        </div>

        <a
            href="{{ route('products.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>

            Add Product

        </a>

    </div>


    {{-- Filters --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('products.index') }}">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-lg-4 col-md-6">

                        <label class="form-label fw-semibold">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search product..."
                            value="{{ request('search') }}">

                    </div>


                    {{-- Status --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select">

                            <option value="">
                                All
                            </option>

                            <option
                                value="1"
                                {{ request('status') === '1' ? 'selected' : '' }}>

                                Active

                            </option>

                            <option
                                value="0"
                                {{ request('status') === '0' ? 'selected' : '' }}>

                                Inactive

                            </option>

                        </select>

                    </div>


                    {{-- Min Price --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Min Price
                        </label>

                        <input
                            type="number"
                            name="min_price"
                            class="form-control"
                            placeholder="0"
                            min="0"
                            step="0.01"
                            value="{{ request('min_price') }}">

                    </div>


                    {{-- Max Price --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Max Price
                        </label>

                        <input
                            type="number"
                            name="max_price"
                            class="form-control"
                            placeholder="99999"
                            min="0"
                            step="0.01"
                            value="{{ request('max_price') }}">

                    </div>


                    {{-- Sort --}}
                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Sort By
                        </label>

                        <select
                            name="sort"
                            class="form-select">

                            <option
                                value="newest"
                                {{ request('sort', 'newest') == 'newest' ? 'selected' : '' }}>

                                Newest

                            </option>

                            <option
                                value="oldest"
                                {{ request('sort') == 'oldest' ? 'selected' : '' }}>

                                Oldest

                            </option>

                            <option
                                value="name_asc"
                                {{ request('sort') == 'name_asc' ? 'selected' : '' }}>

                                Name A-Z

                            </option>

                            <option
                                value="name_desc"
                                {{ request('sort') == 'name_desc' ? 'selected' : '' }}>

                                Name Z-A

                            </option>

                            <option
                                value="price_low"
                                {{ request('sort') == 'price_low' ? 'selected' : '' }}>

                                Price Low-High

                            </option>

                            <option
                                value="price_high"
                                {{ request('sort') == 'price_high' ? 'selected' : '' }}>

                                Price High-Low

                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}
                    <div class="col-12">

                        <button
                            type="submit"
                            class="btn btn-primary me-2">

                            <i class="bi bi-search me-1"></i>

                            Apply Filters

                        </button>


                        <a
                            href="{{ route('products.index') }}"
                            class="btn btn-outline-secondary me-2">

                            <i class="bi bi-arrow-clockwise me-1"></i>

                            Reset

                        </a>


                        {{-- CSV --}}
                        <a
                            href="{{ route('products.export.csv', request()->query()) }}"
                            class="btn btn-success">

                            <i class="bi bi-file-earmark-spreadsheet me-1"></i>

                            Export CSV

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Product Count --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="mb-0">

            Products:
            <span class="text-primary">
                {{ $products->total() }}
            </span>

        </h5>

        @if(request()->hasAny([
        'search',
        'status',
        'min_price',
        'max_price',
        'sort'
        ]))

        <span class="text-muted">
            Filtered results
        </span>

        @endif

    </div>


    {{-- Products Grid --}}
    <div class="row g-4">

        @forelse($products as $product)

        <div class="col-lg-4 col-md-6">

            <div class="card h-100 shadow-sm border-0 product-card">

                {{-- Image --}}
                @if($product->image)

                @if(str_starts_with($product->image, 'http'))

                <img
                    src="{{ $product->image }}"
                    class="card-img-top"
                    alt="{{ $product->product_name }}"
                    style="height:220px;object-fit:cover;">

                @else

                <img
                    src="{{ asset('images/' . $product->image) }}"
                    class="card-img-top"
                    alt="{{ $product->product_name }}"
                    style="height:220px;object-fit:cover;">

                @endif

                @else

                <div
                    class="bg-light d-flex align-items-center justify-content-center"
                    style="height:220px;">

                    <i class="bi bi-image text-muted fs-1"></i>

                </div>

                @endif


                <div class="card-body">

                    {{-- Name --}}
                    <h5 class="card-title fw-bold">
                        {{ $product->product_name }}
                    </h5>


                    {{-- Price --}}
                    <h6 class="text-primary fw-bold mb-2">

                        ${{ number_format($product->price, 2) }}

                    </h6>


                    {{-- Size & Color --}}
                    <p class="card-text small mb-2">

                        @if($product->size)

                        <span class="badge bg-light text-dark border me-1">
                            {{ $product->size }}
                        </span>

                        @endif

                        @if($product->color)

                        <span class="badge bg-light text-dark border">
                            {{ $product->color }}
                        </span>

                        @endif

                    </p>


                    {{-- Description --}}
                    <p class="card-text text-muted small">

                        {{ \Illuminate\Support\Str::limit(
                                $product->description,
                                80
                            ) }}

                    </p>


                    {{-- Status --}}
                    <div class="d-flex justify-content-between align-items-center">

                        @if($product->status)

                        <span class="badge bg-success">
                            Active
                        </span>

                        @else

                        <span class="badge bg-danger">
                            Inactive
                        </span>

                        @endif


                        {{-- Toggle --}}
                        <form
                            action="{{ route(
                                    'products.toggle-status',
                                    $product->id
                                ) }}"
                            method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-sm btn-outline-secondary">

                                <i class="bi bi-arrow-repeat"></i>

                                Toggle

                            </button>

                        </form>

                    </div>


                    {{-- View --}}
                    <div class="mt-3">

                        <a
                            href="{{ route(
                                    'products.show',
                                    $product->id
                                ) }}"
                            class="btn btn-primary w-100">

                            <i class="bi bi-eye me-1"></i>

                            View Product

                        </a>

                    </div>

                </div>

            </div>

        </div>

        @empty

        <div class="col-12 text-center py-5">

            <i
                class="bi bi-search fs-1 text-muted d-block mb-3">
            </i>

            <h5>
                No products found
            </h5>

            <p class="text-muted">
                Try changing your search or filters.
            </p>

            <a
                href="{{ route('products.index') }}"
                class="btn btn-primary">

                Clear Filters

            </a>

        </div>

        @endforelse

    </div>


    {{-- Numeric Pagination --}}
    @if($products->hasPages())

    <div class="mt-4 d-flex justify-content-center">

        <nav>

            <ul class="pagination">

                {{-- Previous --}}
                @if($products->onFirstPage())

                <li class="page-item disabled">
                    <span class="page-link">
                        &laquo;
                    </span>
                </li>

                @else

                <li class="page-item">

                    <a
                        class="page-link"
                        href="{{ $products->previousPageUrl() }}">

                        &laquo;

                    </a>

                </li>

                @endif


                {{-- Numbers --}}
                @for(
                $page = 1;
                $page <= $products->lastPage();
                    $page++
                    )

                    <li
                        class="page-item
                            {{ $page == $products->currentPage()
                                ? 'active'
                                : '' }}">

                        <a
                            class="page-link"
                            href="{{ $products->url($page) }}">

                            {{ $page }}

                        </a>

                    </li>

                    @endfor


                    {{-- Next --}}
                    @if($products->hasMorePages())

                    <li class="page-item">

                        <a
                            class="page-link"
                            href="{{ $products->nextPageUrl() }}">

                            &raquo;

                        </a>

                    </li>

                    @else

                    <li class="page-item disabled">

                        <span class="page-link">
                            &raquo;
                        </span>

                    </li>

                    @endif

            </ul>

        </nav>

    </div>

    @endif

</div>


<style>
    .product-card {
        transition:
            transform 0.3s,
            box-shadow 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);

        box-shadow:
            0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .card-img-top {
        border-radius: 8px 8px 0 0;
    }

    .pagination .page-link {
        min-width: 40px;
        text-align: center;
    }
</style>

@endsection