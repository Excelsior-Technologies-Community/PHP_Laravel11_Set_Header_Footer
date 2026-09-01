@extends('admin.layout')

@section('title', 'Add Product')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="form-card">
            <h4 class="mb-4">Add New Product</h4>

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="product_name" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" name="price" class="form-control" required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Size</label>
                        <input type="text" name="size" class="form-control" placeholder="e.g. S, M, L, XL">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Color</label>
                        <input type="text" name="color" class="form-control" placeholder="e.g. Red, Blue, Black">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Enter product description..."></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control" onchange="previewImage(this)" accept="image/*">
                        <img id="previewImg" class="image-preview d-none" style="display: none;">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Submit Product
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
