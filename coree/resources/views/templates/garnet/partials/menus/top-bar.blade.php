<nav class="{{ request()->routeIs('home') ? 'nav-modern' : 'top-nav' }} navbar navbar-expand-lg {{ request()->routeIs('home') ? 'py-3' : 'py-lg-0' }}">
    <div class="{{ request()->routeIs('home') ? 'container' : 'container-fluid' }}">
        <a class="navbar-brand" href="{{ route('earnings.index') }}">
            @include($activeTemplate . '.partials.logo')
        </a>
        
        @auth
            <div class="ms-auto d-flex align-items-center gap-3">
                <div class="d-flex align-items-center gap-2 balance">
                    <div class="icon-balance">
                        {{ siteSymbol() }}
                    </div>
                    <span>{{ Auth::user()->balance }}</span>
                </div>

                <div class="d-flex align-items-center gap-2 balance">
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/level.svg') }}" alt="level" class="img-fluid">
                    <span class="fw-semibold">Lv.{{ Auth::user()->level }}</span>
                </div>
                
                <a class="d-flex align-items-center avatar-dt text-white gap-1" href="{{ route('profile.show') }}">
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/avatars/1.png') }}" class="profile-avatar" alt="User Avatar">
                    <span class="d-none d-md-block">{{ Auth::user()->name }}</span>
                </a>
            </div>
        @else
            @if (request()->routeIs('home'))
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link-modern" data-bs-toggle="modal" data-bs-target="#authModal" onclick="selectCreateAccountTab()">Get Started</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="#cashout">Cashout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="#how-it-works">How It Works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="#who-we-are">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-modern" href="#faq">FAQ</a>
                        </li>
                    </ul>
                    
                    <div class="d-flex align-items-center">
                        <a href="javascript:void(0)" class="nav-btn-modern nav-btn-signin" data-bs-toggle="modal" data-bs-target="#authModal">
                            Sign In
                        </a>
                        <a href="javascript:void(0)" class="nav-btn-modern nav-btn-signup" data-bs-toggle="modal" data-bs-target="#authModal" onclick="selectCreateAccountTab()">
                            Sign Up
                        </a>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</nav>
