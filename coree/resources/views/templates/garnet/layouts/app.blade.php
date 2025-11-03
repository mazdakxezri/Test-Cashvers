<!DOCTYPE html>
<html lang="en">

<head>
    @include($activeTemplate . '.partials.header')
    @yield('styles')
</head>

<body>
    <div class="preloader">
        <!-- Cyber grid background -->
        <div class="cyber-grid"></div>
        
        <!-- Pulse rings -->
        <div class="pulse-ring"></div>
        <div class="pulse-ring"></div>
        <div class="pulse-ring"></div>
        
        <!-- Data streams (falling lines) -->
        <div class="data-stream"></div>
        <div class="data-stream"></div>
        <div class="data-stream"></div>
        <div class="data-stream"></div>
        <div class="data-stream"></div>
        
        <!-- HUD corner brackets -->
        <div class="hud-corner top-left"></div>
        <div class="hud-corner top-right"></div>
        <div class="hud-corner bottom-left"></div>
        <div class="hud-corner bottom-right"></div>
        
        <!-- Glitch artifacts -->
        <div class="glitch-artifact"></div>
        <div class="glitch-artifact"></div>
        <div class="glitch-artifact"></div>
        
        <!-- Hexagon particles -->
        <div class="hex-particle"></div>
        <div class="hex-particle"></div>
        <div class="hex-particle"></div>
        
        <!-- Pixel corruption effects -->
        <div class="pixel-corruption"></div>
        <div class="pixel-corruption"></div>
        <div class="pixel-corruption"></div>
        
        <!-- Static noise overlay -->
        <div class="static-overlay"></div>
        
        <!-- Vignette -->
        <div class="vignette"></div>
        
        <!-- Main scanner content -->
        <div class="scanner-container">
            <div style="position: relative;">
                <div class="brand-scanner">{{ siteName() }}</div>
                <div class="scanline"></div>
            </div>
            
            <div class="loading-universe">loading universe</div>
        </div>
        
        <!-- Progress bar at bottom -->
        <div class="scan-progress"></div>
    </div>

    @unless (request()->routeIs('home', 'password.reset'))
        @include($activeTemplate . '.partials.menus.top-bar')
        <!-- Side Navigation for Desktop -->
        @include($activeTemplate . '.partials.menus.sidebar')
        <!-- Main Content -->
        <div class="wrapper">
            <main class="content">
                @auth
                    @if (!Auth::user()->hasVerifiedEmail() && (session('success') || session('error')))
                        @include($activeTemplate . '.partials.alerts.alerts')
                    @elseif (!Auth::user()->hasVerifiedEmail())
                        <div class="alert-box alert-warning mb-0 rounded-0">
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.16667 1.66667C5.02453 1.66667 1.66667 5.02453 1.66667 9.16667C1.66667 13.3088 5.02453 16.6667 9.16667 16.6667C13.3088 16.6667 16.6667 13.3088 16.6667 9.16667C16.6667 5.02453 13.3088 1.66667 9.16667 1.66667ZM0 9.16667C0 4.10406 4.10406 0 9.16667 0C14.2293 0 18.3333 4.10406 18.3333 9.16667C18.3333 14.2293 14.2293 18.3333 9.16667 18.3333C4.10406 18.3333 0 14.2293 0 9.16667Z"
                                    fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.16732 8.33301C9.62755 8.33301 10.0007 8.7061 10.0007 9.16634V12.4997C10.0007 12.9599 9.62755 13.333 9.16732 13.333C8.70708 13.333 8.33398 12.9599 8.33398 12.4997V9.16634C8.33398 8.7061 8.70708 8.33301 9.16732 8.33301Z"
                                    fill="white" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.33398 5.83333C8.33398 5.3731 8.70708 5 9.16732 5H9.17565C9.63589 5 10.009 5.3731 10.009 5.83333C10.009 6.29357 9.63589 6.66667 9.17565 6.66667H9.16732C8.70708 6.66667 8.33398 6.29357 8.33398 5.83333Z"
                                    fill="white" />
                            </svg>

                            Please check and confirm your email address. If you need another confirmation email,
                            <form action="{{ route('auth.verification.resend') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="text-decoration-underline p-0 border-0 bg-transparent">click here
                                    to resend</button>
                            </form>.
                        </div>
                    @endif
                @endauth

                @if (session('success') || session('error'))
                    @include($activeTemplate . '.partials.alerts.alerts')
                @endif


                @yield('content')
            </main>
            @include($activeTemplate . '.partials.footer')
        </div>
    @else
        <div class="landing-page">
            @include($activeTemplate . '.partials.menus.top-bar')
            @yield('landing-content')
            @include($activeTemplate . '.partials.footer')
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
