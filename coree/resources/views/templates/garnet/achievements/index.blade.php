@extends($activeTemplate . '.layouts.app')
@section('title', 'Achievements')

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
                    🏆 <span class="text-gradient-blue">Achievements</span>
                </h1>
                <p class="section-subtitle">Unlock rewards by completing challenges and milestones!</p>
            </div>

            <!-- Stats Overview -->
            <div class="achievement-stats-grid">
                <div class="achievement-stat-card">
                    <div class="stat-icon">🎯</div>
                    <div class="stat-info">
                        <h3>{{ $stats['unlocked'] }}</h3>
                        <p>Unlocked</p>
                    </div>
                </div>
                <div class="achievement-stat-card">
                    <div class="stat-icon">🔒</div>
                    <div class="stat-info">
                        <h3>{{ $stats['locked'] }}</h3>
                        <p>Locked</p>
                    </div>
                </div>
                <div class="achievement-stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-info">
                        <h3>{{ $stats['completion_percentage'] }}%</h3>
                        <p>Completion</p>
                    </div>
                </div>
                <div class="achievement-stat-card">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-info">
                        <h3>{{ number_format($stats['total_points']) }}</h3>
                        <p>Points</p>
                    </div>
                </div>
            </div>

            <!-- Achievements by Category -->
            @foreach($achievementsByCategory as $category => $achievements)
                <div class="card-float" style="margin-top: var(--space-2xl);">
                    <h2 class="achievement-category-title">
                        @if($category === 'earning')
                            💰 Earning Achievements
                        @elseif($category === 'milestone')
                            🎯 Milestones
                        @elseif($category === 'social')
                            👥 Social Achievements
                        @else
                            ⭐ Special Achievements
                        @endif
                    </h2>

                    <div class="achievements-grid">
                        @foreach($achievements as $item)
                            @php
                                $achievement = $item['achievement'];
                                $userData = $item['user_data'];
                                $isUnlocked = $userData && $userData->is_unlocked;
                                $isClaimed = $userData && $userData->is_claimed;
                                $progress = $item['progress_percentage'];
                            @endphp

                            <div class="achievement-card {{ $isUnlocked ? 'unlocked' : 'locked' }}" 
                                 data-tier="{{ $achievement->tier }}">
                                <div class="achievement-tier-badge" style="background: {{ $achievement->tier_color }}20; color: {{ $achievement->tier_color }};">
                                    {{ $achievement->tier_icon }} {{ ucfirst($achievement->tier) }}
                                </div>

                                <div class="achievement-icon">
                                    {{ $achievement->icon }}
                                </div>

                                <h4 class="achievement-name">{{ $achievement->name }}</h4>
                                <p class="achievement-description">{{ $achievement->description }}</p>

                                <!-- Progress Bar -->
                                @if (!$isUnlocked && $userData)
                                    <div class="achievement-progress">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar-fill" style="width: {{ $progress }}%;"></div>
                                        </div>
                                        <p class="progress-text">
                                            {{ $userData->progress }} / {{ $achievement->requirements['count'] ?? 1 }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Rewards -->
                                <div class="achievement-rewards">
                                    @if($achievement->points > 0)
                                        <span class="reward-badge">⭐ {{ $achievement->points }} pts</span>
                                    @endif
                                    @if($achievement->reward_amount > 0)
                                        <span class="reward-badge">{{ siteSymbol() }}{{ number_format($achievement->reward_amount, 2) }}</span>
                                    @endif
                                </div>

                                <!-- Status -->
                                @if($isUnlocked)
                                    @if($isClaimed)
                                        <div class="achievement-status claimed">
                                            ✅ Claimed
                                        </div>
                                    @else
                                        <form action="{{ route('achievements.claim') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_achievement_id" value="{{ $userData->id }}">
                                            <button type="submit" class="btn-space btn-primary-space" style="width: 100%;">
                                                🎁 Claim Reward
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <div class="achievement-status locked-status">
                                        🔒 Locked
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            @if(count($achievementsByCategory) === 0)
                <div class="card-float text-center" style="padding: var(--space-3xl); margin-top: var(--space-2xl);">
                    <div style="font-size: 64px; margin-bottom: var(--space-md); opacity: 0.3;">🏆</div>
                    <h3 style="color: rgba(255, 255, 255, 0.7); margin-bottom: var(--space-sm);">No Achievements Yet</h3>
                    <p style="color: rgba(255, 255, 255, 0.5);">Achievements will appear here once they're added by admin.</p>
                </div>
            @endif
        </div>
    </section>
@endsection

<style>
.achievement-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-lg);
    margin-top: var(--space-2xl);
}

.achievement-stat-card {
    background: linear-gradient(145deg, rgba(15, 15, 25, 0.8), rgba(20, 20, 30, 0.9));
    border: 1px solid rgba(0, 184, 212, 0.2);
    border-radius: 16px;
    padding: var(--space-lg);
    display: flex;
    align-items: center;
    gap: var(--space-md);
    transition: all 0.3s ease;
}

.achievement-stat-card:hover {
    border-color: #00B8D4;
    transform: translateY(-2px);
}

.stat-icon {
    font-size: 48px;
}

.stat-info h3 {
    font-size: 32px;
    font-weight: 700;
    color: #00B8D4;
    margin: 0;
}

.stat-info p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
}

.achievement-category-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: var(--space-xl);
    color: #fff;
}

.achievements-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--space-lg);
}

.achievement-card {
    background: linear-gradient(145deg, rgba(15, 15, 25, 0.8), rgba(20, 20, 30, 0.9));
    border: 2px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: var(--space-lg);
    position: relative;
    transition: all 0.3s ease;
    text-align: center;
}

.achievement-card.unlocked {
    border-color: rgba(0, 184, 212, 0.5);
    background: linear-gradient(145deg, rgba(0, 184, 212, 0.05), rgba(0, 129, 167, 0.05));
}

.achievement-card.unlocked:hover {
    border-color: #00B8D4;
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 184, 212, 0.3);
}

.achievement-card.locked {
    opacity: 0.7;
}

.achievement-tier-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.achievement-icon {
    font-size: 64px;
    margin: var(--space-md) 0;
    filter: grayscale(100%);
}

.achievement-card.unlocked .achievement-icon {
    filter: grayscale(0);
    animation: bounce 1s ease-in-out;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}

.achievement-name {
    font-size: 18px;
    font-weight: 700;
    color: #fff;
    margin-bottom: var(--space-sm);
}

.achievement-description {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.6);
    margin-bottom: var(--space-md);
    min-height: 36px;
}

.achievement-progress {
    margin: var(--space-md) 0;
}

.progress-bar-container {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 4px;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #00B8D4, #0081A7);
    border-radius: 4px;
    transition: width 0.3s ease;
}

.progress-text {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    margin: 0;
}

.achievement-rewards {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin: var(--space-md) 0;
    flex-wrap: wrap;
}

.reward-badge {
    padding: 4px 12px;
    background: rgba(255, 215, 0, 0.1);
    border: 1px solid rgba(255, 215, 0, 0.3);
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    color: #FFD700;
}

.achievement-status {
    padding: 10px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    margin-top: var(--space-md);
}

.achievement-status.claimed {
    background: rgba(76, 175, 80, 0.1);
    border: 1px solid rgba(76, 175, 80, 0.3);
    color: #4CAF50;
}

.achievement-status.locked-status {
    background: rgba(158, 158, 158, 0.1);
    border: 1px solid rgba(158, 158, 158, 0.3);
    color: rgba(255, 255, 255, 0.5);
}

@media (max-width: 768px) {
    .achievement-stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-md);
    }
    
    .achievements-grid {
        grid-template-columns: 1fr;
        gap: var(--space-md);
    }
    
    .stat-icon {
        font-size: 36px;
    }
    
    .stat-info h3 {
        font-size: 24px;
    }
}
</style>
@endsection

