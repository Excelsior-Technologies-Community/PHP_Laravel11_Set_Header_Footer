@extends('admin.layout')

@section('title', 'Site Settings')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Site Settings</h2>
            <p class="text-muted mb-0">
                Manage website, footer, legal and social media settings.
            </p>
        </div>
    </div>

    <form
        action="{{ route('admin.settings.update') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        {{-- Basic Settings --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-gear me-2"></i>
                    Basic Website Settings
                </h5>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Site Name
                        </label>

                        <input
                            type="text"
                            name="site_name"
                            class="form-control"
                            value="{{ old('site_name', $settings->site_name ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Site Email
                        </label>

                        <input
                            type="email"
                            name="site_email"
                            class="form-control"
                            value="{{ old('site_email', $settings->site_email ?? '') }}"
                            required
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Site Phone
                        </label>

                        <input
                            type="text"
                            name="site_phone"
                            class="form-control"
                            value="{{ old('site_phone', $settings->site_phone ?? '') }}"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Site Address
                        </label>

                        <textarea
                            name="site_address"
                            class="form-control"
                            rows="2"
                        >{{ old('site_address', $settings->site_address ?? '') }}</textarea>
                    </div>

                </div>

            </div>
        </div>

        {{-- Logo --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-image me-2"></i>
                    Branding
                </h5>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Site Logo
                        </label>

                        <input
                            type="file"
                            name="site_logo"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp"
                        >

                        @if($settings?->site_logo)
                            <div class="mt-3">
                                <img
                                    src="{{ asset('images/' . $settings->site_logo) }}"
                                    height="60"
                                    class="border rounded p-1"
                                    alt="Site Logo"
                                >
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Site Favicon
                        </label>

                        <input
                            type="file"
                            name="site_favicon"
                            class="form-control"
                            accept=".ico,.jpg,.jpeg,.png,.webp"
                        >

                        @if($settings?->site_favicon)
                            <div class="mt-3">
                                <img
                                    src="{{ asset('images/' . $settings->site_favicon) }}"
                                    width="50"
                                    height="50"
                                    class="border rounded p-1"
                                    alt="Favicon"
                                >
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-layout-text-window-reverse me-2"></i>
                    Footer Content
                </h5>
            </div>

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">
                        Footer Description
                    </label>

                    <textarea
                        name="footer_description"
                        class="form-control"
                        rows="3"
                        maxlength="1000"
                        placeholder="Enter your footer description..."
                    >{{ old('footer_description', $settings->footer_description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Copyright Text
                    </label>

                    <input
                        type="text"
                        name="copyright_text"
                        class="form-control"
                        placeholder="All Rights Reserved"
                        value="{{ old('copyright_text', $settings->copyright_text ?? '') }}"
                    >
                </div>

            </div>
        </div>

        {{-- Legal Links --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Legal Links
                </h5>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Privacy Policy URL
                        </label>

                        <input
                            type="url"
                            name="privacy_policy_url"
                            class="form-control"
                            placeholder="https://example.com/privacy-policy"
                            value="{{ old('privacy_policy_url', $settings->privacy_policy_url ?? '') }}"
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Terms & Conditions URL
                        </label>

                        <input
                            type="url"
                            name="terms_url"
                            class="form-control"
                            placeholder="https://example.com/terms"
                            value="{{ old('terms_url', $settings->terms_url ?? '') }}"
                        >
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            Return Policy URL
                        </label>

                        <input
                            type="url"
                            name="return_policy_url"
                            class="form-control"
                            placeholder="https://example.com/returns"
                            value="{{ old('return_policy_url', $settings->return_policy_url ?? '') }}"
                        >
                    </div>

                </div>

            </div>
        </div>

        {{-- Social Media --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-share me-2"></i>
                    Social Media Links
                </h5>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="bi bi-facebook me-1"></i>
                            Facebook URL
                        </label>

                        <input
                            type="url"
                            name="facebook_url"
                            class="form-control"
                            placeholder="https://facebook.com/..."
                            value="{{ old('facebook_url', $settings->facebook_url ?? '') }}"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="bi bi-instagram me-1"></i>
                            Instagram URL
                        </label>

                        <input
                            type="url"
                            name="instagram_url"
                            class="form-control"
                            placeholder="https://instagram.com/..."
                            value="{{ old('instagram_url', $settings->instagram_url ?? '') }}"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="bi bi-twitter-x me-1"></i>
                            X / Twitter URL
                        </label>

                        <input
                            type="url"
                            name="twitter_url"
                            class="form-control"
                            placeholder="https://x.com/..."
                            value="{{ old('twitter_url', $settings->twitter_url ?? '') }}"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="bi bi-linkedin me-1"></i>
                            LinkedIn URL
                        </label>

                        <input
                            type="url"
                            name="linkedin_url"
                            class="form-control"
                            placeholder="https://linkedin.com/..."
                            value="{{ old('linkedin_url', $settings->linkedin_url ?? '') }}"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="bi bi-youtube me-1"></i>
                            YouTube URL
                        </label>

                        <input
                            type="url"
                            name="youtube_url"
                            class="form-control"
                            placeholder="https://youtube.com/..."
                            value="{{ old('youtube_url', $settings->youtube_url ?? '') }}"
                        >
                    </div>

                </div>

            </div>
        </div>

        {{-- Website SEO --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-search me-2"></i>
                    Website SEO
                </h5>
            </div>

            <div class="card-body">

                <label class="form-label">
                    Site Meta Description
                </label>

                <textarea
                    name="site_meta_description"
                    class="form-control"
                    rows="3"
                    maxlength="500"
                    placeholder="Enter website meta description..."
                >{{ old('site_meta_description', $settings->site_meta_description ?? '') }}</textarea>

            </div>
        </div>

        <div class="text-end mb-5">

            <button
                type="submit"
                class="btn btn-primary px-4"
            >
                <i class="bi bi-save me-1"></i>
                Save Settings
            </button>

        </div>

    </form>

</div>

@endsection