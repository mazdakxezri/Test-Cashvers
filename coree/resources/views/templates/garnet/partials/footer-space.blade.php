<footer style="background: #0a0a0f; border-top: 1px solid rgba(255, 255, 255, 0.05); padding: 80px 0 40px; margin-top: 0; width: 100%; position: relative; z-index: 100;">
    <div style="max-width: 1400px; margin: 0 auto; padding: 0 24px;">
        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 64px; margin-bottom: 48px;">
            <div>
                <h3 style="font-size: 28px; font-weight: 700; color: #ffffff; margin-bottom: 16px; font-family: 'Inter', sans-serif;">{{ siteName() }}</h3>
                <p style="color: rgba(255, 255, 255, 0.6); font-size: 15px; line-height: 1.7; max-width: 400px; margin: 0; font-family: 'Inter', sans-serif;">
                    Turn your time into crypto rewards. The future of earning is here.
                </p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 48px;">
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; color: #ffffff; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.05em; font-family: 'Inter', sans-serif;">PLATFORM</h4>
                    <a href="{{ route('earnings.index') }}" style="display: block; color: rgba(255, 255, 255, 0.6); text-decoration: none; font-size: 14px; margin-bottom: 12px; transition: color 0.2s ease; font-family: 'Inter', sans-serif;">Earn</a>
                    <a href="{{ route('cashout.index') }}" style="display: block; color: rgba(255, 255, 255, 0.6); text-decoration: none; font-size: 14px; margin-bottom: 12px; transition: color 0.2s ease; font-family: 'Inter', sans-serif;">Cashout</a>
                    <a href="{{ route('leaderboard.index') }}" style="display: block; color: rgba(255, 255, 255, 0.6); text-decoration: none; font-size: 14px; margin-bottom: 12px; transition: color 0.2s ease; font-family: 'Inter', sans-serif;">Leaderboard</a>
                    <a href="{{ route('affiliates.index') }}" style="display: block; color: rgba(255, 255, 255, 0.6); text-decoration: none; font-size: 14px; margin-bottom: 12px; transition: color 0.2s ease; font-family: 'Inter', sans-serif;">Referrals</a>
                </div>
                
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; color: #ffffff; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.05em; font-family: 'Inter', sans-serif;">LEGAL</h4>
                    <a href="{{ route('privacy.policy') }}" style="display: block; color: rgba(255, 255, 255, 0.6); text-decoration: none; font-size: 14px; margin-bottom: 12px; transition: color 0.2s ease; font-family: 'Inter', sans-serif;">Privacy Policy</a>
                    <a href="{{ route('terms.service') }}" style="display: block; color: rgba(255, 255, 255, 0.6); text-decoration: none; font-size: 14px; margin-bottom: 12px; transition: color 0.2s ease; font-family: 'Inter', sans-serif;">Terms of Service</a>
                </div>
                
                <div>
                    <h4 style="font-size: 14px; font-weight: 600; color: #ffffff; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.05em; font-family: 'Inter', sans-serif;">SUPPORT</h4>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#contactModal" style="display: block; color: rgba(255, 255, 255, 0.6); text-decoration: none; font-size: 14px; margin-bottom: 12px; transition: color 0.2s ease; font-family: 'Inter', sans-serif;">Contact Us</a>
                </div>
            </div>
        </div>
        
        <div style="padding-top: 48px; border-top: 1px solid rgba(255, 255, 255, 0.05); text-align: center;">
            <p style="color: rgba(255, 255, 255, 0.4); font-size: 14px; margin: 0; font-family: 'Inter', sans-serif;">&copy; {{ date('Y') }} {{ siteName() }}. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
@media (max-width: 1199px) {
    footer {
        margin-bottom: 72px !important;
    }
}

@media (max-width: 768px) {
    footer > div > div:first-child {
        grid-template-columns: 1fr !important;
        gap: 40px !important;
    }
    
    footer > div > div:first-child > div:last-child {
        grid-template-columns: 1fr !important;
        gap: 32px !important;
    }
}
</style>

