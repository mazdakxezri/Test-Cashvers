@extends($activeTemplate . '.layouts.app')
@section('title', 'Leaderboard')

@section('content')
    <div class="cosmic-bg">
        <div class="stars"></div>
        <div class="glow-orb glow-orb-blue" style="top: 10%; right: 5%;"></div>
        <div class="glow-orb glow-orb-purple" style="bottom: 20%; left: 8%;"></div>
    </div>

    <section class="section-space" style="padding-top: var(--space-3xl);">
        <div class="container-space">
            <!-- Leaderboard Header -->
            <div class="section-header-space">
                <h1 class="heading-hero" style="margin-bottom: var(--space-md);">
                    {{ ucfirst($duration) }} <span class="text-gradient-blue">Leaderboard</span>
                </h1>
                <p class="text-body-lg">
                    Prize Pool: <span class="text-gradient-blue" style="font-weight: 700; font-size: 32px;">{{ siteSymbol() }}{{ number_format($totalPrizePool, 2) }}</span>
                </p>
                <p class="section-subtitle">Time Left: {{ $timeLeft }}</p>
            </div>

            <!-- Top 3 Podium -->
            @if ($users->count() >= 3)
                <div class="podium-space">
                    <!-- 2nd Place -->
                    @php $tier2 = \App\Services\LevelService::getTierForLevel($users[1]->level); @endphp
                    <div class="podium-card podium-second">
                        <div class="podium-rank">#2</div>
                        <img src="{{ $users[1]->avatar ?? asset('assets/' . $activeTemplate . '/images/avatars/1.png') }}" 
                             alt="Avatar" class="podium-avatar">
                        <h4>
                            <span style="color: {{ $tier2['color'] }};">{{ $tier2['icon'] }}</span>
                            {{ $users[1]->name }}
                        </h4>
                        <span class="tier-badge-small" style="background: {{ $tier2['color'] }}20; border-color: {{ $tier2['color'] }};">
                            {{ $tier2['rank_name'] }}
                        </span>
                        <p class="podium-earned">{{ siteSymbol() }}{{ number_format($users[1]->total_reward, 2) }}</p>
                        <div class="podium-prize">Prize: {{ siteSymbol() }}{{ number_format($potentialPrizes[$users[1]->uid] ?? 0, 2) }}</div>
                    </div>

                    <!-- 1st Place -->
                    @php $tier1 = \App\Services\LevelService::getTierForLevel($users[0]->level); @endphp
                    <div class="podium-card podium-first">
                        <div class="podium-rank podium-rank-first">#1</div>
                        <img src="{{ $users[0]->avatar ?? asset('assets/' . $activeTemplate . '/images/avatars/1.png') }}" 
                             alt="Avatar" class="podium-avatar podium-avatar-first">
                        <h4>
                            <span style="color: {{ $tier1['color'] }}; font-size: 24px;">{{ $tier1['icon'] }}</span>
                            {{ $users[0]->name }}
                        </h4>
                        <span class="tier-badge-small" style="background: {{ $tier1['color'] }}20; border-color: {{ $tier1['color'] }}; font-weight: 700;">
                            {{ $tier1['rank_name'] }}
                        </span>
                        <p class="podium-earned">{{ siteSymbol() }}{{ number_format($users[0]->total_reward, 2) }}</p>
                        <div class="podium-prize podium-prize-first">Prize: {{ siteSymbol() }}{{ number_format($potentialPrizes[$users[0]->uid] ?? 0, 2) }}</div>
                    </div>

                    <!-- 3rd Place -->
                    @php $tier3 = \App\Services\LevelService::getTierForLevel($users[2]->level); @endphp
                    <div class="podium-card podium-third">
                        <div class="podium-rank">#3</div>
                        <img src="{{ $users[2]->avatar ?? asset('assets/' . $activeTemplate . '/images/avatars/1.png') }}" 
                             alt="Avatar" class="podium-avatar">
                        <h4>
                            <span style="color: {{ $tier3['color'] }};">{{ $tier3['icon'] }}</span>
                            {{ $users[2]->name }}
                        </h4>
                        <span class="tier-badge-small" style="background: {{ $tier3['color'] }}20; border-color: {{ $tier3['color'] }};">
                            {{ $tier3['rank_name'] }}
                        </span>
                        <p class="podium-earned">{{ siteSymbol() }}{{ number_format($users[2]->total_reward, 2) }}</p>
                        <div class="podium-prize">Prize: {{ siteSymbol() }}{{ number_format($potentialPrizes[$users[2]->uid] ?? 0, 2) }}</div>
                    </div>
                </div>
            @endif

            <!-- Full Leaderboard Table -->
            @if ($users->count() > 3)
                <div class="card-float" style="margin-top: var(--space-2xl);">
                    <div class="table-responsive">
                        <table class="table-clean">
                            <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>User</th>
                                    <th>Tier</th>
                                    <th>Earned</th>
                                    <th>Prize</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users->slice(3) as $index => $user)
                                    @php $tierUser = \App\Services\LevelService::getTierForLevel($user->level); @endphp
                                    <tr>
                                        <td><span class="badge-space badge-primary">#{{ $index + 4 }}</span></td>
                                        <td>
                                            <span style="color: {{ $tierUser['color'] }};">{{ $tierUser['icon'] }}</span>
                                            {{ $user->name }}
                                        </td>
                                        <td>
                                            <span class="tier-badge-table" style="background: {{ $tierUser['color'] }}15; color: {{ $tierUser['color'] }}; border-color: {{ $tierUser['color'] }};">
                                                {{ $tierUser['name'] }} {{ $user->level }}
                                            </span>
                                        </td>
                                        <td>{{ siteSymbol() }}{{ number_format($user->total_reward, 2) }}</td>
                                        <td>{{ siteSymbol() }}{{ number_format($potentialPrizes[$user->uid] ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Your Stats -->
            @auth
                <div class="card-float" style="margin-top: var(--space-xl); text-align: center;">
                    <h3>Your Today's Earnings</h3>
                    <div class="stat-value-space" style="margin-top: var(--space-md);">
                        {{ siteSymbol() }}{{ number_format($earnedToday, 2) }}
                    </div>
                </div>
            @endauth
        </div>
    </section>
@endsection

<style>
.tier-badge-small {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    border: 1px solid;
    margin-top: 4px;
    font-family: 'Inter', sans-serif;
}

.tier-badge-table {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 600;
    border: 1px solid;
    font-family: 'Inter', sans-serif;
}
</style>

<style>
.podium-space {
    display: flex;
    justify-content: center;
    align-items: flex-end;
    gap: var(--space-lg);
    margin-bottom: var(--space-2xl);
}

.podium-card {
    background: rgba(18, 18, 26, 0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: var(--radius-xl);
    padding: var(--space-xl) var(--space-lg);
    text-align: center;
    position: relative;
    transition: all 0.4s ease;
}

.podium-first {
    order: 2;
    min-height: 360px;
    border-color: rgba(0, 184, 212, 0.4);
    box-shadow: 0 0 40px rgba(0, 184, 212, 0.2);
}

.podium-second {
    order: 1;
    min-height: 320px;
}

.podium-third {
    order: 3;
    min-height: 280px;
}

.podium-rank {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--space-card);
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: var(--radius-full);
    padding: 6px 16px;
    font-size: 14px;
    font-weight: 700;
    color: var(--text-gray);
}

.podium-rank-first {
    background: var(--primary-glow);
    border-color: var(--primary-bright);
    color: var(--space-black);
    font-size: 16px;
    padding: 8px 20px;
}

.podium-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid rgba(255, 255, 255, 0.2);
    margin: var(--space-md) auto;
}

.podium-avatar-first {
    width: 100px;
    height: 100px;
    border-color: var(--primary-glow);
    box-shadow: 0 0 30px rgba(0, 184, 212, 0.4);
}

.podium-card h4 {
    font-size: 18px;
    margin-bottom: var(--space-sm);
}

.podium-earned {
    font-size: 16px;
    color: var(--text-gray);
    margin-bottom: var(--space-md);
}

.podium-prize {
    background: rgba(0, 0, 0, 0.3);
    border-radius: var(--radius-md);
    padding: var(--space-sm);
    font-size: 15px;
    font-weight: 600;
    color: var(--primary-bright);
}

.podium-prize-first {
    background: rgba(0, 184, 212, 0.15);
    font-size: 17px;
}

@media (max-width: 768px) {
    .podium-space {
        flex-direction: column;
        align-items: stretch;
    }
    
    .podium-first,
    .podium-second,
    .podium-third {
        order: initial;
        min-height: auto;
    }
}
</style>

