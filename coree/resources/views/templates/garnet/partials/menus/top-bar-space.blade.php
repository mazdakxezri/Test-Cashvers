<nav class="nav-space">
    <div class="nav-space-content">
        <a class="nav-space-brand" href="{{ auth()->check() ? route('earnings.index') : route('home') }}">
            {{ siteName() }}
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
                
                <a class="nav-space-link" href="{{ route('profile.show') }}">
                    {{ Auth::user()->name }}
                </a>
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
    .nav-space-links {
        gap: var(--space-sm) !important;
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
</style>

