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

