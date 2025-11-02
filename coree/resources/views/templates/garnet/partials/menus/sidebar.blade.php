<nav class="side-nav">
    <div class="d-flex flex-column h-100">
        <ul class="nav flex-column">
            <li class="nav-item {{ request()->routeIs(['earnings.index', 'all.offers']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('earnings.index') }}">
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/earn.svg') }}" alt="earn"
                        class="nav-icon" />
                    <span>Earn</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('cashout.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ Auth::check() ? route('cashout.index') : '#' }}"
                    @unless (Auth::check()) 
                       data-bs-toggle="modal" 
                       data-bs-target="#authModal" 
                       onclick="selectCreateAccountTab()"
                   @endunless>
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/cashout.svg') }}" alt="cashout"
                        class="nav-icon" />
                    <span>Cashout</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('leaderboard.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ Auth::check() ? route('leaderboard.index') : '#' }}"
                    @unless (Auth::check()) 
                       data-bs-toggle="modal" 
                       data-bs-target="#authModal" 
                       onclick="selectCreateAccountTab()"
                   @endunless>
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/leaderboard.svg') }}"
                        alt="leaderboard" class="nav-icon" />
                    <span>Leaderboard</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('affiliates.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ Auth::check() ? route('affiliates.index') : '#' }}"
                    @unless (Auth::check()) 
                       data-bs-toggle="modal" 
                       data-bs-target="#authModal" 
                       onclick="selectCreateAccountTab()"
                   @endunless>
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/affiliate.svg') }}" alt="affiliate"
                        class="nav-icon" />
                    <span>Affiliates</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                <a class="nav-link" href="{{ Auth::check() ? route('profile.show') : '#' }}"
                    @unless (Auth::check()) 
                       data-bs-toggle="modal" 
                       data-bs-target="#authModal" 
                       onclick="selectCreateAccountTab()"
                   @endunless>
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/profile.svg') }}" alt="profile"
                        class="nav-icon" />
                    <span>Your Profile</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
