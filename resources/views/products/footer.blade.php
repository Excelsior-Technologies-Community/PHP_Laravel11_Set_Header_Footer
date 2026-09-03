<footer class="bg-dark text-white mt-5">

    <div class="container py-5">

        <div class="row g-4">

            {{-- About --}}
            <div class="col-lg-4 col-md-6">

                <h5 class="fw-bold">
                    {{ $siteSettings->site_name ?? 'My Shop' }}
                </h5>

                <p class="text-white-50 mb-3">
                    {{ $siteSettings->footer_description ?? 'Your trusted online shopping destination.' }}
                </p>

                @if($siteSettings?->site_address)
                    <div class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        {{ $siteSettings->site_address }}
                    </div>
                @endif

                @if($siteSettings?->site_email)
                    <div class="mb-2">
                        <i class="bi bi-envelope me-2"></i>

                        <a
                            href="mailto:{{ $siteSettings->site_email }}"
                            class="text-white text-decoration-none"
                        >
                            {{ $siteSettings->site_email }}
                        </a>
                    </div>
                @endif

                @if($siteSettings?->site_phone)
                    <div>
                        <i class="bi bi-telephone me-2"></i>

                        <a
                            href="tel:{{ $siteSettings->site_phone }}"
                            class="text-white text-decoration-none"
                        >
                            {{ $siteSettings->site_phone }}
                        </a>
                    </div>
                @endif

            </div>

            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6">

                <h6 class="fw-bold mb-3">
                    Quick Links
                </h6>

                <ul class="list-unstyled">

                    <li class="mb-2">
                        <a
                            href="{{ route('products.index') }}"
                            class="text-white-50 text-decoration-none"
                        >
                            Home
                        </a>
                    </li>

                    <li class="mb-2">
                        <a
                            href="{{ route('products.index') }}"
                            class="text-white-50 text-decoration-none"
                        >
                            Products
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="text-white-50 text-decoration-none"
                        >
                            Admin Panel
                        </a>
                    </li>

                </ul>

            </div>

            {{-- Legal Links --}}
            <div class="col-lg-3 col-md-6">

                <h6 class="fw-bold mb-3">
                    Legal
                </h6>

                <ul class="list-unstyled">

                    @if($siteSettings?->privacy_policy_url)
                        <li class="mb-2">
                            <a
                                href="{{ $siteSettings->privacy_policy_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-white-50 text-decoration-none"
                            >
                                Privacy Policy
                            </a>
                        </li>
                    @endif

                    @if($siteSettings?->terms_url)
                        <li class="mb-2">
                            <a
                                href="{{ $siteSettings->terms_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-white-50 text-decoration-none"
                            >
                                Terms & Conditions
                            </a>
                        </li>
                    @endif

                    @if($siteSettings?->return_policy_url)
                        <li>
                            <a
                                href="{{ $siteSettings->return_policy_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-white-50 text-decoration-none"
                            >
                                Return Policy
                            </a>
                        </li>
                    @endif

                </ul>

            </div>

            {{-- Social Media --}}
            <div class="col-lg-3 col-md-6">

                <h6 class="fw-bold mb-3">
                    Follow Us
                </h6>

                <div class="d-flex gap-2">

                    @if($siteSettings?->facebook_url)
                        <a
                            href="{{ $siteSettings->facebook_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-outline-light btn-sm rounded-circle"
                            aria-label="Facebook"
                        >
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif

                    @if($siteSettings?->instagram_url)
                        <a
                            href="{{ $siteSettings->instagram_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-outline-light btn-sm rounded-circle"
                            aria-label="Instagram"
                        >
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif

                    @if($siteSettings?->twitter_url)
                        <a
                            href="{{ $siteSettings->twitter_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-outline-light btn-sm rounded-circle"
                            aria-label="X / Twitter"
                        >
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    @endif

                    @if($siteSettings?->linkedin_url)
                        <a
                            href="{{ $siteSettings->linkedin_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-outline-light btn-sm rounded-circle"
                            aria-label="LinkedIn"
                        >
                            <i class="bi bi-linkedin"></i>
                        </a>
                    @endif

                    @if($siteSettings?->youtube_url)
                        <a
                            href="{{ $siteSettings->youtube_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn btn-outline-light btn-sm rounded-circle"
                            aria-label="YouTube"
                        >
                            <i class="bi bi-youtube"></i>
                        </a>
                    @endif

                </div>

            </div>

        </div>

        <hr class="border-secondary my-4">

        <div class="text-center text-white-50">

            @if($siteSettings?->copyright_text)
                {{ $siteSettings->copyright_text }}
            @else
                © {{ date('Y') }}
                {{ $siteSettings->site_name ?? 'My Shop' }}.
                All Rights Reserved.
            @endif

        </div>

    </div>

</footer>