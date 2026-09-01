@extends('products.layout')

@section('content')

<div class="container mt-4">
    <h2>Edit Product</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>Product Name</label>
                <input type="text" name="product_name" class="form-control" value="{{ $product->product_name }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Size</label>
                <input type="text" name="size" class="form-control" value="{{ $product->size }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Color</label>
                <input type="text" name="color" class="form-control" value="{{ $product->color }}">
            </div>

            <div class="col-md-12 mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>Current Image</label><br>
                @if($product->image)
                    <img src="{{ asset('images/' . $product->image) }}" width="100" class="mb-2">
                @else
                    <span>No Image</span>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label>Change Image</label>
                <input type="file" name="image" class="form-control" onchange="previewImage(this)">
                <img id="previewImg" style="width:150px; height:auto; display:none; border:1px solid #ddd; padding:5px; border-radius:5px; margin-top:10px;">
            </div>

            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

        </div>

        <button class="btn btn-success mt-3">Update</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back</a>

    </form>
</div>

<script>
function previewImage(input) {
    let file = input.files[0];
    if (file) {
        let reader = new FileReader();
        reader.onload = function(e) {
            let preview = document.getElementById('previewImg');
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>

@endsection
