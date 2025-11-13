@inject('bonusService', 'App\Services\DailyLoginBonusService')

@php
    try {
        $canClaim = $bonusService->canClaimToday(Auth::user());
        $streak = $bonusService->getCurrentStreak(Auth::user());
        $totalEarned = $bonusService->getTotalBonuses(Auth::user());
        $nextBonusIn = $bonusService->getTimeUntilNextBonus();
        $bonusEnabled = true;
    } catch (\Exception $e) {
        // Table doesn't exist yet - migrations not run
        $bonusEnabled = false;
    }
@endphp

@if($bonusEnabled)

<div class="daily-bonus-widget">
    <div class="bonus-card">
        <div class="bonus-icon">
            @if($canClaim)
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="#00B8D4" stroke="#00B8D4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            @else
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="#00B8D4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            @endif
        </div>
        
        <div class="bonus-content">
            <h4 class="bonus-title">Daily Login Bonus</h4>
            
            @if($canClaim)
                <p class="bonus-status bonus-available">
                    <span class="bonus-pulse"></span>
                    Ready to claim!
                </p>
                <div class="bonus-amount">
                    <span class="bonus-currency">$</span>{{ number_format(\App\Services\DailyLoginBonusService::DAILY_BONUS, 2) }}
                </div>
                <button onclick="claimDailyBonus()" class="btn-claim-bonus">
                    Claim Now
                </button>
            @else
                <p class="bonus-status bonus-claimed">
                    ✓ Claimed Today
                </p>
                <div class="bonus-next">
                    Next bonus in: <strong>{{ $nextBonusIn }}</strong>
                </div>
            @endif
        </div>
        
        <div class="bonus-stats">
            <div class="bonus-stat">
                <div class="stat-label">Current Streak</div>
                <div class="stat-value">🔥 {{ $streak }} days</div>
            </div>
            <div class="bonus-stat">
                <div class="stat-label">Total Earned</div>
                <div class="stat-value">${{ number_format($totalEarned, 2) }}</div>
            </div>
        </div>
    </div>
</div>

<style>
.daily-bonus-widget {
    margin-bottom: var(--space-md);
    max-width: 900px;
}

.bonus-card {
    background: linear-gradient(135deg, rgba(0, 184, 212, 0.08) 0%, rgba(13, 71, 161, 0.08) 100%);
    border: 1px solid rgba(0, 184, 212, 0.25);
    border-radius: var(--radius-md);
    padding: 16px 20px;
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 12px;
    align-items: center;
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.bonus-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 50%, rgba(0, 184, 212, 0.15) 0%, transparent 50%);
    pointer-events: none;
}

.bonus-icon {
    position: relative;
    z-index: 2;
}

.bonus-icon svg {
    width: 24px;
    height: 24px;
    animation: bonusFloat 3s ease-in-out infinite;
}

@keyframes bonusFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.bonus-content {
    position: relative;
    z-index: 2;
}

.bonus-title {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-white);
    margin-bottom: 0;
    font-family: 'Inter', sans-serif;
}

.bonus-status {
    font-size: 12px;
    font-weight: 500;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    font-family: 'Inter', sans-serif;
}

.bonus-available {
    color: #00E5FF;
}

.bonus-claimed {
    color: rgba(255, 255, 255, 0.6);
}

.bonus-pulse {
    width: 8px;
    height: 8px;
    background: #00E5FF;
    border-radius: 50%;
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.3); }
}

.bonus-amount {
    font-size: 18px;
    font-weight: 700;
    background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 4px;
    font-family: 'Inter', sans-serif;
}

.bonus-currency {
    font-size: 14px;
}

.btn-claim-bonus {
    background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
    color: white;
    padding: 6px 16px;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 2px 8px rgba(0, 184, 212, 0.2);
}

.btn-claim-bonus:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 184, 212, 0.5);
}

.bonus-next {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.7);
    font-family: 'Inter', sans-serif;
}

.bonus-next strong {
    color: #00B8D4;
}

.bonus-stats {
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
    position: relative;
    z-index: 2;
}

.bonus-stat {
    text-align: right;
}

.stat-label {
    font-size: 10px;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.5);
    margin-bottom: 2px;
    font-weight: 500;
    letter-spacing: 0.05em;
    font-family: 'Inter', sans-serif;
}

.stat-value {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-white);
    font-family: 'Inter', sans-serif;
}

@media (max-width: 768px) {
    .daily-bonus-widget {
        margin-bottom: var(--space-md);
    }
    
    .bonus-card {
        grid-template-columns: 1fr;
        text-align: center;
        gap: var(--space-sm);
        padding: var(--space-md) !important;
    }
    
    .bonus-icon {
        margin: 0 auto;
    }
    
    .bonus-icon svg {
        width: 32px !important;
        height: 32px !important;
    }
    
    .bonus-title {
        font-size: 16px !important;
        margin-bottom: 4px !important;
    }
    
    .bonus-amount {
        font-size: 24px !important;
        margin-bottom: var(--space-sm) !important;
    }
    
    .bonus-currency {
        font-size: 18px !important;
    }
    
    .btn-claim-bonus {
        padding: 10px 24px !important;
        font-size: 14px !important;
    }
    
    .bonus-stats {
        flex-direction: row;
        justify-content: space-around;
        gap: var(--space-sm);
    }
    
    .bonus-stat {
        text-align: center;
    }
    
    .stat-value {
        font-size: 14px !important;
    }
}
</style>

<script>
function claimDailyBonus() {
    // Claiming daily bonus...
    
    fetch('{{ route('bonus.claim') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        // Response status: response.status
        return response.json();
    })
    .then(data => {
        // Response data processed
        if (data.success) {
            // Show success notification
            showBonusNotification(data.amount, data.streak);
            // Reload page to update UI
            setTimeout(() => location.reload(), 2000);
        } else {
            alert(data.message || 'Failed to claim bonus');
        }
    })
    .catch(error => {
        console.error('Error claiming bonus:', error);
        alert('Error claiming bonus. Please check console.');
    });
}

function showBonusNotification(amount, streak) {
    // Create notification element
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
        color: white;
        padding: 24px 32px;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0, 184, 212, 0.4);
        z-index: 999999;
        font-family: 'Inter', sans-serif;
        animation: slideIn 0.5s ease;
    `;
    notification.innerHTML = `
        <div style="font-size: 18px; font-weight: 700; margin-bottom: 8px;">
            🎉 Daily Bonus Claimed!
        </div>
        <div style="font-size: 24px; font-weight: 800;">
            +$${amount.toFixed(2)}
        </div>
        <div style="font-size: 14px; opacity: 0.9; margin-top: 8px;">
            🔥 ${streak} day streak!
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.5s ease';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

// Add animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endif

