@extends($activeTemplate . '.layouts.app')
@section('title', 'Surveys')

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
                    📋 Available <span class="text-gradient-blue">Surveys</span>
                </h1>
                <p class="section-subtitle">Share your opinion and earn rewards!</p>
            </div>

            <!-- User Stats -->
            @if(isset($userStats) && $userStats)
                <div class="card-float" style="margin-bottom: var(--space-xl);">
                    <div class="surveys-stats-grid">
                        <div class="stat-item">
                            <div class="stat-icon">✅</div>
                            <div class="stat-info">
                                <h3>{{ $userStats['completed'] ?? 0 }}</h3>
                                <p>Completed</p>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">💰</div>
                            <div class="stat-info">
                                <h3>{{ siteSymbol() }}{{ number_format($userStats['earnings'] ?? 0, 2) }}</h3>
                                <p>Earned</p>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">⭐</div>
                            <div class="stat-info">
                                <h3>{{ $userStats['rating'] ?? 'N/A' }}</h3>
                                <p>Quality Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Surveys Grid -->
            @if(count($surveys) > 0)
                <div class="surveys-grid">
                    @foreach($surveys as $survey)
                        <div class="survey-card">
                            <div class="survey-header">
                                <div class="survey-badge">
                                    @if(($survey['loi'] ?? 0) <= 5)
                                        <span class="badge-duration short">⚡ Quick</span>
                                    @elseif(($survey['loi'] ?? 0) <= 15)
                                        <span class="badge-duration medium">⏱️ Medium</span>
                                    @else
                                        <span class="badge-duration long">🕐 Long</span>
                                    @endif
                                </div>
                                <div class="survey-payout">
                                    @php
                                        // BitLabs returns value in cents, convert to dollars
                                        $valueInCents = $survey['value'] ?? 0;
                                        $payout = $valueInCents / 100;
                                        $formattedPayout = number_format($payout, 2);
                                        [$integerPart, $decimalPart] = explode('.', $formattedPayout);
                                    @endphp
                                    <span class="payout-integer">{{ $integerPart }}</span>.<span class="payout-decimal">{{ $decimalPart }}</span>
                                    <span class="payout-symbol">{{ siteSymbol() }}</span>
                                </div>
                            </div>

                            <div class="survey-body">
                                <h4 class="survey-title">
                                    {{ $survey['category']['name'] ?? 'Survey' }}
                                </h4>
                                <div class="survey-details">
                                    <div class="detail-item">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                        <span>{{ $survey['loi'] ?? 0 }} min</span>
                                    </div>
                                    @if(isset($survey['cr']))
                                        <div class="detail-item">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                            </svg>
                                            <span>{{ round($survey['cr'] * 100) }}% CR</span>
                                        </div>
                                    @endif
                                    @if(isset($survey['rating']))
                                        <div class="detail-item">
                                            ⭐ {{ $survey['rating'] }}/5
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="survey-footer">
                                <a href="{{ $survey['click_url'] ?? '#' }}" target="_blank" class="btn-space btn-primary-space" style="width: 100%; text-decoration: none;">
                                    📋 Start Survey
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card-float text-center" style="padding: var(--space-3xl);">
                    <div style="font-size: 64px; margin-bottom: var(--space-md); opacity: 0.3;">📋</div>
                    <h3 style="color: rgba(255, 255, 255, 0.7); margin-bottom: var(--space-sm);">No Surveys Available</h3>
                    <p style="color: rgba(255, 255, 255, 0.5); margin-bottom: var(--space-md);">
                        Check back soon! Surveys are added based on your profile and location.
                    </p>
                    
                    <!-- Troubleshooting Info -->
                    <div style="margin-top: var(--space-lg); padding: var(--space-md); background: rgba(255, 152, 0, 0.1); border-radius: 8px; text-align: left;">
                        <p style="color: rgba(255, 255, 255, 0.8); font-size: 13px; margin-bottom: 8px;">
                            <strong>⚠️ Troubleshooting:</strong>
                        </p>
                        <ul style="color: rgba(255, 255, 255, 0.7); font-size: 12px; margin: 0; padding-left: 20px;">
                            <li>BitLabs API Token: {{ env('BITLABS_API_TOKEN') ? 'Configured ✅' : 'MISSING ❌' }}</li>
                            <li>Your UID: {{ Auth::user()->uid }}</li>
                            <li>API URL: https://api.bitlabs.ai/v1/surveys</li>
                            <li style="margin-top: 8px;">
                                Possible reasons:
                                <ul style="margin-top: 4px;">
                                    <li>BitLabs account pending approval</li>
                                    <li>Backend API calls not enabled (contact BitLabs)</li>
                                    <li>No surveys for your country ({{ Auth::user()->country_code ?? 'Unknown' }})</li>
                                    <li>Cache needs clearing: <code style="background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px;">php artisan config:clear</code></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('styles')
<style>
.surveys-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: var(--space-lg);
}

.stat-item {
    display: flex;
    align-items: center;
    gap: var(--space-md);
}

.stat-icon {
    font-size: 36px;
}

.stat-info h3 {
    font-size: 24px;
    font-weight: 700;
    color: #00B8D4;
    margin: 0;
}

.stat-info p {
    font-size: 13px;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
}

.surveys-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--space-lg);
    margin-top: var(--space-xl);
}

.survey-card {
    background: linear-gradient(145deg, rgba(15, 15, 25, 0.8), rgba(20, 20, 30, 0.9));
    border: 1px solid rgba(0, 184, 212, 0.2);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.survey-card:hover {
    border-color: #00B8D4;
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 184, 212, 0.3);
}

.survey-header {
    padding: var(--space-md);
    background: rgba(0, 184, 212, 0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.05);
}

.survey-badge {
    display: flex;
    gap: 8px;
}

.badge-duration {
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.badge-duration.short {
    background: rgba(76, 175, 80, 0.2);
    color: #4CAF50;
    border: 1px solid rgba(76, 175, 80, 0.4);
}

.badge-duration.medium {
    background: rgba(255, 152, 0, 0.2);
    color: #FFA726;
    border: 1px solid rgba(255, 152, 0, 0.4);
}

.badge-duration.long {
    background: rgba(244, 67, 54, 0.2);
    color: #F44336;
    border: 1px solid rgba(244, 67, 54, 0.4);
}

.survey-payout {
    display: flex;
    align-items: baseline;
    gap: 2px;
}

.payout-integer {
    font-size: 24px;
    font-weight: 700;
    color: #00B8D4;
}

.payout-decimal {
    font-size: 16px;
    font-weight: 600;
    color: #00B8D4;
}

.payout-symbol {
    font-size: 14px;
    font-weight: 600;
    color: rgba(0, 184, 212, 0.8);
    margin-left: 2px;
}

.survey-body {
    padding: var(--space-lg);
    flex: 1;
}

.survey-title {
    font-size: 16px;
    font-weight: 700;
    color: #fff;
    margin-bottom: var(--space-md);
}

.survey-details {
    display: flex;
    gap: var(--space-md);
    flex-wrap: wrap;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.7);
}

.detail-item svg {
    opacity: 0.6;
}

.survey-footer {
    padding: var(--space-md);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

@media (max-width: 768px) {
    .surveys-grid {
        grid-template-columns: 1fr;
        gap: var(--space-md);
    }
    
    .surveys-stats-grid {
        grid-template-columns: 1fr;
        gap: var(--space-md);
    }
}
</style>
@endsection

