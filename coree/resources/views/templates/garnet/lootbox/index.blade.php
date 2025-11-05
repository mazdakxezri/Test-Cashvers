@extends($activeTemplate . '.layouts.app')
@section('title', 'Loot Boxes')

@section('content')
<div class="cosmic-bg">
    <div class="stars"></div>
    <div class="glow-orb glow-orb-blue" style="top: 15%; right: 8%;"></div>
    <div class="glow-orb glow-orb-warm" style="bottom: 25%; left: 12%;"></div>
</div>

<section class="section-space" style="padding-top: var(--space-3xl);">
    <div class="container-space">
        <div class="section-header-inline">
            <h2 class="heading-section" style="margin: 0;">🎁 Loot Boxes</h2>
        </div>

        <!-- Available Loot Boxes -->
        @if(count($lootBoxTypes) > 0)
        <div class="lootbox-grid">
            @foreach($lootBoxTypes as $box)
            <div class="lootbox-card">
                <div class="lootbox-image">
                    @if($box->image)
                        <img src="{{ url($box->image) }}" alt="{{ $box->name }}">
                    @else
                        <div class="lootbox-placeholder">🎁</div>
                    @endif
                </div>
                <div class="lootbox-content">
                    <h4 class="lootbox-name">{{ $box->name }}</h4>
                    <p class="lootbox-desc">{{ $box->description }}</p>
                    <div class="lootbox-price">${{ number_format($box->price_usd, 2) }}</div>
                    <form action="{{ route('lootbox.purchase') }}" method="POST">
                        @csrf
                        <input type="hidden" name="loot_box_type_id" value="{{ $box->id }}">
                        <input type="hidden" name="payment_method" value="earnings">
                        <button type="submit" class="btn-space-primary w-100">
                            Purchase with Balance
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="card-float text-center" style="padding: 60px 40px;">
            <h4 style="color: rgba(255, 255, 255, 0.6); margin-bottom: 16px;">🎁 No Loot Boxes Available</h4>
            <p style="color: rgba(255, 255, 255, 0.5); margin: 0;">
                Loot boxes are coming soon! The admin needs to create loot box types and rewards.
            </p>
        </div>
        @endif

        <!-- Unopened Boxes -->
        @if(count($unopenedBoxes) > 0)
        <div style="margin-top: var(--space-2xl);">
            <h3 class="heading-section" style="margin-bottom: var(--space-xl);">📦 Your Unopened Boxes</h3>
            <div class="unopened-boxes-grid">
                @foreach($unopenedBoxes as $purchase)
                <div class="unopened-box-card" onclick="openLootBox({{ $purchase->id }})">
                    <div class="unopened-box-shine"></div>
                    <div class="unopened-box-icon">🎁</div>
                    <h5>{{ $purchase->lootBoxType->name }}</h5>
                    <button class="btn-space-primary btn-sm-space">
                        Open Now
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Unclaimed Rewards -->
        @if(count($unclaimedRewards) > 0)
        <div style="margin-top: var(--space-2xl);">
            <h3 class="heading-section" style="margin-bottom: var(--space-xl);">💎 Unclaimed Rewards</h3>
            <div class="rewards-grid">
                @foreach($unclaimedRewards as $reward)
                <div class="reward-card reward-{{ $reward->item->rarity }}">
                    <div class="reward-rarity">{{ ucfirst($reward->item->rarity) }}</div>
                    <div class="reward-name">{{ $reward->item->name }}</div>
                    <div class="reward-value">${{ number_format($reward->value_received, 2) }}</div>
                    <form action="{{ route('lootbox.claim') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reward_id" value="{{ $reward->id }}">
                        <button type="submit" class="btn-space-primary btn-sm-space w-100">
                            Claim Reward
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<style>
.lootbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--space-lg);
    margin-bottom: var(--space-2xl);
}

.lootbox-card {
    background: rgba(18, 18, 26, 0.6);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: var(--radius-xl);
    overflow: hidden;
    transition: all 0.4s ease;
}

.lootbox-card:hover {
    transform: translateY(-8px);
    border-color: rgba(0, 184, 212, 0.4);
    box-shadow: 0 20px 40px rgba(0, 184, 212, 0.2);
}

.lootbox-image {
    width: 100%;
    aspect-ratio: 1 / 1;
    background: linear-gradient(135deg, rgba(0, 184, 212, 0.2) 0%, rgba(13, 71, 161, 0.2) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.lootbox-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.lootbox-placeholder {
    font-size: 80px;
    animation: pulse 2s ease-in-out infinite;
}

.lootbox-content {
    padding: var(--space-lg);
}

.lootbox-name {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-white);
    margin-bottom: var(--space-sm);
    font-family: 'Inter', sans-serif;
}

.lootbox-desc {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.6);
    margin-bottom: var(--space-md);
    line-height: 1.6;
}

.lootbox-price {
    font-size: 28px;
    font-weight: 800;
    background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: var(--space-md);
    font-family: 'Inter', sans-serif;
}

.unopened-boxes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: var(--space-md);
}

.unopened-box-card {
    background: rgba(18, 18, 26, 0.6);
    border: 2px solid rgba(0, 184, 212, 0.4);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
    text-align: center;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.unopened-box-card:hover {
    transform: scale(1.05);
    border-color: rgba(0, 184, 212, 0.8);
    box-shadow: 0 10px 40px rgba(0, 184, 212, 0.3);
}

.unopened-box-shine {
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(0, 184, 212, 0.3), transparent);
    animation: shine 3s ease-in-out infinite;
}

@keyframes shine {
    0%, 100% { transform: translateX(-100%) rotate(45deg); }
    50% { transform: translateX(100%) rotate(45deg); }
}

.unopened-box-icon {
    font-size: 64px;
    margin-bottom: var(--space-md);
    animation: bounce 2s ease-in-out infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.rewards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: var(--space-md);
}

.reward-card {
    background: rgba(18, 18, 26, 0.6);
    border: 2px solid;
    border-radius: var(--radius-lg);
    padding: var(--space-lg);
    text-align: center;
}

.reward-card.reward-common { border-color: #9E9E9E; }
.reward-card.reward-uncommon { border-color: #4CAF50; }
.reward-card.reward-rare { border-color: #2196F3; }
.reward-card.reward-epic { border-color: #9C27B0; }
.reward-card.reward-legendary { border-color: #FF9800; }

.reward-rarity {
    font-size: 11px;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.05em;
    margin-bottom: var(--space-sm);
}

.reward-name {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-white);
    margin-bottom: var(--space-sm);
}

.reward-value {
    font-size: 24px;
    font-weight: 800;
    color: #00B8D4;
    margin-bottom: var(--space-md);
}
</style>

<script>
function openLootBox(purchaseId) {
    if (!confirm('Open this loot box?')) return;
    
    fetch('{{ route('lootbox.open') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ purchase_id: purchaseId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showRewardAnimation(data.item, data.value, data.rarity);
            setTimeout(() => location.reload(), 3000);
        }
    })
    .catch(error => console.error('Error:', error));
}

function showRewardAnimation(item, value, rarity) {
    const overlay = document.createElement('div');
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 999999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    `;
    
    const rarityColors = {
        common: '#9E9E9E',
        uncommon: '#4CAF50',
        rare: '#2196F3',
        epic: '#9C27B0',
        legendary: '#FF9800'
    };
    
    overlay.innerHTML = `
        <div style="text-align: center; animation: popIn 0.5s ease;">
            <div style="font-size: 120px; margin-bottom: 24px; animation: spin 1s ease;">🎁</div>
            <div style="font-size: 18px; color: ${rarityColors[rarity]}; font-weight: 700; text-transform: uppercase; margin-bottom: 16px;">
                ${rarity}
            </div>
            <div style="font-size: 32px; color: white; font-weight: 800; margin-bottom: 12px;">
                ${item.name}
            </div>
            <div style="font-size: 48px; color: #00B8D4; font-weight: 900;">
                +$${value.toFixed(2)}
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes popIn {
            0% { transform: scale(0); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
}
</script>
@endsection

