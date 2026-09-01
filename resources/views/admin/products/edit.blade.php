@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="form-card">
            <h4 class="mb-4">Edit Product</h4>

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Size</label>
                        <input type="text" name="size" class="form-control" value="{{ $product->size }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" name="color" class="form-control" value="{{ $product->color }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Current Image</label>
                        @if($product->image)
                            @if(str_starts_with($product->image, 'http'))
                                <img src="{{ $product->image }}" class="image-preview" style="display: block; max-width: 200px;">
                            @else
                                <img src="{{ asset('images/' . $product->image) }}" class="image-preview" style="display: block; max-width: 200px;">
                            @endif
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 150px; height: 150px;">
                                <i class="bi bi-image text-muted fs-2"></i>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Change Image</label>
                        <input type="file" name="image" class="form-control" onchange="previewImage(this)" accept="image/*">
                        <img id="previewImg" class="image-preview d-none" style="display: none;">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    let file = input.files[0];
    let preview = document.getElementById('previewImg');

    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        preview.classList.add('d-none');
    }
}
</script>
@endsection
