<nav class="nav-space">
    <div class="nav-space-content">
        <a class="nav-space-brand logo-enhanced" href="{{ auth()->check() ? route('earnings.index') : route('home') }}">
            <span class="logo-cash">Cash</span><span class="logo-vers">Vers</span>
        </a>
        
        @auth
            <div class="nav-space-links">
                <div class="balance-display-space">
                    <span class="balance-label">Balance</span>
                    <span class="balance-value">{{ siteSymbol() }}{{ number_format(Auth::user()->balance, 2) }}</span>
                </div>
                
                <div class="level-display-space">
                    <span class="level-label">Level</span>
                    <span class="level-value">{{ Auth::user()->level }}</span>
                </div>
                
                <div class="user-dropdown">
                    <button class="user-dropdown-toggle" onclick="toggleUserMenu(event)">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="user-name-short">{{ Str::limit(Auth::user()->name, 12) }}</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    
                    <div class="user-dropdown-menu" id="userDropdownMenu">
                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Profile & Settings
                        </a>
                        <a href="{{ route('affiliates.index') }}" class="dropdown-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            Referrals
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('auth.logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-item-danger">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            @if (request()->routeIs('home'))
                <div class="nav-space-links">
                    <a href="#how-it-works" class="nav-space-link">How It Works</a>
                    <a href="#faq" class="nav-space-link">FAQ</a>
                    <button class="btn-space-primary btn-sm-space" data-bs-toggle="modal" 
                            data-bs-target="#authModal" onclick="selectCreateAccountTab()">
                        Get Started
                    </button>
                </div>
            @endif
        @endauth
    </div>
</nav>

<style>
/* Enhanced Logo */
.logo-enhanced {
    font-size: 26px !important;
    font-weight: 800 !important;
    letter-spacing: -0.5px !important;
    text-decoration: none !important;
    transition: all 0.3s ease !important;
}

.logo-cash {
    background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 900;
}

.logo-vers {
    color: #ffffff;
    font-weight: 600;
}

.logo-enhanced:hover {
    transform: translateY(-1px);
}

.logo-enhanced:hover .logo-cash {
    background: linear-gradient(135deg, #0D47A1 0%, #00B8D4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.balance-display-space,
.level-display-space {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    padding: 8px 16px;
    background: rgba(18, 18, 26, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-md);
    transition: all 0.3s ease;
}

.balance-display-space:hover,
.level-display-space:hover {
    border-color: rgba(0, 184, 212, 0.3);
}

.balance-label,
.level-label {
    font-size: 11px;
    color: var(--text-dim);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
}

.balance-value {
    font-size: 16px;
    font-weight: 700;
    color: var(--primary-bright);
}

.level-value {
    font-size: 16px;
    font-weight: 700;
    color: var(--accent-warm);
}

@media (max-width: 768px) {
    /* Fix nav spacing and overlapping on mobile */
    .nav-space {
        padding: 12px 0 !important;
    }
    
    .nav-space-content {
        padding: 0 12px !important;
        gap: 12px;
    }
    
    /* Smaller logo on mobile */
    .logo-enhanced {
        font-size: 20px !important;
        letter-spacing: -0.3px !important;
    }
    
    /* Make nav links smaller and wrap better */
    .nav-space-links {
        gap: 8px !important;
        flex-wrap: nowrap;
    }
    
    .nav-space-link {
        font-size: 13px !important;
        padding: 0 !important;
        white-space: nowrap;
    }
    
    /* Smaller "Get Started" button on mobile */
    .btn-sm-space {
        font-size: 12px !important;
        padding: 8px 14px !important;
        white-space: nowrap;
    }
    
    .balance-display-space,
    .level-display-space {
        padding: 6px 12px;
    }
    
    .balance-label,
    .level-label {
        font-size: 9px;
    }
    
    .balance-value,
    .level-value {
        font-size: 14px;
    }
}

/* Extra small screens */
@media (max-width: 480px) {
    .logo-enhanced {
        font-size: 18px !important;
    }
    
    .nav-space-link {
        font-size: 11px !important;
    }
    
    .btn-sm-space {
        font-size: 11px !important;
        padding: 6px 12px !important;
    }
}

/* User Dropdown */
.user-dropdown {
    position: relative;
}

.user-dropdown-toggle {
    background: rgba(18, 18, 26, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-md);
    padding: 8px 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: white;
}

.user-dropdown-toggle:hover {
    border-color: rgba(0, 184, 212, 0.3);
    background: rgba(18, 18, 26, 0.8);
}

.user-avatar {
    width: 32px;
    height: 32px;
    background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    color: white;
}

.user-name-short {
    font-size: 14px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
}

.user-dropdown-menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    background: rgba(18, 18, 26, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 8px;
    min-width: 220px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-10px);
    transition: all 0.3s ease;
    z-index: 10000;
}

.user-dropdown-menu.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.2s ease;
    font-size: 14px;
    font-weight: 500;
    width: 100%;
    border: none;
    background: none;
    text-align: left;
    cursor: pointer;
}

.dropdown-item:hover {
    background: rgba(0, 184, 212, 0.1);
    color: #00B8D4;
}

.dropdown-item svg {
    stroke: currentColor;
}

.dropdown-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.1);
    margin: 8px 0;
}

.dropdown-item-danger:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}
</style>

<script>
function toggleUserMenu(event) {
    event.stopPropagation();
    const menu = document.getElementById('userDropdownMenu');
    menu.classList.toggle('show');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('userDropdownMenu');
    if (menu && !event.target.closest('.user-dropdown')) {
        menu.classList.remove('show');
    }
});
</script>

