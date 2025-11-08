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

            <!-- BitLabs Offerwall iframe -->
            <div class="card-float" style="padding: 0; overflow: hidden;">
                <iframe 
                    src="https://web.bitlabs.ai/?token={{ env('BITLABS_APP_TOKEN') }}&uid={{ Auth::user()->uid }}"
                    style="width: 100%; height: 800px; border: none; border-radius: 12px;"
                    frameborder="0"
                    allow="geolocation"
                    id="bitlabs-iframe">
                </iframe>
            </div>

            <!-- Info Box -->
            <div class="card-float" style="margin-top: var(--space-lg);">
                <h3 style="margin-bottom: var(--space-md);">💡 How to Earn with Surveys</h3>
                <ul style="color: rgba(255, 255, 255, 0.7); line-height: 1.8;">
                    <li>✅ Click on any survey above</li>
                    <li>✅ Answer questions honestly and carefully</li>
                    <li>✅ Complete the entire survey (don't close early!)</li>
                    <li>✅ Rewards credited automatically to your account</li>
                </ul>
                
                <div style="margin-top: var(--space-md); padding: var(--space-md); background: rgba(0, 184, 212, 0.1); border-radius: 8px; border-left: 3px solid #00B8D4;">
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 13px; margin: 0;">
                        <strong>💰 Pro Tip:</strong> Quality matters! Providing accurate answers increases your survey availability and earnings.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
<style>
#bitlabs-iframe {
    background: rgba(10, 10, 15, 0.5);
}

@media (max-width: 768px) {
    #bitlabs-iframe {
        height: 600px;
    }
}
</style>
@endsection

