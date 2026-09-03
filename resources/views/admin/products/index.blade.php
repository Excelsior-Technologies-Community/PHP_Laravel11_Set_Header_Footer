@extends('admin.layout')

@section('title', 'Manage Products')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Products
            </h2>

            <p class="text-muted mb-0">
                Manage, filter and export your products.
            </p>

        </div>

        <div class="mt-3 mt-md-0">

            <a
                href="{{ route('admin.products.create') }}"
                class="btn btn-primary">

                <i class="bi bi-plus-circle me-1"></i>

                Add Product

            </a>

        </div>

    </div>


    {{-- Success --}}
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


    {{-- Filters --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form
                method="GET"
                action="{{ route('admin.products.index') }}">

                <div class="row g-3">

                    {{-- Search --}}
                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Search
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Search products..."
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
                                All Status
                            </option>

                            <option
                                value="1"
                                {{ request('status') === '1'
                                    ? 'selected'
                                    : '' }}>

                                Active

                            </option>

                            <option
                                value="0"
                                {{ request('status') === '0'
                                    ? 'selected'
                                    : '' }}>

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
                            min="0"
                            step="0.01"
                            placeholder="0"
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
                            min="0"
                            step="0.01"
                            placeholder="99999"
                            value="{{ request('max_price') }}">

                    </div>


                    {{-- Sort --}}
                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            Sort By
                        </label>

                        <select
                            name="sort"
                            class="form-select">

                            <option
                                value="newest"
                                {{ request('sort', 'newest') == 'newest'
                                    ? 'selected'
                                    : '' }}>

                                Newest

                            </option>

                            <option
                                value="oldest"
                                {{ request('sort') == 'oldest'
                                    ? 'selected'
                                    : '' }}>

                                Oldest

                            </option>

                            <option
                                value="name_asc"
                                {{ request('sort') == 'name_asc'
                                    ? 'selected'
                                    : '' }}>

                                Name A-Z

                            </option>

                            <option
                                value="name_desc"
                                {{ request('sort') == 'name_desc'
                                    ? 'selected'
                                    : '' }}>

                                Name Z-A

                            </option>

                            <option
                                value="price_low"
                                {{ request('sort') == 'price_low'
                                    ? 'selected'
                                    : '' }}>

                                Price Low-High

                            </option>

                            <option
                                value="price_high"
                                {{ request('sort') == 'price_high'
                                    ? 'selected'
                                    : '' }}>

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
                            href="{{ route('admin.products.index') }}"
                            class="btn btn-outline-secondary me-2">

                            <i class="bi bi-arrow-clockwise me-1"></i>

                            Reset

                        </a>


                        <a
                            href="{{ route(
                                'admin.products.export.csv',
                                request()->query()
                            ) }}"
                            class="btn btn-success">

                            <i class="bi bi-download me-1"></i>

                            Export CSV

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- Product Count --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <strong>
                Total Products:
            </strong>

            <span class="text-primary fw-bold">
                {{ $products->total() }}
            </span>

        </div>

    </div>


    {{-- Table --}}
    <div class="data-table">

        <div class="table-responsive">

            <table class="table table-hover mb-0 align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Image</th>

                        <th>Name</th>

                        <th>Price</th>

                        <th>Size</th>

                        <th>Color</th>

                        <th>Status</th>

                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($products as $product)

                    <tr>

                        {{-- ID --}}
                        <td>
                            {{ $product->id }}
                        </td>


                        {{-- Image --}}
                        <td>

                            @if($product->image)

                            @if(
                            str_starts_with(
                            $product->image,
                            'http'
                            )
                            )

                            <img
                                src="{{ $product->image }}"
                                width="60"
                                height="60"
                                style="
                                                object-fit:cover;
                                                border-radius:8px;
                                            ">

                            @else

                            <img
                                src="{{ asset(
                                                'images/' .
                                                $product->image
                                            ) }}"
                                width="60"
                                height="60"
                                style="
                                                object-fit:cover;
                                                border-radius:8px;
                                            ">

                            @endif

                            @else

                            <div
                                class="bg-light rounded d-flex align-items-center justify-content-center"
                                style="
                                            width:60px;
                                            height:60px;
                                        ">

                                <i
                                    class="bi bi-image text-muted">
                                </i>

                            </div>

                            @endif

                        </td>


                        {{-- Name --}}
                        <td>

                            <strong>
                                {{ $product->product_name }}
                            </strong>

                        </td>


                        {{-- Price --}}
                        <td>

                            ${{ number_format(
                                    $product->price,
                                    2
                                ) }}

                        </td>


                        {{-- Size --}}
                        <td>
                            {{ $product->size ?? '-' }}
                        </td>


                        {{-- Color --}}
                        <td>
                            {{ $product->color ?? '-' }}
                        </td>


                        {{-- Status --}}
                        <td>

                            @if($product->status)

                            <span
                                class="badge bg-success">

                                Active

                            </span>

                            @else

                            <span
                                class="badge bg-danger">

                                Inactive

                            </span>

                            @endif

                        </td>


                        {{-- Actions --}}
                        <td>

                            {{-- Toggle --}}
                            <form
                                action="{{ route(
                                        'admin.products.toggle-status',
                                        $product->id
                                    ) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-secondary btn-action"
                                    title="Toggle Status">

                                    <i
                                        class="bi bi-arrow-repeat">
                                    </i>

                                </button>

                            </form>


                            {{-- Edit --}}
                            <a
                                href="{{ route(
                                        'admin.products.edit',
                                        $product->id
                                    ) }}"
                                class="btn btn-sm btn-primary btn-action"
                                title="Edit">

                                <i
                                    class="bi bi-pencil">
                                </i>

                            </a>


                            {{-- Delete --}}
                            <form
                                action="{{ route(
                                        'admin.products.destroy',
                                        $product->id
                                    ) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm(
                                        'Are you sure you want to delete this product?'
                                    )">

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-sm btn-danger btn-action"
                                    title="Delete">

                                    <i
                                        class="bi bi-trash">
                                    </i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center py-5">

                            <i
                                class="bi bi-inbox fs-1 text-muted d-block mb-2">
                            </i>

                            <p
                                class="text-muted mb-2">

                                No products found

                            </p>

                            <a
                                href="{{ route(
                                        'admin.products.index'
                                    ) }}"
                                class="btn btn-sm btn-primary">

                                Clear Filters

                            </a>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Numeric Pagination --}}
        @if($products->hasPages())

        <div class="p-3 border-top">

            <nav>

                <ul
                    class="pagination justify-content-center mb-0">

                    {{-- Previous --}}
                    @if($products->onFirstPage())

                    <li
                        class="page-item disabled">

                        <span
                            class="page-link">

                            &laquo;

                        </span>

                    </li>

                    @else

                    <li
                        class="page-item">

                        <a
                            class="page-link"
                            href="{{
                                        $products->previousPageUrl()
                                    }}">

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
                                {{
                                    $page ==
                                    $products->currentPage()
                                    ? 'active'
                                    : ''
                                }}">

                            <a
                                class="page-link"
                                href="{{
                                        $products->url($page)
                                    }}">

                                {{ $page }}

                            </a>

                        </li>

                        @endfor


                        {{-- Next --}}
                        @if($products->hasMorePages())

                        <li
                            class="page-item">

                            <a
                                class="page-link"
                                href="{{
                                        $products->nextPageUrl()
                                    }}">

                                &raquo;

                            </a>

                        </li>

                        @else

                        <li
                            class="page-item disabled">

                            <span
                                class="page-link">

                                &raquo;

                            </span>

                        </li>

                        @endif

                </ul>

            </nav>

        </div>

        @endif

    </div>

</div>

@endsection