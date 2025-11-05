@extends($activeTemplate . '.layouts.app')
@section('title', 'Cashout')

@section('content')
    <div class="cosmic-bg">
        <div class="stars"></div>
        <div class="glow-orb glow-orb-blue" style="top: 15%; right: 8%;"></div>
        <div class="glow-orb glow-orb-warm" style="bottom: 25%; left: 12%;"></div>
    </div>

    <section class="section-space" style="padding-top: var(--space-3xl);">
        <div class="container-space">
            <!-- Balance & Progress -->
            <div class="balance-progress-card">
                <div class="balance-section">
                    <span class="balance-label-lg">Your Balance</span>
                    <span class="balance-value-lg">{{ siteSymbol() }}{{ number_format($userBalance, 2) }}</span>
                </div>
                
                <div class="progress-section">
                    <div class="progress-header">
                        <span>Next Milestone</span>
                        <span>{{ siteSymbol() }}{{ number_format($withdrawalAmount, 2) }}</span>
                    </div>
                    <div class="progress-bar-space">
                        <div class="progress-fill-space" style="width: {{ min($progressPercentage, 100) }}%"></div>
                    </div>
                    <div class="progress-footer">
                        <span>{{ number_format($progressPercentage, 0) }}% Complete</span>
                    </div>
                </div>
            </div>

            <!-- Withdrawal Categories -->
            @if ($withdrawals->contains('withdrawal_type', 'crypto'))
                <div class="withdrawal-category-section">
                    <h2 class="heading-section">Crypto Withdrawals</h2>
                    <div class="withdrawal-grid">
                        @foreach ($withdrawals as $withdrawal)
                            @if ($withdrawal->withdrawal_type === 'crypto')
                                <div class="withdrawal-card-space" data-bs-toggle="modal" 
                                     data-bs-target="#cashoutModal" 
                                     data-id="{{ $withdrawal->id }}"
                                     data-name="{{ $withdrawal->name }}"
                                     data-min="{{ $withdrawal->minimum }}">
                                    <div class="withdrawal-image-container">
                                        <img src="{{ url($withdrawal->cover) }}" alt="{{ $withdrawal->name }}">
                                    </div>
                                    <h4>{{ $withdrawal->name }}</h4>
                                    <p class="withdrawal-min">Min: {{ siteSymbol() }}{{ number_format($withdrawal->minimum, 2) }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($withdrawals->contains('withdrawal_type', 'gift_card'))
                <div class="withdrawal-category-section">
                    <h2 class="heading-section">Gift Cards</h2>
                    <div class="withdrawal-grid">
                        @foreach ($withdrawals as $withdrawal)
                            @if ($withdrawal->withdrawal_type === 'gift_card')
                                <div class="withdrawal-card-space" data-bs-toggle="modal" 
                                     data-bs-target="#cashoutModal" 
                                     data-id="{{ $withdrawal->id }}"
                                     data-name="{{ $withdrawal->name }}"
                                     data-min="{{ $withdrawal->minimum }}">
                                    <div class="withdrawal-image-container" style="background: {{ $withdrawal->bg_color ?: 'linear-gradient(135deg, var(--space-elevated) 0%, var(--space-card) 100%)' }}">
                                        <img src="{{ url($withdrawal->cover) }}" alt="{{ $withdrawal->name }}">
                                    </div>
                                    <h4>{{ $withdrawal->name }}</h4>
                                    <p class="withdrawal-min">Min: {{ siteSymbol() }}{{ number_format($withdrawal->minimum, 2) }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($withdrawals->contains('withdrawal_type', 'cash'))
                <div class="withdrawal-category-section">
                    <h2 class="heading-section">Cash Withdrawals</h2>
                    <div class="withdrawal-grid">
                        @foreach ($withdrawals as $withdrawal)
                            @if ($withdrawal->withdrawal_type === 'cash')
                                <div class="withdrawal-card-space" data-bs-toggle="modal" 
                                     data-bs-target="#cashoutModal" 
                                     data-id="{{ $withdrawal->id }}"
                                     data-name="{{ $withdrawal->name }}"
                                     data-min="{{ $withdrawal->minimum }}">
                                    <div class="withdrawal-image-container">
                                        <img src="{{ url($withdrawal->cover) }}" alt="{{ $withdrawal->name }}">
                                    </div>
                                    <h4>{{ $withdrawal->name }}</h4>
                                    <p class="withdrawal-min">Min: {{ siteSymbol() }}{{ number_format($withdrawal->minimum, 2) }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    @include($activeTemplate . '.partials.modals.cashout')

<style>
.balance-progress-card {
    background: rgba(18, 18, 26, 0.5);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: var(--radius-xl);
    padding: var(--space-xl);
    margin-bottom: var(--space-2xl);
    display: flex;
    gap: var(--space-xl);
    align-items: center;
}

.balance-section {
    display: flex;
    flex-direction: column;
    gap: var(--space-sm);
    padding-right: var(--space-xl);
    border-right: 1px solid rgba(255, 255, 255, 0.1);
    min-width: 200px;
}

.balance-label-lg {
    font-size: 13px;
    color: var(--text-dim);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: 600;
}

.balance-value-lg {
    font-size: 40px;
    font-weight: 800;
    background: linear-gradient(135deg, var(--primary-bright) 0%, var(--primary-glow) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.progress-section {
    flex: 1;
}

.progress-header,
.progress-footer {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: var(--text-gray);
    margin-bottom: var(--space-sm);
}

.progress-bar-space {
    width: 100%;
    height: 12px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: var(--radius-full);
    overflow: hidden;
    position: relative;
}

.progress-fill-space {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-glow) 0%, var(--primary-bright) 100%);
    border-radius: var(--radius-full);
    box-shadow: 0 0 20px rgba(0, 184, 212, 0.5);
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.withdrawal-category-section {
    margin-bottom: var(--space-3xl);
}

.withdrawal-category-section h2 {
    margin-bottom: var(--space-xl);
}

.withdrawal-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: var(--space-lg);
}

.withdrawal-card-space {
    background: rgba(18, 18, 26, 0.5);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: var(--radius-lg);
    padding: var(--space-lg);
    text-align: center;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.withdrawal-card-space:hover {
    transform: translateY(-6px);
    border-color: rgba(0, 184, 212, 0.3);
    box-shadow: 
        var(--shadow-xl),
        0 0 30px rgba(0, 184, 212, 0.15);
}

.withdrawal-image-container {
    width: 100%;
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: var(--space-md);
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--space-elevated);
}

.withdrawal-image-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: brightness(1.1);
}

.withdrawal-card-space h4 {
    font-size: 17px;
    margin-bottom: var(--space-sm);
    color: var(--text-white);
}

.withdrawal-min {
    font-size: 14px;
    color: var(--text-gray);
    margin: 0;
}

@media (max-width: 768px) {
    .balance-progress-card {
        flex-direction: column;
        align-items: stretch;
    }
    
    .balance-section {
        border-right: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-right: 0;
        padding-bottom: var(--space-lg);
        min-width: auto;
    }
    
    .withdrawal-grid {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }
}
</style>
@endsection

