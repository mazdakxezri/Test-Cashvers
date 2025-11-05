<aside class="sidebar-space">
    <nav class="sidebar-nav">
        <a href="{{ route('earnings.index') }}" class="sidebar-link {{ request()->routeIs('earnings.index') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="9" y1="3" x2="9" y2="21"></line>
            </svg>
            <span>Earn</span>
        </a>
        
        <a href="{{ route('cashout.index') }}" class="sidebar-link {{ request()->routeIs('cashout.index') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"></line>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
            <span>Cashout</span>
        </a>
        
        <a href="{{ route('lootbox.index') }}" class="sidebar-link {{ request()->routeIs('lootbox.index') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="8" width="18" height="12" rx="2" ry="2"></rect>
                <path d="M12 8V3M8 3h8"></path>
                <line x1="3" y1="13" x2="21" y2="13"></line>
            </svg>
            <span>Loot Boxes</span>
        </a>
        
        <a href="{{ route('crypto.deposit') }}" class="sidebar-link {{ request()->routeIs('crypto.deposit') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 6v12M6 12h12"></path>
            </svg>
            <span>Deposit Crypto</span>
        </a>
        
        <a href="{{ route('affiliates.index') }}" class="sidebar-link {{ request()->routeIs('affiliates.index') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
            <span>Referrals</span>
        </a>
        
        <a href="{{ route('leaderboard.index') }}" class="sidebar-link {{ request()->routeIs('leaderboard.index') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path>
            </svg>
            <span>Leaderboard</span>
        </a>
        
        <a href="{{ route('profile.show') }}" class="sidebar-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span>Profile</span>
        </a>
    </nav>
</aside>

<style>
.sidebar-space {
    position: fixed;
    left: 0;
    top: 76px;
    width: 240px;
    height: calc(100vh - 76px);
    background: rgba(10, 10, 15, 0.95);
    backdrop-filter: blur(20px);
    border-right: 1px solid rgba(255, 255, 255, 0.05);
    padding: var(--space-lg) 0;
    z-index: 100;
}

.sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: var(--space-xs);
    padding: 0 var(--space-md);
}

.sidebar-link {
    display: flex;
    align-items: center;
    gap: var(--space-md);
    padding: var(--space-md) var(--space-md);
    border-radius: var(--radius-md);
    color: var(--text-gray);
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.sidebar-link svg {
    flex-shrink: 0;
}

.sidebar-link:hover {
    background: rgba(0, 184, 212, 0.08);
    color: var(--primary-bright);
}

.sidebar-link.active {
    background: rgba(0, 184, 212, 0.12);
    color: var(--primary-bright);
    border-left: 3px solid var(--primary-glow);
    padding-left: calc(var(--space-md) - 3px);
}

.sidebar-link.active svg {
    stroke: var(--primary-bright);
}
</style>

