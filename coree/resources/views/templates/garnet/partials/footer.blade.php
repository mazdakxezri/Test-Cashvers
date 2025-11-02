<footer class="{{ request()->routeIs('home') ? 'footer-modern' : 'footer-sticky' }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <a href="{{ auth()->check() ? route('earnings.index') : route('home') }}" class="footer-brand">
                    @include($activeTemplate . '.partials.logo')
                </a>
                <p class="footer-description">
                    Turn your spare time into real rewards. Complete tasks, play games, and earn money instantly.
                </p>
            </div>
            
            <div class="col-lg-2 col-6 mb-4 mb-lg-0">
                <h6 style="color: #1A1A1A; font-weight: 600; margin-bottom: 20px;">Quick Links</h6>
                <div class="footer-links">
                    <a href="#how-it-works">How It Works</a>
                    <a href="#cashout">Cashout</a>
                    <a href="#faq">FAQ</a>
                </div>
            </div>
            
            <div class="col-lg-2 col-6 mb-4 mb-lg-0">
                <h6 style="color: #1A1A1A; font-weight: 600; margin-bottom: 20px;">Legal</h6>
                <div class="footer-links">
                    <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                    <a href="{{ route('terms.of.use') }}">Terms of Service</a>
                    <a href="/academy">Academy</a>
                </div>
            </div>
            
            <div class="col-lg-4">
                <h6 style="color: #1A1A1A; font-weight: 600; margin-bottom: 20px;">Connect With Us</h6>
                <div class="d-flex gap-2">
                    @php
                        $socialLinks = json_decode(socialMediaLink(), true) ?? [];
                    @endphp
                    @foreach ($socialLinks as $social)
                        <a href="{{ $social['url'] ?? '#' }}" class="social-link" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset($social['icon']) }}" alt="{{ ucfirst($social['name']) }}" width="20" height="20" />
                        </a>
                    @endforeach
                </div>
                <div style="margin-top: 20px;">
                    <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#contactModal" 
                       style="color: #E9213D; text-decoration: none; font-weight: 600; font-size: 14px;">
                        Contact Support →
                    </a>
                </div>
            </div>
        </div>
        
        <div class="copyright text-center">
            © {{ date('Y') }} {{ SiteName() }}. All rights reserved.
        </div>
    </div>
</footer>
