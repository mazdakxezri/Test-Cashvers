@extends($activeTemplate . '.layouts.app')
@section('title', 'Crypto Deposit')

@section('content')
<div class="cosmic-bg">
    <div class="stars"></div>
    <div class="glow-orb glow-orb-blue" style="top: 15%; right: 8%;"></div>
</div>

<section class="section-space" style="padding-top: var(--space-3xl);">
    <div class="container-space">
        <div class="section-header-inline">
            <h2 class="heading-section" style="margin: 0;">💰 Deposit Crypto</h2>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card-float">
                    <h4 style="margin-bottom: var(--space-lg);">Deposit Funds</h4>
                    
                    <form action="{{ route('crypto.deposit.create') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label-space">Amount (USD)</label>
                            <input type="number" 
                                   name="amount" 
                                   class="form-input-space" 
                                   placeholder="Enter amount"
                                   min="1"
                                   max="10000"
                                   step="0.01"
                                   required>
                            <small class="text-muted">Minimum: $1.00 | Maximum: $10,000.00</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label-space">Currency</label>
                            <div class="crypto-currency-grid">
                                @foreach($currencies as $curr)
                                <label class="crypto-option">
                                    <input type="radio" name="currency" value="{{ $curr }}" required>
                                    <div class="crypto-option-content">
                                        <span class="crypto-symbol">{{ $curr }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn-space-primary w-100">
                            Continue to Payment
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-float">
                    <h4 style="margin-bottom: var(--space-lg);">📊 Recent Deposits</h4>
                    
                    @forelse($transactions as $tx)
                    <div class="transaction-item">
                        <div class="transaction-info">
                            <div class="transaction-currency">{{ $tx->currency }}</div>
                            <div class="transaction-details">
                                <div class="transaction-amount">{{ $tx->amount_crypto }} {{ $tx->currency }}</div>
                                <div class="transaction-date">{{ $tx->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="transaction-status">
                            @if($tx->status === 'completed')
                                <span class="badge-success">✓ Completed</span>
                            @elseif($tx->status === 'confirming' || $tx->status === 'confirmed')
                                <span class="badge-warning">⏳ Confirming</span>
                            @elseif($tx->status === 'waiting')
                                <span class="badge-info">⏰ Waiting</span>
                            @else
                                <span class="badge-danger">✗ {{ ucfirst($tx->status) }}</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center py-4">No deposits yet</p>
                    @endforelse

                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.crypto-currency-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.crypto-option {
    cursor: pointer;
}

.crypto-option input {
    display: none;
}

.crypto-option-content {
    background: rgba(18, 18, 26, 0.5);
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    transition: all 0.3s ease;
}

.crypto-option input:checked + .crypto-option-content {
    border-color: #00B8D4;
    background: rgba(0, 184, 212, 0.1);
}

.crypto-option-content:hover {
    border-color: rgba(0, 184, 212, 0.5);
}

.crypto-symbol {
    font-size: 20px;
    font-weight: 700;
    color: white;
}

.transaction-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    background: rgba(18, 18, 26, 0.3);
    border-radius: 12px;
    margin-bottom: 12px;
}

.transaction-info {
    display: flex;
    gap: 16px;
    align-items: center;
}

.transaction-currency {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
}

.transaction-amount {
    font-size: 16px;
    font-weight: 600;
    color: white;
}

.transaction-date {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.6);
}

.badge-success { background: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; }
.badge-warning { background: #f59e0b; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; }
.badge-info { background: #3b82f6; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; }
.badge-danger { background: #ef4444; color: white; padding: 6px 12px; border-radius: 6px; font-size: 12px; }
</style>
@endsection

