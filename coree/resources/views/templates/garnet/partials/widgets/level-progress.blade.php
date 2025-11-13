@inject('levelService', 'App\Services\LevelService')

@php
    $tierInfo = $levelService::getTierForLevel(Auth::user()->level);
    $progress = $levelService::getProgressToNextLevel(Auth::user());
    $features = $levelService::getUnlockedFeatures(Auth::user()->level);
@endphp

<div class="level-progress-compact">
    <div class="tier-mini">
        <span class="tier-icon-mini" style="color: {{ $tierInfo['color'] }};">{{ $tierInfo['icon'] }}</span>
        <div class="tier-details-mini">
            <span class="tier-name-mini">{{ $tierInfo['rank_name'] }}</span>
            <span class="tier-level-mini">Lvl {{ Auth::user()->level }}</span>
        </div>
        @if($progress['next_level'])
            <div class="progress-mini">
                <div class="progress-bar-mini" style="width: {{ $progress['percentage'] }}%; background: {{ $tierInfo['color'] }};"></div>
            </div>
            <span class="progress-text-mini">{{ round($progress['percentage']) }}%</span>
        @else
            <span class="max-badge-mini">🏆 MAX</span>
        @endif
        <a href="{{ route('tiers.index') }}" class="tier-link-mini">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </a>
    </div>
</div>

<style>
.level-progress-compact {
    margin-bottom: 8px;
}

.tier-mini {
    background: linear-gradient(135deg, rgba(0, 184, 212, 0.08) 0%, rgba(13, 71, 161, 0.08) 100%);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    padding: 8px 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    backdrop-filter: blur(10px);
    transition: all 0.2s ease;
}

.tier-mini:hover {
    border-color: rgba(0, 184, 212, 0.3);
    background: linear-gradient(135deg, rgba(0, 184, 212, 0.12) 0%, rgba(13, 71, 161, 0.12) 100%);
}

.tier-icon-mini {
    font-size: 18px;
    line-height: 1;
    flex-shrink: 0;
}

.tier-details-mini {
    display: flex;
    flex-direction: column;
    gap: 2px;
    flex-shrink: 0;
}

.tier-name-mini {
    font-size: 13px;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.95);
    font-family: 'Inter', sans-serif;
    line-height: 1;
}

.tier-level-mini {
    font-size: 10px;
    color: rgba(255, 255, 255, 0.5);
    font-family: 'Inter', sans-serif;
    line-height: 1;
}

.progress-mini {
    flex: 1;
    height: 6px;
    background: rgba(0, 0, 0, 0.3);
    border-radius: 3px;
    overflow: hidden;
    position: relative;
    min-width: 80px;
}

.progress-bar-mini {
    height: 100%;
    transition: width 0.6s ease;
    border-radius: 3px;
}

.progress-text-mini {
    font-size: 11px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.7);
    font-family: 'Inter', sans-serif;
    flex-shrink: 0;
    min-width: 35px;
    text-align: right;
}

.max-badge-mini {
    font-size: 11px;
    font-weight: 700;
    color: #FFD700;
    font-family: 'Inter', sans-serif;
    padding: 2px 8px;
    background: rgba(255, 215, 0, 0.1);
    border-radius: 4px;
}

.tier-link-mini {
    color: rgba(255, 255, 255, 0.4);
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.tier-link-mini:hover {
    color: #00B8D4;
}

@media (max-width: 768px) {
    .tier-mini {
        padding: 8px 10px;
        gap: 8px;
    }
    
    .tier-icon-mini {
        font-size: 16px;
    }
    
    .tier-name-mini {
        font-size: 12px;
    }
    
    .progress-mini {
        min-width: 60px;
    }
}
</style>

