@extends('products.layout')

@section('title', 'Products')

@section('content')

<div class="container mt-4">

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Page Title --}}
    <div class="mb-4">
        <h2>Our Products</h2>
        <p class="text-muted">Explore our collection of products</p>
    </div>

    {{-- Products Card Grid --}}
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-md-4 col-sm-6">
            <div class="card h-100 shadow-sm border-0 product-card">

                {{-- Product Image --}}
                @if($product->image)
                @if(str_starts_with($product->image, 'http'))
                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 220px; object-fit: cover;">
                @else
                <img src="{{ asset('images/' . $product->image) }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 220px; object-fit: cover;">
                @endif
                @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                    <i class="bi bi-image text-muted fs-1"></i>
                </div>
                @endif

                <div class="card-body">
                    {{-- Product Name --}}
                    <h5 class="card-title fw-bold">{{ $product->product_name }}</h5>

                    {{-- Price --}}
                    <h6 class="text-primary fw-bold mb-2">${{ number_format($product->price, 2) }}</h6>

                    {{-- Size & Color --}}
                    <p class="card-text text-muted small mb-2">
                        @if($product->size)
                        <span class="badge bg-light text-dark border me-1">{{ $product->size }}</span>
                        @endif
                        @if($product->color)
                        <span class="badge bg-light text-dark border">{{ $product->color }}</span>
                        @endif
                    </p>

                    {{-- Description --}}
                    <p class="card-text text-muted small">
                        {{ \Illuminate\Support\Str::limit($product->description, 80) }}
                    </p>

                    {{-- Status Badge --}}
                    <div>
                        @if($product->status)
                        <span class="badge bg-success">Active</span>
                        @else
                        <span class="badge bg-danger">Inactive</span>
                        @endif
                    </div>

                    {{-- View Product --}}
                    <div class="mt-3">
                        <a
                            href="{{ route('products.show', $product->id) }}"
                            class="btn btn-primary w-100">
                            <i class="bi bi-eye me-1"></i>
                            View Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        {{-- No Products Found --}}
        <div class="col-12 text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted d-block mb-3"></i>
            <p class="text-muted fs-5">No products found</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="mt-4">
        {{ $products->links() }}
    </div>
    @endif

</div>

<style>
    .product-card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .card-img-top {
        border-radius: 8px 8px 0 0;
    }
</style>

@endsection