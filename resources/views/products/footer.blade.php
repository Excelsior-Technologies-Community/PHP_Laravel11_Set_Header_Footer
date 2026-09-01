<footer>
    <div class="container">
        <div class="row g-4">

            {{-- Quick Links --}}
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('products.index') }}">Products</a></li>
                    <li><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
                </ul>
            </div>

            {{-- Legal Links --}}
            <div class="col-md-3">
                <h5>Legal</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Return Policy</a></li>
                </ul>
            </div>

            {{-- Dynamic Contact Info --}}
            <div class="col-md-5">
                <h5>Get In Touch</h5>
                <div class="contact-box">
                    <div class="contact-item">
                        <i class="bi bi-geo-alt text-danger"></i>
                        <span>{{ $siteSettings->site_address ?? 'ZionZ1, Bodak Dev, Sindhu Bhawan Road, Ahmedabad' }}</span>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-envelope text-primary"></i>
                        <span>{{ $siteSettings->site_email ?? 'excelsiortechnology1102@gmail.com' }}</span>
                    </div>
                    <div class="contact-item">
                        <i class="bi bi-telephone text-success"></i>
                        <span>{{ $siteSettings->site_phone ?? '7069688473' }}</span>
                    </div>

                    {{-- Social Media --}}
                    <div class="social-icons mt-3">
                        <a href="#" aria-label="Google"><i class="bi bi-google"></i></a>
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>

        </div>

        <hr class="my-4" style="border-color: #2d3139;">

        <div class="text-center">
            <p class="mb-0">
                &copy; {{ date('Y') }} <strong>{{ $siteSettings->site_name ?? 'My Shop' }}</strong>. All Rights Reserved.
            </p>
        </div>
    </div>
</footer>
