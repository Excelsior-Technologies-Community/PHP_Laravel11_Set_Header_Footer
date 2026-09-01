@extends('admin.layout')

@section('title', 'Site Settings')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="form-card">
            <h4 class="mb-4">Site Settings</h4>
            <p class="text-muted mb-4">Manage your website's dynamic content here. Changes will be reflected on the frontend immediately.</p>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <h6 class="fw-bold mb-3 text-primary">General Information</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site Name <span class="text-danger">*</span></label>
                        <input type="text" name="site_name" class="form-control" value="{{ $settings->site_name ?? 'My Shop' }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site Email <span class="text-danger">*</span></label>
                        <input type="email" name="site_email" class="form-control" value="{{ $settings->site_email ?? '' }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site Phone</label>
                        <input type="text" name="site_phone" class="form-control" value="{{ $settings->site_phone ?? '' }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site Address</label>
                        <textarea name="site_address" class="form-control" rows="3">{{ $settings->site_address ?? '' }}</textarea>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold mb-3 text-primary">Branding</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site Logo</label>
                        @if($settings && $settings->site_logo)
                            <img src="{{ asset('images/' . $settings->site_logo) }}" class="image-preview mb-2" style="display: block; max-width: 200px;">
                            <input type="file" name="site_logo" class="form-control" accept="image/*">
                            <small class="text-muted">Upload new logo to replace existing</small>
                        @else
                            <div class="border rounded p-4 text-center bg-light mb-2" style="border-style: dashed !important;">
                                <i class="bi bi-image text-muted fs-2 d-block mb-2"></i>
                                <small class="text-muted">No logo uploaded</small>
                            </div>
                            <input type="file" name="site_logo" class="form-control" accept="image/*">
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Site Favicon</label>
                        @if($settings && $settings->site_favicon)
                            <img src="{{ asset('images/' . $settings->site_favicon) }}" class="image-preview mb-2" style="display: block; max-width: 100px;">
                            <input type="file" name="site_favicon" class="form-control" accept="image/*">
                            <small class="text-muted">Upload new favicon to replace existing</small>
                        @else
                            <div class="border rounded p-4 text-center bg-light mb-2" style="border-style: dashed !important;">
                                <i class="bi bi-browser-chrome text-muted fs-2 d-block mb-2"></i>
                                <small class="text-muted">No favicon uploaded</small>
                            </div>
                            <input type="file" name="site_favicon" class="form-control" accept="image/*">
                        @endif
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i> Update Settings
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
