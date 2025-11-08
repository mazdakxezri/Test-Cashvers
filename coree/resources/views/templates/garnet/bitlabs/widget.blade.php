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

            <!-- BitLabs Widget Container -->
            <div class="card-float">
                <div id="bitlabs-container" style="min-height: 600px; background: rgba(0, 0, 0, 0.2); border-radius: 12px; overflow: hidden;">
                    <!-- BitLabs surveys will load here -->
                </div>
            </div>

            <!-- Info Box -->
            <div class="card-float" style="margin-top: var(--space-lg);">
                <h3 style="margin-bottom: var(--space-md);">💡 How to Earn with Surveys</h3>
                <ul style="color: rgba(255, 255, 255, 0.7); line-height: 1.8;">
                    <li>✅ Click on any survey card above</li>
                    <li>✅ Answer questions honestly</li>
                    <li>✅ Complete the survey (don't close early!)</li>
                    <li>✅ Get rewarded automatically</li>
                </ul>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
// BitLabs Widget Integration
(function() {
    const bitlabsConfig = {
        token: '{{ env('BITLABS_APP_TOKEN') }}',
        uid: '{{ Auth::user()->uid }}',
    };

    // Load BitLabs SDK
    const script = document.createElement('script');
    script.src = 'https://web.bitlabs.ai/sdk/v1/bitlabs-sdk.js';
    script.async = true;
    script.onload = function() {
        if (window.BitLabs) {
            window.BitLabs.init({
                token: bitlabsConfig.token,
                uid: bitlabsConfig.uid,
                container: '#bitlabs-container',
                tags: {
                    source: 'cashvers'
                }
            });
        }
    };
    document.head.appendChild(script);
})();
</script>
@endsection

