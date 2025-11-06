@extends($activeTemplate . '.layouts.app')
@section('title', 'Tier System')

@section('content')
    <div class="cosmic-bg">
        <div class="stars"></div>
        <div class="glow-orb glow-orb-blue" style="top: 10%; right: 5%;"></div>
        <div class="glow-orb glow-orb-purple" style="bottom: 30%; left: 10%;"></div>
    </div>

    <section class="section-space">
        <div class="container-space">
            <!-- Page Header -->
            <div class="section-header-space" style="margin-bottom: var(--space-xl);">
                <h1 class="heading-section">Tier System</h1>
                <p class="section-subtitle">Climb the ranks and unlock exclusive rewards</p>
            </div>
            
            <!-- Current Progress Summary -->
            <div class="current-tier-card">
                <div class="current-tier-header">
                    <div class="tier-icon-large" style="color: {{ $currentTier['color'] }};">{{ $currentTier['icon'] }}</div>
                    <div>
                        <h2 style="color: {{ $currentTier['color'] }}; margin: 0; font-size: 24px;">{{ $currentTier['rank_name'] }}</h2>
                        <p style="margin: 4px 0 0; color: rgba(255, 255, 255, 0.7); font-size: 14px;">You are in the {{ $currentTier['name'] }} Tier</p>
                    </div>
                </div>
                
                @if($progress['next_level'])
                    <div style="margin-top: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 12px;">
                            <span style="color: rgba(255, 255, 255, 0.7);">${{ number_format($progress['current_xp'], 2) }} earned</span>
                            <span style="color: rgba(255, 255, 255, 0.9); font-weight: 600;">${{ number_format($progress['required_xp'], 2) }} to {{ $progress['next_tier']['rank_name'] }}</span>
                        </div>
                        <div style="height: 28px; background: rgba(0, 0, 0, 0.3); border-radius: 14px; overflow: hidden; position: relative;">
                            <div style="height: 100%; background: linear-gradient(90deg, {{ $currentTier['color'] }}, {{ $progress['next_tier']['color'] }}); width: {{ $progress['percentage'] }}%; display: flex; align-items: center; justify-content: center;">
                                <span style="font-size: 12px; font-weight: 700; color: white; z-index: 2;">{{ round($progress['percentage']) }}%</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- All Tiers -->
            <div class="tiers-grid">
                @foreach($allTiers as $tierKey => $tier)
                    @php
                        $isUnlocked = Auth::user()->level >= $tier['levels'][0];
                        $isCurrent = in_array(Auth::user()->level, $tier['levels']);
                    @endphp
                    
                    <div class="tier-detail-card {{ $isCurrent ? 'current-tier-highlight' : '' }} {{ !$isUnlocked ? 'locked-tier' : '' }}" style="border-color: {{ $tier['color'] }}40;">
                        <div class="tier-detail-header" style="border-bottom-color: {{ $tier['color'] }}20;">
                            <div class="tier-detail-icon" style="color: {{ $tier['color'] }};">{{ $tier['icon'] }}</div>
                            <div>
                                <h3 style="color: {{ $tier['color'] }}; margin: 0; font-size: 20px; font-weight: 700;">{{ $tier['name'] }} Tier</h3>
                                <p style="margin: 0; color: rgba(255, 255, 255, 0.6); font-size: 12px;">Levels {{ $tier['levels'][0] }}-{{ $tier['levels'][count($tier['levels']) - 1] }}</p>
                            </div>
                            @if($isCurrent)
                                <span class="current-badge">Current</span>
                            @elseif(!$isUnlocked)
                                <span class="locked-badge">🔒 Locked</span>
                            @endif
                        </div>
                        
                        <div class="tier-detail-body">
                            <div class="ranks-list">
                                <strong style="font-size: 12px; color: rgba(255, 255, 255, 0.7);">Ranks in this tier:</strong>
                                @foreach($tier['ranks'] as $level => $rankName)
                                    <div class="rank-item {{ Auth::user()->level == $level ? 'current-rank' : '' }}">
                                        <span class="rank-level" style="color: {{ $tier['color'] }};">{{ $level }}</span>
                                        <span class="rank-name">{{ $rankName }}</span>
                                        @if(Auth::user()->level == $level)
                                            <span class="you-badge">YOU</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="tier-perks">
                                <strong style="font-size: 12px; color: rgba(255, 255, 255, 0.7); margin-bottom: 8px; display: block;">Unlocked Perks:</strong>
                                @php
                                    $features = \App\Services\LevelService::getUnlockedFeatures($tier['levels'][0]);
                                @endphp
                                @foreach($features as $feature)
                                    <div class="perk-item">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="{{ $tier['color'] }}" stroke-width="3">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        {{ $feature }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
.current-tier-card {
    background: linear-gradient(135deg, rgba(0, 184, 212, 0.1) 0%, rgba(13, 71, 161, 0.1) 100%);
    border: 2px solid rgba(0, 184, 212, 0.3);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
    margin-bottom: var(--space-xl);
}

.current-tier-header {
    display: flex;
    align-items: center;
    gap: var(--space-lg);
}

.tier-icon-large {
    font-size: 48px;
    line-height: 1;
}

.tiers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: var(--space-lg);
}

.tier-detail-card {
    background: rgba(18, 18, 26, 0.8);
    border: 2px solid;
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: all 0.3s ease;
}

.tier-detail-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
}

.current-tier-highlight {
    box-shadow: 0 0 30px rgba(0, 184, 212, 0.3);
}

.locked-tier {
    opacity: 0.5;
}

.tier-detail-header {
    padding: var(--space-lg);
    border-bottom: 1px solid;
    display: flex;
    align-items: center;
    gap: var(--space-md);
}

.tier-detail-icon {
    font-size: 36px;
    line-height: 1;
}

.current-badge {
    margin-left: auto;
    padding: 4px 12px;
    background: rgba(0, 184, 212, 0.2);
    border: 1px solid #00B8D4;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    color: #00B8D4;
}

.locked-badge {
    margin-left: auto;
    padding: 4px 12px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.5);
}

.tier-detail-body {
    padding: var(--space-lg);
    display: flex;
    flex-direction: column;
    gap: var(--space-lg);
}

.ranks-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.rank-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 12px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    font-size: 13px;
}

.current-rank {
    background: rgba(0, 184, 212, 0.15);
    border: 1px solid rgba(0, 184, 212, 0.3);
}

.rank-level {
    font-weight: 700;
    width: 24px;
}

.rank-name {
    flex: 1;
    color: rgba(255, 255, 255, 0.9);
}

.you-badge {
    padding: 2px 8px;
    background: #00B8D4;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 700;
    color: white;
}

.tier-perks {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.perk-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: rgba(255, 255, 255, 0.9);
}

@media (max-width: 768px) {
    .tiers-grid {
        grid-template-columns: 1fr;
    }
    
    .tier-icon-large {
        font-size: 36px;
    }
}
</style>
@endsection

