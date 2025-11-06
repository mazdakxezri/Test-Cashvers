@inject('levelService', 'App\Services\LevelService')

@php
    $tierInfo = $levelService::getTierForLevel(Auth::user()->level);
    $progress = $levelService::getProgressToNextLevel(Auth::user());
    $features = $levelService::getUnlockedFeatures(Auth::user()->level);
@endphp

<div class="level-progress-widget">
    <div class="tier-card">
        <!-- Current Tier Display -->
        <div class="tier-header">
            <div class="tier-icon" style="color: {{ $tierInfo['color'] }};">
                {{ $tierInfo['icon'] }}
            </div>
            <div class="tier-info">
                <div class="tier-rank">{{ $tierInfo['rank_name'] }}</div>
                <div class="tier-level">Level {{ Auth::user()->level }}</div>
            </div>
            <div class="tier-actions">
                <div class="tier-badge" style="background: linear-gradient(135deg, {{ $tierInfo['color'] }}40, {{ $tierInfo['color'] }}20); border-color: {{ $tierInfo['color'] }};">
                    {{ $tierInfo['name'] }}
                </div>
                <a href="{{ route('tiers.index') }}" class="tier-link">View All Tiers →</a>
            </div>
        </div>
        
        <!-- Progress Bar -->
        @if($progress['next_level'])
            <div class="progress-section">
                <div class="progress-labels">
                    <span class="progress-current">${{ number_format($progress['current_xp'], 2) }} earned</span>
                    <span class="progress-target">${{ number_format($progress['required_xp'], 2) }} to {{ $progress['next_tier']['rank_name'] }}</span>
                </div>
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" style="width: {{ $progress['percentage'] }}%; background: linear-gradient(90deg, {{ $tierInfo['color'] }}, {{ $progress['next_tier']['color'] }});">
                        <span class="progress-percentage">{{ round($progress['percentage']) }}%</span>
                    </div>
                </div>
            </div>
        @else
            <div class="progress-section">
                <div class="max-level-badge">
                    🏆 MAX LEVEL REACHED 🏆
                </div>
            </div>
        @endif
        
        <!-- Unlocked Features - Compact -->
        <div class="features-section">
            <div class="features-compact">
                <span class="features-label">🔓 Perks:</span>
                <span class="features-count">{{ count($features) }} unlocked</span>
            </div>
        </div>
    </div>
</div>

<style>
.level-progress-widget {
    margin-bottom: var(--space-md);
}

.tier-card {
    background: linear-gradient(135deg, rgba(0, 184, 212, 0.05) 0%, rgba(13, 71, 161, 0.05) 100%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-md);
    padding: 16px 20px;
    backdrop-filter: blur(10px);
}

.tier-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}

.tier-icon {
    font-size: 24px;
    line-height: 1;
}

.tier-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.tier-info {
    flex: 1;
}

.tier-rank {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-white);
    font-family: 'Inter', sans-serif;
}

.tier-level {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.6);
    font-family: 'Inter', sans-serif;
}

.tier-badge {
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 11px;
    font-weight: 600;
    border: 1px solid;
    font-family: 'Inter', sans-serif;
}

.tier-link {
    font-size: 11px;
    color: #00B8D4;
    text-decoration: none;
    font-weight: 500;
    font-family: 'Inter', sans-serif;
    white-space: nowrap;
}

.tier-link:hover {
    color: #00E5FF;
    text-decoration: underline;
}

.progress-section {
    margin-bottom: var(--space-md);
}

.progress-labels {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 11px;
    font-family: 'Inter', sans-serif;
}

.progress-current {
    color: rgba(255, 255, 255, 0.7);
}

.progress-target {
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
}

.progress-bar-container {
    height: 20px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 10px;
    overflow: hidden;
    position: relative;
}

.progress-bar-fill {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: width 0.6s ease;
    position: relative;
}

.progress-bar-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.progress-percentage {
    font-size: 11px;
    font-weight: 700;
    color: white;
    position: relative;
    z-index: 2;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
}

.max-level-badge {
    text-align: center;
    padding: var(--space-md);
    font-size: 14px;
    font-weight: 700;
    color: #FFD700;
    font-family: 'Inter', sans-serif;
}

.features-section {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    padding-top: 10px;
}

.features-compact {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.features-label {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.7);
    font-family: 'Inter', sans-serif;
}

.features-count {
    font-size: 11px;
    font-weight: 600;
    color: #00B8D4;
    font-family: 'Inter', sans-serif;
}

@media (max-width: 768px) {
    .tier-icon {
        font-size: 24px;
    }
    
    .tier-rank {
        font-size: 14px;
    }
    
    .tier-card {
        padding: var(--space-md);
    }
}
</style>

