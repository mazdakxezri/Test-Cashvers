{{-- Clean Offer Card Component --}}
<div class="offer-card-clean">
    <div class="offer-header">
        @if($creative)
            <img src="{{ $creative }}" alt="{{ $name }}" class="offer-image">
        @else
            <div class="offer-image-placeholder">
                <span>{{ substr($name, 0, 2) }}</span>
            </div>
        @endif
    </div>
    
    <div class="offer-body">
        <h3 class="offer-title">{{ Str::limit($name, 50) }}</h3>
        
        @if($requirements)
            <p class="offer-requirements">{{ Str::limit($requirements, 80) }}</p>
        @endif
        
        <div class="offer-meta">
            @if($device && $device !== 'all')
                <span class="offer-badge badge-clean badge-primary">
                    {{ ucfirst($device) }}
                </span>
            @endif
        </div>
    </div>
    
    <div class="offer-footer">
        <div class="offer-reward-section">
            <span class="offer-reward-label">Reward</span>
            <span class="offer-reward">{{ siteSymbol() }}{{ number_format($payout, 2) }}</span>
        </div>
        
        @auth
            <a href="{{ $link }}" class="btn-primary btn-sm offer-cta" 
               @if($link === '#') onclick="return false;" @endif>
                Start Offer
            </a>
        @else
            <button class="btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#authModal">
                Login to Start
            </button>
        @endauth
    </div>
</div>

<style>
.offer-card-clean {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-normal);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all var(--transition-base);
    display: flex;
    flex-direction: column;
    height: 100%;
}

.offer-card-clean:hover {
    border-color: var(--primary);
    box-shadow: 0 0 30px rgba(0, 217, 255, 0.15);
    transform: translateY(-4px);
}

.offer-header {
    width: 100%;
    height: 180px;
    overflow: hidden;
    background: var(--bg-elevated);
}

.offer-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-slow);
}

.offer-card-clean:hover .offer-image {
    transform: scale(1.05);
}

.offer-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--bg-elevated) 0%, var(--bg-tertiary) 100%);
    font-size: 48px;
    font-weight: 700;
    color: var(--text-tertiary);
}

.offer-body {
    padding: var(--space-4);
    flex: 1;
}

.offer-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--space-2);
    line-height: 1.4;
}

.offer-requirements {
    font-size: 13px;
    color: var(--text-secondary);
    line-height: 1.5;
    margin-bottom: var(--space-3);
}

.offer-meta {
    display: flex;
    gap: var(--space-2);
    flex-wrap: wrap;
}

.offer-footer {
    padding: var(--space-4);
    border-top: 1px solid var(--border-subtle);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-3);
}

.offer-reward-section {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.offer-reward-label {
    font-size: 11px;
    color: var(--text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
}

.offer-reward {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary);
    line-height: 1;
}

.offer-cta {
    padding: 10px 20px !important;
    font-size: 14px !important;
    white-space: nowrap;
}
</style>

