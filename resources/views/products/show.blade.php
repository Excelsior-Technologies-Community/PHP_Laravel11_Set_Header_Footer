@extends('products.layout')

@section('seo_title')
    {{ $product->seo_meta_title ?: $product->product_name . ' | ' . ($siteSettings->site_name ?? 'My Shop') }}
@endsection

@section('seo_description')
    {{ $product->seo_meta_description ?: \Illuminate\Support\Str::limit(strip_tags($product->description), 160) }}
@endsection

@if($product->seo_meta_key)
    @section('seo_keywords')
        {{ $product->seo_meta_key }}
    @endsection
@endif

@if($product->seo_canonical)
    @section('canonical_url')
        {{ $product->seo_canonical }}
    @endsection
@endif

@section('og_title')
    {{ $product->og_meta_title ?: $product->product_name }}
@endsection

@section('og_description')
    {{ $product->og_meta_description ?: \Illuminate\Support\Str::limit(strip_tags($product->description), 160) }}
@endsection

@section('og_image')
    @if($product->og_meta_image)
        {{ asset('images/' . $product->og_meta_image) }}
    @elseif($product->seo_meta_image)
        {{ asset('images/' . $product->seo_meta_image) }}
    @elseif($product->image)
        {{ asset('images/' . $product->image) }}
    @endif
@endsection

@section('content')

<div class="container py-5">

    <div class="row g-5">

        {{-- Product Image --}}
        <div class="col-md-6">

            @if($product->image)

                <img
                    src="{{ asset('images/' . $product->image) }}"
                    class="img-fluid rounded shadow-sm"
                    alt="{{ $product->product_name }}"
                >

            @else

                <div class="bg-light rounded p-5 text-center">
                    <i class="bi bi-image fs-1 text-muted"></i>
                    <p class="text-muted mb-0">
                        No Image Available
                    </p>
                </div>

            @endif

        </div>

        {{-- Product Information --}}
        <div class="col-md-6">

            <h1 class="fw-bold mb-3">
                {{ $product->product_name }}
            </h1>

            <h3 class="text-primary mb-4">
                ${{ number_format($product->price, 2) }}
            </h3>

            @if($product->size)
                <div class="mb-3">
                    <strong>Size:</strong>

                    <span class="badge bg-secondary">
                        {{ $product->size }}
                    </span>
                </div>
            @endif

            @if($product->color)
                <div class="mb-3">
                    <strong>Color:</strong>

                    <span class="badge bg-info text-dark">
                        {{ $product->color }}
                    </span>
                </div>
            @endif

            @if($product->description)
                <div class="mt-4">

                    <h5>Description</h5>

                    <p class="text-muted">
                        {{ $product->description }}
                    </p>

                </div>
            @endif

            @if($product->status)
                <span class="badge bg-success">
                    Available
                </span>
            @else
                <span class="badge bg-danger">
                    Unavailable
                </span>
            @endif

            <div class="mt-4">

                <a
                    href="{{ route('products.index') }}"
                    class="btn btn-outline-primary"
                >
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Products
                </a>

            </div>

        </div>

    </div>

</div>

@endsection