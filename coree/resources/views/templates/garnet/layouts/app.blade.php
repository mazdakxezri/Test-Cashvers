<!DOCTYPE html>
<html lang="en">

<head>
    @include($activeTemplate . '.partials.header')
    @yield('styles')
</head>

<body style="padding-bottom: 0 !important; margin-bottom: 0 !important;">
    <div class="preloader">
        <div class="scanner-container">
            <div class="brand-scanner">{{ strtoupper(siteName()) }}</div>
            <div class="loading-universe">Loading Universe</div>
        </div>
    </div>

    @unless (request()->routeIs('password.reset'))
        @include($activeTemplate . '.partials.menus.top-bar-space')
        
        @if(request()->routeIs('home'))
            <!-- Landing Page Layout (No Wrapper) -->
            @yield('content')
            @include($activeTemplate . '.partials.footer-space')
        @else
            <!-- Dashboard Layout (With Sidebar & Wrapper) -->
            @include($activeTemplate . '.partials.menus.sidebar-space')
            <div class="wrapper">
                <main class="content">
                    @auth
                        @if (!Auth::user()->hasVerifiedEmail())
                            <div style="background: linear-gradient(135deg, rgba(255, 152, 0, 0.15) 0%, rgba(255, 193, 7, 0.1) 100%); border: 1px solid rgba(255, 152, 0, 0.3); border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; position: relative; z-index: 1000;">
                                <div style="display: flex; align-items: center; gap: 16px;">
                                    <div style="width: 48px; height: 48px; background: rgba(255, 152, 0, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFA726" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                        </svg>
                                    </div>
                                    <div style="flex: 1;">
                                        <h5 style="color: #FFA726; font-size: 16px; font-weight: 700; margin: 0 0 8px 0; font-family: 'Inter', sans-serif;">📧 Email Verification Required</h5>
                                        <p style="color: rgba(255, 255, 255, 0.9); margin: 0; font-size: 14px; line-height: 1.6; font-family: 'Inter', sans-serif;">
                                            Please check and confirm your email address to unlock all features. 
                                            <form action="{{ route('auth.verification.resend') }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" style="background: none; border: none; color: #00B8D4; text-decoration: underline; cursor: pointer; font-weight: 600; padding: 0; font-family: 'Inter', sans-serif;">
                                                    Resend verification email
                                                </button>
                                            </form>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth

                    @if (session('success') || session('error'))
                        @include($activeTemplate . '.partials.alerts.alerts')
                    @endif

                    @yield('content')
                </main>
                @include($activeTemplate . '.partials.footer-space')
            </div>
        @endif
    @else
        <div class="landing-page">
            @include($activeTemplate . '.partials.menus.top-bar-space')
            @yield('landing-content')
            @include($activeTemplate . '.partials.footer-space')
        </div>
    @endunless
    <!-- Bottom Menu for Mobile -->
    @include($activeTemplate . '.partials.menus.mobile-bar')

    <!-- Cookie Bar -->
    <div class="cookie-bar">
        <div class="cookie-container">
            <div class="d-flex align-items-center">
                <img src="{{ asset('assets/' . $activeTemplate . '/images/cookie.png') }}" alt="Cookie"
                    class="me-2" />
                <span class="text-white fw-semibold">We use cookies!</span>
            </div>
            <div class="cookie-content my-3">
                <p class="text-white fw-medium">
                    This site uses cookies to enhance your browsing experience and analyze site traffic. By continuing
                    to use this site, you agree to our use of cookies as outlined in our
                    <a href="{{ route('privacy.policy') }}" class="text-decoration-underline text-white">Privacy
                        Policy</a>.
                </p>
            </div>
            <div class="row flex-column flex-md-row">
                <div class="col mb-3 mb-md-0">
                    <button class="cookie-btn accept" id="acceptCookies">Accept all</button>
                </div>
                <div class="col mb-3 mb-md-0">
                    <button class="cookie-btn reject" id="rejectCookies">Reject all</button>
                </div>
            </div>
        </div>
    </div>

    @guest
        <!-- Modal Auth -->
        @include($activeTemplate . '.partials.modals.auth')
        @include($activeTemplate . '.partials.modals.forgot')
    @endguest
    @include($activeTemplate . '.partials.modals.contact')

    <!-- JavaScript files -->
        <script src="{{ asset('assets/' . $activeTemplate . '/js/preloader.js') }}?v={{ config('app.version') }}"></script>
        <script src="{{ asset('assets/' . $activeTemplate . '/js/device-tracker.js') }}?v={{ config('app.version') }}"></script>
        <script src="{{ asset('assets/' . $activeTemplate . '/js/bootstrap.bundle.min.js') }}?v={{ config('app.version') }}">
        </script>
        <script src="{{ asset('assets/' . $activeTemplate . '/js/custom.min.js') }}?v={{ config('app.version') }}"></script>
    <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/6821653dca3aee190c0f931f/1ir176uvm';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
    <!--End of Tawk.to Script-->

    @guest
        <script>
            function selectCreateAccountTab() {
                document.getElementById("login-tab").classList.remove("active");
                document.getElementById("login").classList.remove("show", "active");

                document.getElementById("create-account-tab").classList.add("active");
                document.getElementById("create-account").classList.add("show", "active");
            }

            document.getElementById("authModal").addEventListener("hide.bs.modal", function() {
                document.getElementById("login-tab").classList.add("active");
                document.getElementById("login").classList.add("show", "active");

                document.getElementById("create-account-tab").classList.remove("active");
                document.getElementById("create-account").classList.remove("show", "active");
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Check if the login modal should be opened
                @if (session('openLoginModal'))
                    var loginModal = new bootstrap.Modal(document.getElementById('authModal'));
                    loginModal.show();
                @endif

                // Check if the registration modal should be opened
                @if (session('openRegisterModal'))
                    var registerModal = new bootstrap.Modal(document.getElementById('authModal'));
                    registerModal.show();

                    selectCreateAccountTab();
                @endif

                // Check if the forgot password modal should be opened
                @if (session('openForgotModal'))
                    var forgotModal = new bootstrap.Modal(document.getElementById('forgotModal'));
                    forgotModal.show();
                @endif

                @if (session('openContactModal'))
                    var contactModal = new bootstrap.Modal(document.getElementById('contactModal'));
                    contactModal.show();
                @endif
            });



            document.addEventListener("DOMContentLoaded", function() {
                const token = "{{ isset($token) ? $token : '' }}";
                if (token) {
                    includeResetModal();
                }
            });

            function includeResetModal() {
                const modalContainer = document.createElement('div');
                modalContainer.innerHTML = `@include($activeTemplate . '.partials.modals.reset')`;
                document.body.appendChild(modalContainer);

                const modal = modalContainer.firstChild; // Assuming the first child is the modal
                modal.style.display = 'block';
                modal.classList.add('show');

                // Close modal when clicking outside of it
                window.onclick = function(event) {
                    if (event.target === modal) {
                        closeModal(modal);
                    }
                };
            }

            function closeModal(modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                modal.remove();
            }
        </script>
    @endguest

    @if (isCaptchaEnabled())
        {!! NoCaptcha::renderJs() !!}
    @endif

    @if (googleAnalyticsKey())
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ googleAnalyticsKey() }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ googleAnalyticsKey() }}');
        </script>
    @endif

    @yield('scripts')
</body>

</html>
