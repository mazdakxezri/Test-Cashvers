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

            <!-- Loading State -->
            <div id="surveys-loading" class="text-center" style="padding: var(--space-3xl);">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem; color: #00B8D4 !important;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p style="color: rgba(255, 255, 255, 0.7); margin-top: var(--space-md);">Loading surveys...</p>
            </div>

            <!-- Surveys Grid (Hidden initially, shown by JS) -->
            <div id="surveys-container" style="display: none;">
                <div class="surveys-grid" id="surveys-grid">
                    <!-- Surveys will be inserted here by JavaScript -->
                </div>
            </div>

            <!-- Empty State (Hidden initially) -->
            <div id="no-surveys" style="display: none;">
                <div class="card-float text-center" style="padding: var(--space-3xl);">
                    <div style="font-size: 64px; margin-bottom: var(--space-md); opacity: 0.3;">📋</div>
                    <h3 style="color: rgba(255, 255, 255, 0.7); margin-bottom: var(--space-sm);">No Surveys Available Right Now</h3>
                    <p style="color: rgba(255, 255, 255, 0.5); margin-bottom: var(--space-md);">
                        Check back soon! Surveys refresh every few minutes.
                    </p>
                    <button onclick="location.reload()" class="btn-space btn-primary-space">
                        🔄 Refresh Surveys
                    </button>
                </div>
            </div>

            <!-- Info Box -->
            <div class="card-float" style="margin-top: var(--space-lg);">
                <h3 style="margin-bottom: var(--space-md);">💡 How to Earn with Surveys</h3>
                <ul style="color: rgba(255, 255, 255, 0.7); line-height: 1.8;">
                    <li>✅ Click on any survey card above</li>
                    <li>✅ Answer questions honestly and carefully</li>
                    <li>✅ Complete the entire survey (don't close early!)</li>
                    <li>✅ Rewards credited automatically within minutes</li>
                </ul>
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
.surveys-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: var(--space-lg);
}

.survey-card {
    background: linear-gradient(145deg, rgba(15, 15, 25, 0.8), rgba(20, 20, 30, 0.9));
    border: 1px solid rgba(0, 184, 212, 0.2);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    cursor: pointer;
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

.survey-footer {
    padding: var(--space-md);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

@media (max-width: 768px) {
    .surveys-grid {
        grid-template-columns: 1fr;
        gap: var(--space-md);
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.bitlabs.ai/bitlabs-sdk-v2.js"></script>
<script>
// BitLabs Client-Side Integration with Custom Cards
(async function() {
    const config = {
        token: '{{ env("BITLABS_APP_TOKEN") }}',
        uid: '{{ Auth::user()->uid }}',
    };

    try {
        // Fetch surveys using BitLabs v2 API (WORKING endpoint)
        const response = await fetch(`https://api.bitlabs.ai/v2/client/surveys?uid=${config.uid}&platform=WEB_DESKTOP`, {
            headers: {
                'X-Api-Token': config.token,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();
        
        console.log('BitLabs Response:', data);

        if (data.status === 'success' && data.data && data.data.surveys && data.data.surveys.length > 0) {
            displaySurveys(data.data.surveys);
        } else {
            showNoSurveys();
        }
    } catch (error) {
        console.error('BitLabs Error:', error);
        showNoSurveys();
    }
})();

function displaySurveys(surveys) {
    document.getElementById('surveys-loading').style.display = 'none';
    document.getElementById('surveys-container').style.display = 'block';
    
    const grid = document.getElementById('surveys-grid');
    grid.innerHTML = '';

    surveys.forEach(survey => {
        const card = createSurveyCard(survey);
        grid.appendChild(card);
    });
}

function createSurveyCard(survey) {
    const valueInCents = survey.value || 0;
    const payout = (valueInCents / 100).toFixed(2);
    const [integer, decimal] = payout.split('.');
    
    const loi = survey.loi || 0;
    let durationBadge = '';
    if (loi <= 5) {
        durationBadge = '<span class="badge-duration short">⚡ Quick</span>';
    } else if (loi <= 15) {
        durationBadge = '<span class="badge-duration medium">⏱️ Medium</span>';
    } else {
        durationBadge = '<span class="badge-duration long">🕐 Long</span>';
    }

    const card = document.createElement('div');
    card.className = 'survey-card';
    card.onclick = () => window.open(survey.click_url, '_blank');
    
    card.innerHTML = `
        <div class="survey-header">
            <div class="survey-badge">
                ${durationBadge}
            </div>
            <div class="survey-payout">
                <span class="payout-integer">${integer}</span>.<span class="payout-decimal">${decimal}</span>
                <span class="payout-symbol">{{ siteSymbol() }}</span>
            </div>
        </div>
        <div class="survey-body">
            <h4 class="survey-title">${survey.category?.name || 'General Survey'}</h4>
            <div class="survey-details">
                <div class="detail-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>${loi} min</span>
                </div>
                ${survey.cr ? `
                    <div class="detail-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                        <span>${Math.round(survey.cr * 100)}% CR</span>
                    </div>
                ` : ''}
                ${survey.rating ? `
                    <div class="detail-item">
                        ⭐ ${survey.rating}/5
                    </div>
                ` : ''}
            </div>
        </div>
        <div class="survey-footer">
            <div class="btn-space btn-primary-space" style="width: 100%; text-align: center;">
                📋 Start Survey
            </div>
        </div>
    `;
    
    return card;
}

function showNoSurveys() {
    document.getElementById('surveys-loading').style.display = 'none';
    document.getElementById('no-surveys').style.display = 'block';
}
</script>
@endsection

