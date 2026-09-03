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

                    {{-- SEO Settings --}}
                    <div class="col-12">
                        <hr class="my-4">

                        <h5 class="mb-3">
                            <i class="bi bi-search me-1"></i>
                            SEO Settings
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">SEO Meta Title</label>
                        <input
                            type="text"
                            name="seo_meta_title"
                            class="form-control"
                            value="{{ old('seo_meta_title', $product->seo_meta_title) }}"
                            maxlength="255"
                            placeholder="Enter SEO meta title">
                        @error('seo_meta_title')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">SEO Keywords</label>
                        <input
                            type="text"
                            name="seo_meta_key"
                            class="form-control"
                            value="{{ old('seo_meta_key', $product->seo_meta_key) }}"
                            placeholder="running shoes, sports shoes, shoes">
                        @error('seo_meta_key')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">SEO Meta Description</label>
                        <textarea
                            name="seo_meta_description"
                            class="form-control"
                            rows="3"
                            maxlength="500"
                            placeholder="Enter SEO meta description...">{{ old('seo_meta_description', $product->seo_meta_description) }}</textarea>
                        @error('seo_meta_description')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Canonical URL</label>
                        <input
                            type="url"
                            name="seo_canonical"
                            class="form-control"
                            value="{{ old('seo_canonical', $product->seo_canonical) }}"
                            placeholder="https://example.com/products/product-name">
                        @error('seo_canonical')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">SEO Image</label>
                        <input
                            type="file"
                            name="seo_meta_image"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp">

                        @if($product->seo_meta_image)
                        <div class="mt-2">
                            <img
                                src="{{ asset('images/' . $product->seo_meta_image) }}"
                                width="100"
                                class="rounded border"
                                alt="SEO Image">
                        </div>
                        @endif

                        @error('seo_meta_image')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Open Graph Settings --}}
                    <div class="col-12">
                        <hr class="my-4">

                        <h5 class="mb-3">
                            <i class="bi bi-share me-1"></i>
                            Open Graph Settings
                        </h5>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">OG Title</label>
                        <input
                            type="text"
                            name="og_meta_title"
                            class="form-control"
                            value="{{ old('og_meta_title', $product->og_meta_title) }}"
                            maxlength="255"
                            placeholder="Enter Open Graph title">
                        @error('og_meta_title')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">OG Keywords</label>
                        <input
                            type="text"
                            name="og_meta_key"
                            class="form-control"
                            value="{{ old('og_meta_key', $product->og_meta_key) }}"
                            placeholder="running shoes, sports shoes">
                        @error('og_meta_key')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">OG Description</label>
                        <textarea
                            name="og_meta_description"
                            class="form-control"
                            rows="3"
                            maxlength="500"
                            placeholder="Enter Open Graph description...">{{ old('og_meta_description', $product->og_meta_description) }}</textarea>
                        @error('og_meta_description')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">OG Image</label>
                        <input
                            type="file"
                            name="og_meta_image"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp">

                        @if($product->og_meta_image)
                        <div class="mt-2">
                            <img
                                src="{{ asset('images/' . $product->og_meta_image) }}"
                                width="100"
                                class="rounded border"
                                alt="OG Image">
                        </div>
                        @endif

                        @error('og_meta_image')
                        <div class="text-danger small">{{ $message }}</div>
                        @enderror
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