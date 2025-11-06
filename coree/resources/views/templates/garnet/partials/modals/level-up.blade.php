@if(session()->has('level_up'))
    @php
        $levelUp = session('level_up');
        $tierInfo = \App\Services\LevelService::getTierForLevel($levelUp['new_level']);
        $features = \App\Services\LevelService::getUnlockedFeatures($levelUp['new_level']);
    @endphp
    
    <div class="level-up-modal-overlay" id="levelUpModal">
        <div class="level-up-modal">
            <div class="level-up-header">
                <div class="celebration-particles">
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                </div>
                <h2 class="level-up-title">🎉 LEVEL UP! 🎉</h2>
            </div>
            
            <div class="level-up-body">
                <div class="new-rank" style="color: {{ $tierInfo['color'] }};">
                    {{ $tierInfo['icon'] }} {{ $tierInfo['rank_name'] }}
                </div>
                <div class="new-level">Level {{ $levelUp['new_level'] }}</div>
                
                <div class="rewards-section">
                    <div class="rewards-header">🎁 Rewards Unlocked:</div>
                    <div class="rewards-list">
                        <div class="reward-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00B8D4" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            <span>+${{ number_format($levelUp['reward'], 2) }} Cash Bonus</span>
                        </div>
                        
                        @if($levelUp['new_level'] >= 6)
                            @php
                                $freeBoxes = $levelUp['new_level'] >= 21 ? 3 : ($levelUp['new_level'] >= 16 ? 2 : 1);
                                $boxValue = $freeBoxes * 2.00;
                            @endphp
                            <div class="reward-item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FFD700" stroke-width="2">
                                    <rect x="3" y="8" width="18" height="12" rx="2" ry="2"></rect>
                                    <path d="M12 8V3M8 3h8"></path>
                                </svg>
                                <span>+{{ $freeBoxes }} Free Loot Box{{ $freeBoxes > 1 ? 'es' : '' }} ({{ $tierInfo['name'] }} Tier) = ${{ number_format($boxValue, 2) }}</span>
                            </div>
                        @endif
                        
                        @foreach(array_slice($features, -2) as $feature)
                            <div class="reward-item">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00E5FF" stroke-width="2">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                                <span>{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="level-up-footer">
                <button class="btn-level-close" onclick="closeLevelUpModal()">Continue</button>
            </div>
        </div>
    </div>
    
    <style>
    .level-up-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.9);
        backdrop-filter: blur(10px);
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    .level-up-modal {
        background: linear-gradient(135deg, rgba(10, 10, 15, 0.98) 0%, rgba(18, 18, 26, 0.98) 100%);
        border: 2px solid rgba(0, 184, 212, 0.3);
        border-radius: 24px;
        padding: var(--space-xl);
        max-width: 500px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 184, 212, 0.3);
        animation: slideUp 0.5s ease;
        position: relative;
        overflow: hidden;
    }
    
    @keyframes slideUp {
        from {
            transform: translateY(50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .celebration-particles {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
    }
    
    .particle {
        position: absolute;
        width: 8px;
        height: 8px;
        background: #00B8D4;
        border-radius: 50%;
        animation: float-particle 3s ease-in-out infinite;
    }
    
    .particle:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; }
    .particle:nth-child(2) { top: 30%; right: 20%; animation-delay: 0.5s; }
    .particle:nth-child(3) { bottom: 20%; left: 30%; animation-delay: 1s; }
    .particle:nth-child(4) { top: 50%; right: 30%; animation-delay: 1.5s; }
    .particle:nth-child(5) { bottom: 30%; right: 10%; animation-delay: 2s; }
    
    @keyframes float-particle {
        0%, 100% { transform: translateY(0) scale(1); opacity: 0.5; }
        50% { transform: translateY(-20px) scale(1.2); opacity: 1; }
    }
    
    .level-up-header {
        text-align: center;
        margin-bottom: var(--space-xl);
        position: relative;
    }
    
    .level-up-title {
        font-size: 32px;
        font-weight: 800;
        background: linear-gradient(135deg, #00B8D4 0%, #00E5FF 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
        font-family: 'Inter', sans-serif;
    }
    
    .level-up-body {
        text-align: center;
        margin-bottom: var(--space-xl);
    }
    
    .new-rank {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 8px;
        font-family: 'Inter', sans-serif;
        text-shadow: 0 0 20px currentColor;
    }
    
    .new-level {
        font-size: 16px;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: var(--space-xl);
        font-family: 'Inter', sans-serif;
    }
    
    .rewards-section {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
    }
    
    .rewards-header {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-white);
        margin-bottom: var(--space-md);
        font-family: 'Inter', sans-serif;
    }
    
    .rewards-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        text-align: left;
    }
    
    .reward-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
        font-family: 'Inter', sans-serif;
    }
    
    .reward-item svg {
        flex-shrink: 0;
    }
    
    .level-up-footer {
        text-align: center;
    }
    
    .btn-level-close {
        background: linear-gradient(135deg, #00B8D4 0%, #0D47A1 100%);
        color: white;
        padding: 14px 48px;
        border-radius: var(--radius-md);
        font-weight: 700;
        font-size: 16px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 4px 20px rgba(0, 184, 212, 0.4);
    }
    
    .btn-level-close:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 30px rgba(0, 184, 212, 0.6);
    }
    </style>
    
    <script>
    function closeLevelUpModal() {
        document.getElementById('levelUpModal').style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => {
            document.getElementById('levelUpModal').remove();
        }, 300);
    }
    
    // Add fadeOut animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(style);
    </script>
@endif

