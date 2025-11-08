@extends($activeTemplate . '.layouts.app')
@section('title', 'Loot Boxes')

@section('content')
    <div class="cosmic-bg">
        <div class="stars"></div>
        <div class="glow-orb glow-orb-blue" style="top: 10%; right: 5%;"></div>
        <div class="glow-orb glow-orb-purple" style="bottom: 20%; left: 8%;"></div>
    </div>

    <section class="section-space" style="padding-top: var(--space-3xl);">
        <div class="container-space">
            <!-- Page Header -->
            <div class="section-header-space">
                <h1 class="heading-hero">
                    🎁 Loot <span class="text-gradient-blue">Boxes</span>
                </h1>
                <p class="section-subtitle">Open mystery boxes and win amazing rewards!</p>
            </div>

            <!-- Unopened Boxes -->
            @if ($unopenedBoxes->count() > 0)
                <div class="card-float" style="margin-bottom: var(--space-2xl);">
                    <h3 style="margin-bottom: var(--space-lg); color: #00B8D4;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                            <rect x="3" y="8" width="18" height="4" rx="1"></rect>
                            <path d="M12 8v13"></path>
                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path>
                            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path>
                        </svg>
                        Your Unopened Boxes ({{ $unopenedBoxes->count() }})
                    </h3>
                    <div class="lootbox-grid">
                        @foreach ($unopenedBoxes as $box)
                            <div class="lootbox-unopened-card">
                                <div class="lootbox-unopened-image">
                                    <img src="{{ asset($box->lootBoxType->image) }}" alt="{{ $box->lootBoxType->name }}">
                                    <div class="shine-effect"></div>
                                </div>
                                <h4>{{ $box->lootBoxType->name }}</h4>
                                <p style="font-size: 12px; color: rgba(255, 255, 255, 0.6); margin-bottom: var(--space-md);">
                                    Purchased: {{ $box->created_at->diffForHumans() }}
                                </p>
                                <form action="{{ route('lootbox.open') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="purchase_id" value="{{ $box->id }}">
                                    <button type="submit" class="btn-space btn-primary-space" style="width: 100%;">
                                        🎁 Open Box
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Unclaimed Rewards -->
            @if ($unclaimedRewards->count() > 0)
                <div class="card-float" style="margin-bottom: var(--space-2xl);">
                    <h3 style="margin-bottom: var(--space-lg); color: #FFD700;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                            <circle cx="12" cy="8" r="7"></circle>
                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                        </svg>
                        Unclaimed Rewards ({{ $unclaimedRewards->count() }})
                    </h3>
                    <div class="rewards-grid">
                        @foreach ($unclaimedRewards as $reward)
                            <div class="reward-card rarity-{{ $reward->item->rarity }}">
                                <div class="reward-rarity-badge">{{ ucfirst($reward->item->rarity) }}</div>
                                <div class="reward-image">
                                    <img src="{{ asset($reward->item->image) }}" alt="{{ $reward->item->name }}">
                                </div>
                                <h4>{{ $reward->item->name }}</h4>
                                <p class="reward-value">{{ siteSymbol() }}{{ number_format($reward->item->value, 2) }}</p>
                                <form action="{{ route('lootbox.claim') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="reward_id" value="{{ $reward->id }}">
                                    <button type="submit" class="btn-space btn-secondary-space" style="width: 100%;">
                                        💰 Claim Reward
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Available Loot Boxes -->
            <div class="card-float">
                <h3 style="margin-bottom: var(--space-lg);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align: middle; margin-right: 8px;">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    Available Loot Boxes
                </h3>

                @if ($lootBoxTypes->count() > 0)
                    <div class="lootbox-grid">
                        @foreach ($lootBoxTypes as $type)
                            <div class="lootbox-card">
                                <div class="lootbox-image-wrapper">
                                    <img src="{{ asset($type->image) }}" alt="{{ $type->name }}" class="lootbox-image">
                                    <div class="lootbox-glow"></div>
                                </div>
                                <div class="lootbox-info">
                                    <h4 class="lootbox-name">{{ $type->name }}</h4>
                                    <p class="lootbox-description">{{ $type->description }}</p>
                                    <div class="lootbox-price">
                                        <span class="price-label">Price:</span>
                                        <span class="price-value">{{ siteSymbol() }}{{ number_format($type->price, 2) }}</span>
                                    </div>
                                    <form action="{{ route('lootbox.purchase') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="loot_box_type_id" value="{{ $type->id }}">
                                        <input type="hidden" name="payment_method" value="earnings">
                                        <button type="submit" class="btn-space btn-primary-space" style="width: 100%;">
                                            🛒 Purchase Box
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center" style="padding: var(--space-3xl); color: rgba(255, 255, 255, 0.5);">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin-bottom: var(--space-md); opacity: 0.3;">
                            <rect x="3" y="8" width="18" height="4" rx="1"></rect>
                            <path d="M12 8v13"></path>
                            <path d="M19 12v7a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-7"></path>
                            <path d="M7.5 8a2.5 2.5 0 0 1 0-5A4.8 8 0 0 1 12 8a4.8 8 0 0 1 4.5-5 2.5 2.5 0 0 1 0 5"></path>
                        </svg>
                        <h3 style="color: rgba(255, 255, 255, 0.7); margin-bottom: var(--space-sm);">No Loot Boxes Available</h3>
                        <p>Check back soon for new loot boxes!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
.lootbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: var(--space-lg);
}

.lootbox-card {
    background: linear-gradient(145deg, rgba(15, 15, 25, 0.8), rgba(20, 20, 30, 0.9));
    border: 1px solid rgba(0, 184, 212, 0.2);
    border-radius: 16px;
    padding: var(--space-lg);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.lootbox-card:hover {
    border-color: #00B8D4;
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0, 184, 212, 0.2);
}

.lootbox-image-wrapper {
    position: relative;
    width: 100%;
    height: 180px;
    margin-bottom: var(--space-md);
    display: flex;
    align-items: center;
    justify-content: center;
}

.lootbox-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    position: relative;
    z-index: 2;
    filter: drop-shadow(0 0 20px rgba(0, 184, 212, 0.3));
}

.lootbox-glow {
    position: absolute;
    width: 150px;
    height: 150px;
    background: radial-gradient(circle, rgba(0, 184, 212, 0.3) 0%, transparent 70%);
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.lootbox-info {
    text-align: center;
}

.lootbox-name {
    font-size: 18px;
    font-weight: 700;
    color: #fff;
    margin-bottom: var(--space-sm);
}

.lootbox-description {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.6);
    margin-bottom: var(--space-md);
    min-height: 36px;
}

.lootbox-price {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-bottom: var(--space-md);
    padding: var(--space-sm);
    background: rgba(0, 184, 212, 0.1);
    border-radius: 8px;
}

.price-label {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.7);
}

.price-value {
    font-size: 18px;
    font-weight: 700;
    color: #00B8D4;
}

.lootbox-unopened-card {
    background: linear-gradient(145deg, rgba(255, 215, 0, 0.1), rgba(255, 165, 0, 0.1));
    border: 2px solid rgba(255, 215, 0, 0.4);
    border-radius: 16px;
    padding: var(--space-lg);
    text-align: center;
    position: relative;
    overflow: hidden;
}

.lootbox-unopened-image {
    position: relative;
    width: 100%;
    height: 160px;
    margin-bottom: var(--space-md);
    display: flex;
    align-items: center;
    justify-content: center;
}

.lootbox-unopened-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.shine-effect {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: shine 3s infinite;
}

@keyframes shine {
    0% { left: -100%; }
    50%, 100% { left: 100%; }
}

.rewards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: var(--space-md);
}

.reward-card {
    border-radius: 12px;
    padding: var(--space-md);
    text-align: center;
    position: relative;
    border: 2px solid;
}

.reward-card.rarity-common {
    background: rgba(158, 158, 158, 0.1);
    border-color: rgba(158, 158, 158, 0.5);
}

.reward-card.rarity-rare {
    background: rgba(0, 112, 221, 0.1);
    border-color: rgba(0, 112, 221, 0.5);
}

.reward-card.rarity-epic {
    background: rgba(163, 53, 238, 0.1);
    border-color: rgba(163, 53, 238, 0.5);
}

.reward-card.rarity-legendary {
    background: rgba(255, 128, 0, 0.1);
    border-color: rgba(255, 128, 0, 0.5);
}

.reward-rarity-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    background: rgba(0, 0, 0, 0.5);
    color: #fff;
}

.reward-image {
    width: 100%;
    height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: var(--space-sm);
}

.reward-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.reward-value {
    font-size: 20px;
    font-weight: 700;
    color: #FFD700;
    margin-bottom: var(--space-md);
}

@media (max-width: 768px) {
    .lootbox-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: var(--space-md);
    }
    
    .rewards-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
