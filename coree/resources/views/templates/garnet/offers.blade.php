@extends($activeTemplate . '.layouts.app')
@section('title', 'All Offers')

@section('content')
    <div class="cosmic-bg">
        <div class="stars"></div>
        <div class="glow-orb glow-orb-blue" style="top: 15%; right: 10%;"></div>
        <div class="glow-orb glow-orb-purple" style="bottom: 25%; left: 5%;"></div>
    </div>

    @if (isset($isVPNDetected) && $isVPNDetected)
        <!-- VPN Detected -->
        <section class="section-space" style="padding-top: var(--space-3xl);">
            <div class="container-space">
                <div class="card-float text-center" style="padding: var(--space-3xl);">
                    <div class="vpn-shield" style="margin-bottom: var(--space-xl);">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#FF5370" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <path d="M12 8v4m0 4h.01"></path>
                        </svg>
                    </div>
                    <h2 class="heading-section" style="margin-bottom: var(--space-md);">VPN Detected</h2>
                    <p class="text-body-lg" style="color: rgba(255, 255, 255, 0.7);">
                        Please turn off your VPN for a smoother browsing experience. Thank you for your understanding!
                    </p>
                </div>
            </div>
        </section>
    @else
        @if (isOgadsApiEnabled() || count($allOffers) > 0)
            <!-- All Offers Section -->
            <section class="section-space" style="padding-top: var(--space-3xl);">
                <div class="container-space">
                    <div class="section-header-space">
                        <h1 class="heading-hero">
                            Latest <span class="text-gradient-blue">Offers</span>
                        </h1>
                        <p class="section-subtitle">Browse all available offers and start earning!</p>
                    </div>

                    @if (count($allOffers) > 0)
                        <!-- Offers Grid -->
                        <div class="offers-grid-space">
                            @foreach ($allOffers as $offer)
                                @include($activeTemplate . '.partials.offer-card', [
                                    'name' => $offer->name,
                                    'creative' => $offer->creative,
                                    'payout' => $offer->payout,
                                    'device' => $offer->device ?: 'desktop',
                                    'requirements' => $offer->requirements,
                                    'link' => Auth::check() ? $offer->link : '#',
                                    'description' => $offer->description,
                                    'event' => $offer->event ?? null,
                                ])
                            @endforeach
                        </div>
                    @endif

                    @if (count($ogadsOffers) > 0)
                        <!-- OGAds Offers Grid -->
                        <div class="offers-grid-space" style="margin-top: var(--space-lg);">
                            @foreach ($ogadsOffers as $ogads)
                                @include($activeTemplate . '.partials.offer-card', [
                                    'name' => $ogads['name_short'],
                                    'creative' => $ogads['picture'],
                                    'payout' => $ogads['payout'],
                                    'device' => detectDevicePlatform(),
                                    'requirements' => $ogads['adcopy'],
                                    'link' => Auth::check() ? $ogads['link'] . Auth::user()->uid : '#',
                                    'description' => $ogads['description'],
                                    'event' => null,
                                ])
                            @endforeach
                        </div>
                    @endif

                    <!-- Pagination -->
                    @if ($allOffers->lastPage() > 1)
                        <div class="pagination-space">
                            <div class="pagination-container">
                                <a href="{{ $allOffers->previousPageUrl() ?? '#' }}" 
                                   class="pagination-btn {{ $allOffers->onFirstPage() ? 'disabled' : '' }}">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>
                                    Previous
                                </a>

                                <div class="pagination-numbers">
                                    @php
                                        $lastPage = $allOffers->lastPage();
                                        $currentPage = $allOffers->currentPage();
                                        $ellipsisShown = false;
                                    @endphp

                                    @for ($page = 1; $page <= $lastPage; $page++)
                                        @if ($page == $currentPage)
                                            <span class="pagination-number active">{{ $page }}</span>
                                            @php $ellipsisShown = false; @endphp
                                        @elseif ($page == 1 || $page == $lastPage || abs($currentPage - $page) <= 2)
                                            <a href="{{ $allOffers->url($page) }}" class="pagination-number">{{ $page }}</a>
                                            @php $ellipsisShown = false; @endphp
                                        @elseif (!$ellipsisShown)
                                            <span class="pagination-dots">...</span>
                                            @php $ellipsisShown = true; @endphp
                                        @endif
                                    @endfor
                                </div>

                                <a href="{{ $allOffers->nextPageUrl() ?? '#' }}" 
                                   class="pagination-btn {{ !$allOffers->hasMorePages() ? 'disabled' : '' }}">
                                    Next
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif
        @include($activeTemplate . '.partials.modals.api')
    @endif
@endsection

@section('scripts')
    @include($activeTemplate . '.partials.scripts.api-offers')
@endsection

<style>
.offers-grid-space {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: var(--space-md);
    margin-top: var(--space-xl);
}

@media (min-width: 768px) {
    .offers-grid-space {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: var(--space-lg);
    }
}

@media (min-width: 1200px) {
    .offers-grid-space {
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    }
}

.pagination-space {
    margin-top: var(--space-3xl);
    display: flex;
    justify-content: center;
}

.pagination-container {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    background: var(--card-bg);
    padding: var(--space-sm) var(--space-md);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.pagination-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: rgba(0, 184, 212, 0.1);
    border: 1px solid rgba(0, 184, 212, 0.3);
    border-radius: 10px;
    color: #00B8D4;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.pagination-btn:hover:not(.disabled) {
    background: rgba(0, 184, 212, 0.2);
    border-color: #00B8D4;
    color: #00B8D4;
    transform: translateY(-1px);
}

.pagination-btn.disabled {
    opacity: 0.3;
    cursor: not-allowed;
    pointer-events: none;
}

.pagination-numbers {
    display: flex;
    align-items: center;
    gap: 4px;
}

.pagination-number {
    min-width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all 0.2s ease;
}

.pagination-number:hover {
    background: rgba(255, 255, 255, 0.05);
    color: #fff;
}

.pagination-number.active {
    background: linear-gradient(135deg, #00B8D4, #0081A7);
    color: #fff;
    box-shadow: 0 4px 12px rgba(0, 184, 212, 0.3);
}

.pagination-dots {
    color: rgba(255, 255, 255, 0.3);
    padding: 0 4px;
}

@media (max-width: 768px) {
    .offers-grid-space {
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: var(--space-md);
    }
    
    .pagination-container {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .pagination-numbers {
        order: 3;
        width: 100%;
        justify-content: center;
        margin-top: var(--space-sm);
    }
}
</style>
