<nav class="top-nav navbar navbar-expand-lg py-lg-0">
    <div class="{{ request()->routeIs('home') ? 'container' : 'container-fluid' }}">
        <div class="col-auto d-flex align-items-center">
            <a class="navbar-brand text-white" href="{{ route('earnings.index') }}">
                @include($activeTemplate . '.partials.logo')
            </a>
        </div>
        @auth
            <div class="col-auto d-flex justify-content-end me-md-4">
                <div class="d-flex align-items-center gap-md-2">
                    <div class="d-flex justify-content-center align-items-center gap-2 balance">
                        <div class="icon-balance">
                            {{ siteSymbol() }}
                        </div>
                        <span>{{ Auth::user()->balance }}</span>
                    </div>

                    <div class="d-flex justify-content-center align-items-center gap-2 balance" style="margin: 0 11px">
                        <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/level.svg') }}" alt="level"
                            class="img-fluid">
                        <span class="fw-semibold">Lv.{{ Auth::user()->level }}</span>
                    </div>
                    <a class="d-flex align-items-center avatar-dt text-white gap-1" href="{{ route('profile.show') }}">
                        <img src="{{ asset('assets/' . $activeTemplate . '/images/avatars/1.png') }}" class="profile-avatar"
                            alt="User Avatar">
                        <span class="d-none d-md-block">{{ Auth::user()->name }}</span>
                    </a>
                </div>
            </div>
        @else
            @if (request()->routeIs('home'))
                <!-- Center: Navigation Links -->
                <div class="d-none d-xl-flex mx-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link" data-bs-toggle="modal" data-bs-target="#authModal"
                                onclick="selectCreateAccountTab()">get started</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#cashout">cashout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#how-it-works">how it works</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#who-we-are">who we are</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#faq">FAQ</a>
                        </li>
                    </ul>
                </div>
            @endif
            <div class="d-flex align-items-center">
                <a href="javascript:void(0)" class="text-center fw-medium" data-bs-toggle="modal"
                    data-bs-target="#authModal" style="margin-right:13px; ">
                    <div class="position-relative">
                        <svg class="d-none d-lg-block" width="117" height="35" viewBox="0 0 117 35" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.1582 0.675781H115C115.798 0.675781 116.5 1.41248 116.5 2.27148V21.4609C116.5 21.8123 116.378 22.1812 116.175 22.4482L116.083 22.5557L105.876 33.2129C105.593 33.5083 105.201 33.6758 104.792 33.6758H2C1.17157 33.6758 0.5 33.0042 0.5 32.1758V13.5557C0.5 13.2119 0.618141 12.8797 0.832031 12.6143L0.928711 12.5049L12.0879 1.12598C12.3699 0.838363 12.7554 0.675866 13.1582 0.675781Z"
                                stroke="var(--primary-color)" />
                        </svg>

                        <svg class="d-lg-none" width="98" height="41" viewBox="0 0 98 41" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.123 1.35156H95.9648C96.7647 1.35156 97.4648 2.08554 97.4648 2.94336V28.1396C97.4648 28.4902 97.3439 28.8573 97.1406 29.124L97.0479 29.2314L86.8408 39.8887C86.5579 40.1841 86.1659 40.3516 85.7568 40.3516H2.96484C2.13642 40.3516 1.46484 39.68 1.46484 38.8516V14.2314C1.46484 13.8876 1.58298 13.5555 1.79688 13.29L1.89355 13.1807L13.0527 1.80176C13.3348 1.51414 13.7202 1.35165 14.123 1.35156Z"
                                fill="#1C171D" stroke="var(--primary-color)" />
                        </svg>

                        <div class="gar-btn-text">
                            sign in
                        </div>
                    </div>
                </a>
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#authModal"
                    onclick="selectCreateAccountTab()">
                    <div class="position-relative">
                        <svg class="d-none d-lg-block" width="117" height="35" viewBox="0 0 117 35" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.1582 0.675781H115C115.798 0.675781 116.5 1.41248 116.5 2.27148V21.4609C116.5 21.8123 116.378 22.1812 116.175 22.4482L116.083 22.5557L105.876 33.2129C105.593 33.5083 105.201 33.6758 104.792 33.6758H2C1.17157 33.6758 0.5 33.0042 0.5 32.1758V13.5557C0.5 13.2119 0.618141 12.8797 0.832031 12.6143L0.928711 12.5049L12.0879 1.12598C12.3699 0.838363 12.7554 0.675866 13.1582 0.675781Z"
                                fill="var(--primary-color)" stroke="var(--primary-color)" />
                        </svg>

                        <svg class="d-lg-none" width="98" height="41" viewBox="0 0 98 41" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.123 0.907898H95.9648C96.7647 0.907898 97.4648 1.64188 97.4648 2.49969V27.696C97.4648 28.0465 97.3439 28.4136 97.1406 28.6804L97.0479 28.7878L86.8408 39.445C86.5579 39.7404 86.1659 39.9079 85.7568 39.9079H2.96484C2.13642 39.9079 1.46484 39.2363 1.46484 38.4079V13.7878C1.46484 13.444 1.58298 13.1118 1.79688 12.8464L1.89355 12.737L13.0527 1.35809C13.3348 1.07048 13.7202 0.907983 14.123 0.907898Z"
                                fill="var(--primary-color)" stroke="var(--primary-color)" />
                        </svg>
                        <div class="gar-btn-text">
                            sign up
                        </div>
                    </div>
                </a>
            </div>
        @endauth
    </div>

</nav>
