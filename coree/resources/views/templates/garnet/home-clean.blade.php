@extends($activeTemplate . '.layouts.app')
@section('title', 'Earn')

@section('content')

    @if (isset($isVPNDetected) && $isVPNDetected)
        <section class="vpn-warning">
            <div class="container">
                <div class="alert-card">
                    <h3>VPN Detected</h3>
                    <p>Please disable your VPN to access offers. This helps us prevent fraud and ensure fair rewards for everyone.</p>
                </div>
            </div>
        </section>
    @else
        <!-- Latest Offers Section -->
        @if (isOgadsApiEnabled() || count($allOffers) > 0 || count($ogadsOffers) > 0)
            <section class="offers-section">
                <div class="container">
                    <div class="section-header-inline">
                        <h2>Latest Offers</h2>
                        <a href="{{ route('all.offers') }}" class="btn-ghost btn-sm">View All</a>
                    </div>
                    
                    <div class="offers-grid">
                        @foreach ($allOffers as $offer)
                            @include($activeTemplate . '.partials.offer-card-clean', [
                                'name' => $offer->name,
                                'creative' => $offer->creative,
                                'payout' => $offer->payout,
                                'device' => $offer->device ?: 'all',
                                'requirements' => $offer->requirements,
                                'link' => Auth::check() ? $offer->link : '#',
                                'description' => $offer->description,
                            ])
                        @endforeach
                        
                        @foreach ($ogadsOffers as $ogads)
                            @include($activeTemplate . '.partials.offer-card-clean', [
                                'name' => $ogads['name_short'],
                                'creative' => $ogads['picture'],
                                'payout' => $ogads['payout'],
                                'device' => detectDevicePlatform(),
                                'requirements' => $ogads['adcopy'],
                                'link' => Auth::check() ? $ogads['link'] . Auth::user()->uid : '#',
                                'description' => $ogads['description'],
                            ])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Offerwalls Section -->
        @if (count($offer_networks) > 0 || count($survey_networks) > 0)
            <section class="networks-section">
                <div class="container">
                    @if (count($offer_networks) > 0)
                        <div class="network-category">
                            <h2>Offer Partners</h2>
                            <div class="networks-grid">
                                @foreach ($offer_networks as $network)
                                    <div class="network-card" data-bs-toggle="modal" data-bs-target="#WallModal"
                                         data-url="{{ $network->offerwall_url }}">
                                        <img src="{{ url($network->network_image) }}" alt="{{ $network->network_name }}">
                                        <h4>{{ $network->network_name }}</h4>
                                        <p>{{ Str::limit($network->network_description, 60) }}</p>
                                        @if($network->level_id && $network->level)
                                            <span class="badge-clean badge-warning">Level {{ $network->level->level }} Required</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if (count($survey_networks) > 0)
                        <div class="network-category">
                            <h2>Survey Partners</h2>
                            <div class="networks-grid">
                                @foreach ($survey_networks as $network)
                                    <div class="network-card" data-bs-toggle="modal" data-bs-target="#WallModal"
                                         data-url="{{ $network->offerwall_url }}">
                                        <img src="{{ url($network->network_image) }}" alt="{{ $network->network_name }}">
                                        <h4>{{ $network->network_name }}</h4>
                                        <p>{{ Str::limit($network->network_description, 60) }}</p>
                                        @if($network->level_id && $network->level)
                                            <span class="badge-clean badge-warning">Level {{ $network->level->level }} Required</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        @include($activeTemplate . '.partials.modals.offerwall')
    @endif

@endsection

@section('scripts')
    <script>
        @auth
            // Offerwall modal handling
            document.addEventListener("DOMContentLoaded", () => {
                const modal = new bootstrap.Modal(document.getElementById("WallModal"));
                const iframe = document.getElementById("offerwallIframe");
                const preloader = document.getElementById("offerwall-preloader");

                document.querySelectorAll('.network-card[data-url]').forEach(element => {
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
        @endauth
    </script>
@endsection

<style>
/* Earn Page Specific Styles */
.vpn-warning {
    padding: var(--space-8) 0;
}

.alert-card {
    background: var(--bg-tertiary);
    border: 1px solid var(--warning);
    border-radius: var(--radius-lg);
    padding: var(--space-6);
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.alert-card h3 {
    color: var(--warning);
    margin-bottom: var(--space-3);
}

.offers-section, .networks-section {
    padding: var(--space-7) 0;
}

.section-header-inline {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-6);
}

.section-header-inline h2 {
    margin: 0;
    font-size: clamp(24px, 4vw, 28px);
}

.offers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: var(--space-5);
}

.network-category {
    margin-bottom: var(--space-7);
}

.network-category:last-child {
    margin-bottom: 0;
}

.network-category h2 {
    margin-bottom: var(--space-5);
    font-size: clamp(20px, 3.5vw, 24px);
}

.networks-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: var(--space-4);
}

.network-card {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-normal);
    border-radius: var(--radius-lg);
    padding: var(--space-5);
    text-align: center;
    cursor: pointer;
    transition: all var(--transition-base);
    position: relative;
    z-index: 1;
}

.network-card:hover {
    border-color: var(--primary);
    box-shadow: 0 0 25px var(--primary-glow);
    transform: translateY(-4px);
    z-index: 10;
}

.network-card:focus-visible {
    outline: 2px solid var(--primary);
    outline-offset: 2px;
}

.network-card:active {
    transform: translateY(-2px);
}

.network-card img {
    width: 100%;
    max-width: 120px;
    aspect-ratio: 2 / 1;
    object-fit: contain;
    margin-bottom: var(--space-3);
}

.network-card h4 {
    font-size: 16px;
    margin-bottom: var(--space-2);
    color: var(--text-primary);
}

.network-card p {
    font-size: 13px;
    color: var(--text-secondary);
    margin-bottom: var(--space-3);
    line-height: 1.5;
}

/* Responsive Breakpoints */
@media (max-width: 1024px) {
    .offers-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
    
    .networks-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }
}

@media (max-width: 768px) {
    .offers-section, .networks-section {
        padding: var(--space-6) 0;
    }
    
    .section-header-inline {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-3);
    }
    
    .offers-grid {
        grid-template-columns: 1fr;
    }
    
    .networks-grid {
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    }
    
    .network-category {
        margin-bottom: var(--space-6);
    }
}

@media (max-width: 480px) {
    .networks-grid {
        grid-template-columns: 1fr;
    }
}
</style>

