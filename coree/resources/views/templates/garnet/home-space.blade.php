@extends($activeTemplate . '.layouts.app')
@section('title', 'Earn')

@section('content')
    <!-- Cosmic Background for Dashboard -->
    <div class="cosmic-bg">
        <div class="stars"></div>
        <div class="glow-orb glow-orb-blue" style="top: 10%; right: 5%;"></div>
        <div class="glow-orb glow-orb-purple" style="bottom: 30%; left: 10%;"></div>
    </div>

    <!-- Level Progress Widget -->
    @include($activeTemplate . '.partials.widgets.level-progress')
    
    <!-- Daily Login Bonus Widget -->
    @include($activeTemplate . '.partials.widgets.daily-bonus')

    @if (isset($isVPNDetected) && $isVPNDetected)
        <section class="section-space">
            <div class="container-space">
                <div class="card-float" style="max-width: 600px; margin: 0 auto; text-align: center;">
                    <h3>VPN Detected</h3>
                    <p style="margin: 0;">Please disable your VPN to access offers. This helps us prevent fraud and ensure fair rewards.</p>
                </div>
            </div>
        </section>
    @else
        <!-- Latest Offers -->
        @if (isOgadsApiEnabled() || count($allOffers) > 0 || count($ogadsOffers) > 0)
            <section class="section-space" style="padding-top: var(--space-3xl);">
                <div class="container-space">
                    <div class="section-header-inline">
                        <h2 class="heading-section" style="margin: 0;">Latest Offers</h2>
                        <a href="{{ route('all.offers') }}" class="btn-space-secondary btn-sm-space">View All</a>
                    </div>
                    
                    <div class="offers-grid-space">
                        @foreach ($allOffers->take(6) as $offer)
                            <button class="offer-card-space" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#ApiModal"
                                    data-name="{{ $offer->name }}"
                                    data-creative="{{ $offer->creative }}"
                                    data-payout="{{ number_format($offer->payout, 2) }}"
                                    data-device="{{ $offer->device }}"
                                    data-requirements="{{ $offer->requirements }}"
                                    data-link="{{ $offer->link }}"
                                    data-description="{{ $offer->description ?? '' }}"
                                    data-event='@json($offer->event ?? [])'>
                                @if($offer->creative)
                                    <img src="{{ $offer->creative }}" alt="{{ $offer->name }}" class="offer-image-space">
                                @else
                                    <div class="offer-image-space offer-placeholder-space">
                                        <span>{{ strtoupper(substr($offer->name, 0, 2)) }}</span>
                                    </div>
                                @endif
                                
                                <div class="offer-content-space">
                                    <h4 class="offer-title-space">{{ Str::limit($offer->name, 60) }}</h4>
                                    <p class="offer-desc-space">{{ Str::limit($offer->requirements, 100) }}</p>
                                    
                                    <div class="offer-footer-space">
                                        <div class="offer-reward-space">{{ siteSymbol() }}{{ number_format($offer->payout, 2) }}</div>
                                        <span class="btn-space-primary btn-sm-space">
                                            View Details
                                        </span>
                                    </div>
                                </div>
                            </button>
                        @endforeach
                        
                        @foreach ($ogadsOffers->take(6) as $ogads)
                            <button class="offer-card-space"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#ApiModal"
                                    data-name="{{ $ogads['name_short'] }}"
                                    data-creative="{{ $ogads['picture'] }}"
                                    data-payout="{{ number_format($ogads['payout'], 2) }}"
                                    data-device="{{ $ogads['device'] ?? 'desktop' }}"
                                    data-requirements="{{ $ogads['description'] ?? '' }}"
                                    data-link="{{ $ogads['link'] . (Auth::check() ? Auth::user()->uid : '') }}"
                                    data-description="{{ $ogads['adcopy'] ?? '' }}"
                                    data-event='[]'>
                                <img src="{{ $ogads['picture'] }}" alt="{{ $ogads['name_short'] }}" class="offer-image-space">
                                
                                <div class="offer-content-space">
                                    <h4 class="offer-title-space">{{ Str::limit($ogads['name_short'], 60) }}</h4>
                                    <p class="offer-desc-space">{{ Str::limit($ogads['adcopy'], 100) }}</p>
                                    
                                    <div class="offer-footer-space">
                                        <div class="offer-reward-space">{{ siteSymbol() }}{{ number_format($ogads['payout'], 2) }}</div>
                                        <span class="btn-space-primary btn-sm-space">
                                            View Details
                                        </span>
                                    </div>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Offer Partners -->
        @if (count($offer_networks) > 0)
            <section class="section-space" style="background: var(--space-dark);">
                <div class="container-space">
                    <div class="section-header-space">
                        <h2 class="heading-section">Offer Partners</h2>
                        <p class="section-subtitle">Explore partner networks for more earning opportunities</p>
                    </div>
                    
                    <div class="networks-grid-space">
                        @foreach ($offer_networks as $network)
                            <div class="network-card-space" data-bs-toggle="modal" data-bs-target="#WallModal"
                                 data-url="{{ $network->offerwall_url }}">
                                <div class="network-image-container">
                                    <img src="{{ url($network->network_image) }}" alt="{{ $network->network_name }}">
                                </div>
                                <h4>{{ $network->network_name }}</h4>
                                <p>{{ Str::limit($network->network_description, 80) }}</p>
                                @if($network->level_id && $network->level)
                                    <span class="badge-space badge-warning">Level {{ $network->level->level }}+</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Survey Partners -->
        @if (count($survey_networks) > 0)
            <section class="section-space">
                <div class="container-space">
                    <div class="section-header-space">
                        <h2 class="heading-section">Survey Partners</h2>
                        <p class="section-subtitle">Share your opinions and get rewarded</p>
                    </div>
                    
                    <div class="networks-grid-space">
                        @foreach ($survey_networks as $network)
                            <div class="network-card-space" data-bs-toggle="modal" data-bs-target="#WallModal"
                                 data-url="{{ $network->offerwall_url }}">
                                <div class="network-image-container">
                                    <img src="{{ url($network->network_image) }}" alt="{{ $network->network_name }}">
                                </div>
                                <h4>{{ $network->network_name }}</h4>
                                <p>{{ Str::limit($network->network_description, 80) }}</p>
                                @if($network->level_id && $network->level)
                                    <span class="badge-space badge-warning">Level {{ $network->level->level }}+</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @include($activeTemplate . '.partials.modals.offerwall')
    @endif

    @include($activeTemplate . '.partials.modals.api')
@endsection

@section('scripts')
    @auth
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const modal = new bootstrap.Modal(document.getElementById("WallModal"));
                const iframe = document.getElementById("offerwallIframe");
                const preloader = document.getElementById("offerwall-preloader");

                document.querySelectorAll('.network-card-space[data-url]').forEach(element => {
                    element.addEventListener("click", function() {
                        const offerUrl = this.getAttribute("data-url");
                        if (!offerUrl || !modal || !iframe || !preloader) return;

                        iframe.src = offerUrl;
                        preloader.style.display = "flex";
                        modal.show();

                        iframe.onload = () => {
                            preloader.style.display = "none";
                        };
                    });
                });
            });
        </script>
    @endauth

    @include($activeTemplate . '.partials.scripts.api-offers')
@endsection

<style>
.section-header-inline {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-xl);
}

.btn-sm-space {
    padding: 10px 24px !important;
    font-size: 14px !important;
}

.offers-grid-space {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: var(--space-md);
}

.offer-placeholder-space {
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--space-elevated) 0%, var(--space-card) 100%);
    font-size: 40px;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.1);
}

.networks-grid-space {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--space-lg);
}

.network-card-space {
    background: rgba(18, 18, 26, 0.5);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
    text-align: center;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.network-card-space:hover {
    transform: translateY(-6px);
    border-color: rgba(0, 184, 212, 0.3);
    box-shadow: 
        var(--shadow-xl),
        0 0 30px rgba(0, 184, 212, 0.15);
}

.network-image-container {
    width: 100%;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: var(--space-md);
}

.network-image-container img {
    max-width: 140px;
    max-height: 70px;
    object-fit: contain;
    filter: brightness(1.1);
}

.network-card-space h4 {
    font-size: 18px;
    margin-bottom: var(--space-sm);
    color: var(--text-white);
}

.network-card-space p {
    font-size: 14px;
    color: var(--text-gray);
    margin-bottom: var(--space-md);
    line-height: 1.6;
}

@media (max-width: 768px) {
    .offers-grid-space {
        grid-template-columns: 1fr;
    }
    
    .networks-grid-space {
        grid-template-columns: 1fr;
    }
}

/* Make button.offer-card-space look like a div */
button.offer-card-space {
    background: none;
    border: none;
    padding: 0;
    text-align: left;
    cursor: pointer;
    width: 100%;
}

button.offer-card-space:focus {
    outline: none;
}
</style>
