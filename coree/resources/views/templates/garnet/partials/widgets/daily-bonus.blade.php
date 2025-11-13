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

<div class="daily-bonus-compact">
    <div class="bonus-mini">
        <div class="bonus-icon-mini">
            @if($canClaim)
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="#FFB300" stroke="#FFB300" stroke-width="2"/>
                </svg>
            @else
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" stroke="rgba(255, 255, 255, 0.4)" stroke-width="2"/>
                </svg>
            @endif
        </div>
        
        <div class="bonus-details-mini">
            <span class="bonus-title-mini">Daily Bonus</span>
            <span class="bonus-streak-mini">🔥 {{ $streak }} day streak</span>
        </div>
        
        @if($canClaim)
            <button onclick="claimDailyBonus()" class="btn-claim-mini">
                Claim ${{ number_format(\App\Services\DailyLoginBonusService::DAILY_BONUS, 2) }}
            </button>
        @else
            <div class="bonus-claimed-mini">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#00C853" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span>Claimed</span>
            </div>
        @endif
    </div>
</div>

<style>
.daily-bonus-compact {
    margin-bottom: 8px;
}

.bonus-mini {
    background: linear-gradient(135deg, rgba(255, 179, 0, 0.08) 0%, rgba(255, 152, 0, 0.08) 100%);
    border: 1px solid rgba(255, 179, 0, 0.2);
    border-radius: 8px;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
}

.bonus-mini:hover {
    border-color: rgba(255, 179, 0, 0.4);
    background: linear-gradient(135deg, rgba(255, 179, 0, 0.12) 0%, rgba(255, 152, 0, 0.12) 100%);
}

.bonus-icon-mini {
    flex-shrink: 0;
    line-height: 1;
}

.bonus-details-mini {
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex-shrink: 0;
}

.bonus-title-mini {
    font-size: 13px;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.95);
    font-family: 'Inter', sans-serif;
    line-height: 1;
}

.bonus-streak-mini {
    font-size: 10px;
    color: rgba(255, 255, 255, 0.5);
    font-family: 'Inter', sans-serif;
    line-height: 1;
}

.btn-claim-mini {
    background: linear-gradient(135deg, #FFB300 0%, #FF9800 100%);
    color: #000000;
    padding: 6px 14px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: 'Inter', sans-serif;
    white-space: nowrap;
    margin-left: auto;
}

.btn-claim-mini:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 179, 0, 0.4);
}

.bonus-claimed-mini {
    display: flex;
    align-items: center;
    gap: 4px;
    color: #00C853;
    font-size: 12px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    margin-left: auto;
    padding: 4px 10px;
    background: rgba(0, 200, 83, 0.1);
    border-radius: 6px;
}

@media (max-width: 768px) {
    .bonus-mini {
        padding: 8px 10px;
        gap: 8px;
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

