@extends($activeTemplate . '.layouts.app')
@section('title', 'Home')

@section('landing-content')
    <!-- Hero Section - Clean & Minimal -->
    <section class="hero-clean">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Earn Crypto. <span class="text-gradient">Complete Tasks.</span> Get Rewarded.
                </h1>
                <p class="hero-description">
                    Turn your time into real crypto rewards. Complete offers, play games, and cash out instantly.
                </p>
                <div class="hero-cta">
                    <a href="javascript:void(0)" class="btn-primary" data-bs-toggle="modal" 
                       data-bs-target="#authModal" onclick="selectCreateAccountTab()">
                        Start Earning Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics - Clean Cards -->
    <section class="stats-clean">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">{{ getStatistics()['average_time'] }}</div>
                    <div class="stat-label">Average Time to First Cashout</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">${{ getStatistics()['average_money'] }}</div>
                    <div class="stat-label">Average Earned Yesterday</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">${{ getStatistics()['total_earned'] }}</div>
                    <div class="stat-label">Total Earned on {{ siteName() }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About - Clean & Concise -->
    <section class="about-clean">
        <div class="container">
            <div class="about-content">
                <h2>Welcome to <span class="text-accent">{{ siteName() }}</span></h2>
                <p>
                    Your gateway to earning crypto rewards. Complete offers, play games, and get paid instantly 
                    in Bitcoin, Ethereum, or USDT. Fast, secure, and designed for the crypto generation.
                </p>
            </div>
        </div>
    </section>

    <!-- How It Works - Clean Steps -->
    <section class="steps-clean">
        <div class="container">
            <div class="section-header">
                <h2>How It Works</h2>
                <p class="section-subtitle">Get started in three simple steps</p>
            </div>
            
            <div class="steps-grid">
                <div class="step-item">
                    <div class="step-number">1</div>
                    <h4>Create Account</h4>
                    <p>Sign up in 30 seconds</p>
                </div>
                
                <div class="step-item">
                    <div class="step-number">2</div>
                    <h4>Complete Offers</h4>
                    <p>Choose from thousands of tasks</p>
                </div>
                
                <div class="step-item">
                    <div class="step-number">3</div>
                    <h4>Get Paid</h4>
                    <p>Instant crypto withdrawals</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Methods - Clean Grid -->
    <section class="payments-clean">
        <div class="container">
            <div class="section-header">
                <h2>Cash Out Your Way</h2>
                <p class="section-subtitle">Multiple withdrawal options available</p>
            </div>
            
            <div class="payment-grid">
                @foreach ($paymentMethods as $image)
                    <div class="payment-item">
                        <img src="{{ url($image) }}" alt="Payment Method">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ - Clean Accordion -->
    <section class="faq-clean">
        <div class="container">
            <div class="section-header">
                <h2>Questions?</h2>
                <p class="section-subtitle">Everything you need to know</p>
            </div>
            
            <div class="faq-container">
                @foreach ($faqs as $index => $faq)
                    <div class="faq-item">
                        <button class="faq-question" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#faq{{ $index }}">
                            {{ $faq->question }}
                            <span class="faq-icon">+</span>
                        </button>
                        <div id="faq{{ $index }}" class="collapse faq-answer">
                            <div class="faq-answer-content">
                                {{ $faq->answer }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== 'javascript:void(0)') {
                    e.preventDefault();
                    document.querySelector(href)?.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // FAQ icon toggle
        document.querySelectorAll('.faq-question').forEach(btn => {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('.faq-icon');
                icon.textContent = icon.textContent === '+' ? '−' : '+';
            });
        });
    </script>
@endsection

