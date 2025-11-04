<footer class="footer-space">
    <div class="container-space">
        <div class="footer-content">
            <div class="footer-brand-section">
                <h3 class="footer-brand">{{ siteName() }}</h3>
                <p class="footer-description">
                    Turn your time into crypto rewards. The future of earning is here.
                </p>
            </div>
            
            <div class="footer-links-section">
                <div class="footer-column">
                    <h4>Platform</h4>
                    <a href="{{ route('earnings.index') }}">Earn</a>
                    <a href="{{ route('cashout.index') }}">Cashout</a>
                    <a href="{{ route('leaderboard.index') }}">Leaderboard</a>
                    <a href="{{ route('affiliates.index') }}">Referrals</a>
                </div>
                
                <div class="footer-column">
                    <h4>Legal</h4>
                    <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                    <a href="{{ route('terms.of.use') }}">Terms of Service</a>
                </div>
                
                <div class="footer-column">
                    <h4>Support</h4>
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#contactModal">Contact Us</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ siteName() }}. All rights reserved.</p>
        </div>
    </div>
</footer>

<style>
.footer-space {
    background: var(--space-dark);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    padding: var(--space-2xl) 0 var(--space-xl);
    margin-top: var(--space-4xl);
    margin-left: 0 !important;
    width: 100% !important;
}

.footer-content {
    display: grid;
    grid-template-columns: 1.5fr 1fr;
    gap: var(--space-2xl);
    margin-bottom: var(--space-xl);
}

.footer-brand {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-white);
    margin-bottom: var(--space-md);
}

.footer-description {
    color: var(--text-gray);
    font-size: 15px;
    line-height: 1.7;
    max-width: 400px;
    margin: 0;
}

.footer-links-section {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-xl);
}

.footer-column h4 {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-white);
    margin-bottom: var(--space-md);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.footer-column a {
    display: block;
    color: var(--text-gray);
    text-decoration: none;
    font-size: 14px;
    margin-bottom: var(--space-sm);
    transition: color 0.2s ease;
}

.footer-column a:hover {
    color: var(--primary-bright);
}

.footer-bottom {
    padding-top: var(--space-xl);
    border-top: 1px solid rgba(255, 255, 255, 0.05);
    text-align: center;
}

.footer-bottom p {
    color: var(--text-dim);
    font-size: 14px;
    margin: 0;
}

@media (max-width: 1199px) {
    .footer-space {
        margin-bottom: 72px; /* Account for bottom mobile menu */
    }
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        gap: var(--space-xl);
    }
    
    .footer-links-section {
        grid-template-columns: 1fr;
        gap: var(--space-lg);
    }
}
</style>

