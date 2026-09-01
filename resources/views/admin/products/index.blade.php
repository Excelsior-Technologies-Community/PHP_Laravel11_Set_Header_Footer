@extends('admin.layout')

@section('title', 'Manage Products')

@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Products</h2>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Product
        </a>
    </div>
</div>

<div class="data-table">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
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
                        <td>{{ $product->id }}</td>
                        <td>
                            @if($product->image)
                                @if(str_starts_with($product->image, 'http'))
                                    <img src="{{ $product->image }}" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <img src="{{ asset('images/' . $product->image) }}" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                                @endif
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $product->product_name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->size ?? '-' }}</td>
                        <td>{{ $product->color ?? '-' }}</td>
                        <td>
                            @if($product->status)
                                <span class="badge bg-success badge-custom">Active</span>
                            @else
                                <span class="badge bg-danger badge-custom">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary btn-action" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger btn-action" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                            <p class="text-muted mb-0">No products found</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
        <div class="p-3 border-top">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
