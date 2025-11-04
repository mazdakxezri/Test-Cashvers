@extends($activeTemplate . '.layouts.app')
@section('title', 'Affiliates')

@section('content')
    <div class="cosmic-bg">
        <div class="stars"></div>
        <div class="glow-orb glow-orb-purple" style="top: 20%; right: 10%;"></div>
        <div class="glow-orb glow-orb-warm" style="bottom: 30%; left: 15%;"></div>
    </div>

    <section class="section-space" style="padding-top: var(--space-3xl);">
        <div class="container-space">
            <div class="section-header-space">
                <h1 class="heading-hero">Referral <span class="text-gradient-blue">Program</span></h1>
                <p class="text-body-lg">Invite friends and earn {{ ReferralCommission() }}% of their lifetime earnings</p>
            </div>

            <!-- Referral Stats -->
            <div class="grid-3" style="margin-bottom: var(--space-2xl);">
                <div class="stat-card-space">
                    <div class="stat-value-space">{{ $total_user_referred }}</div>
                    <div class="stat-label-space">Total Referrals</div>
                </div>
                <div class="stat-card-space">
                    <div class="stat-value-space">{{ siteSymbol() }}{{ number_format($ref_earning, 2) }}</div>
                    <div class="stat-label-space">Total Earned</div>
                </div>
                <div class="stat-card-space">
                    <div class="stat-value-space">{{ ReferralCommission() }}%</div>
                    <div class="stat-label-space">Commission Rate</div>
                </div>
            </div>

            <!-- Referral Link Card -->
            <div class="card-float" style="margin-bottom: var(--space-2xl);">
                <h3 style="margin-bottom: var(--space-md);">Your Referral Link</h3>
                <div class="referral-link-box">
                    <input type="text" value="{{ route('referral.code', $referral_code) }}" 
                           id="referralLink" class="input-space" readonly>
                    <button onclick="copyReferralLink()" class="btn-space-primary">
                        Copy Link
                    </button>
                </div>
            </div>

            <!-- Referrals Table -->
            @if($referralLogs->count() > 0)
                <div class="card-float">
                    <h3 style="margin-bottom: var(--space-lg);">Your Referrals</h3>
                    <div class="table-responsive">
                        <table class="table-clean">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Earnings from Them</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($referralLogs as $log)
                                    <tr>
                                        <td>{{ $log['user'] }}</td>
                                        <td>{{ siteSymbol() }}{{ number_format($log['earnings'], 2) }}</td>
                                        <td>{{ $log['created_at']->diffForHumans() }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="card-float" style="text-align: center;">
                    <p class="text-body">No referrals yet. Share your link to start earning!</p>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function copyReferralLink() {
            const input = document.getElementById('referralLink');
            input.select();
            document.execCommand('copy');
            
            // Visual feedback
            const btn = event.target;
            const originalText = btn.textContent;
            btn.textContent = 'Copied!';
            setTimeout(() => {
                btn.textContent = originalText;
            }, 2000);
        }
    </script>
@endsection

<style>
.referral-link-box {
    display: flex;
    gap: var(--space-md);
    align-items: center;
}

.referral-link-box input {
    flex: 1;
}

.podium-space {
    display: flex;
    justify-content: center;
    align-items: flex-end;
    gap: var(--space-xl);
    margin: var(--space-2xl) 0;
}

@media (max-width: 768px) {
    .referral-link-box {
        flex-direction: column;
    }
    
    .referral-link-box button {
        width: 100%;
    }
    
    .podium-space {
        flex-direction: column;
        align-items: stretch;
    }
}
</style>

