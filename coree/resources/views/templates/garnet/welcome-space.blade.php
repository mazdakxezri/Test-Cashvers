@extends($activeTemplate . '.layouts.app')
@section('title', 'Home')

@section('content')
    <!-- Cosmic Background -->
    <div class="cosmic-bg">
        <div class="stars"></div>
        <div class="glow-orb glow-orb-blue" style="top: 15%; right: 10%;"></div>
        <div class="glow-orb glow-orb-purple" style="bottom: 20%; left: 5%;"></div>
        <div class="glow-orb glow-orb-warm" style="top: 60%; right: 30%;"></div>
    </div>

    <!-- Floating Geometric Shapes -->
    <div class="floating-shape shape-cube" style="top: 20%; left: 10%;"></div>
    <div class="floating-shape shape-ring" style="top: 70%; right: 15%;"></div>
    <div class="floating-shape shape-triangle" style="top: 40%; right: 5%;"></div>
    <div class="floating-shape shape-cube" style="bottom: 15%; left: 20%;"></div>

    <!-- Hero Section -->
    <section class="hero-space">
        <div class="container-space">
            <div class="hero-content-space">
                <h1 class="heading-hero">
                    Earn Crypto.<br>
                    <span class="text-gradient-blue">Explore Rewards.</span>
                </h1>
                <p class="text-body-lg" style="max-width: 600px; margin: 0 auto var(--space-xl);">
                    Turn your time into digital assets. Complete tasks, unlock achievements, 
                    and cash out in Bitcoin, Ethereum, or USDT.
                </p>
                <div style="display: flex; gap: var(--space-md); justify-content: center; flex-wrap: wrap;">
                    <a href="javascript:void(0)" class="btn-space-primary" data-bs-toggle="modal" 
                       data-bs-target="#authModal" onclick="selectCreateAccountTab()">
                        Start Earning Now
                    </a>
                    <a href="#how-it-works" class="btn-space-secondary">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="section-space">
        <div class="container-space">
            <div class="grid-3">
                <div class="stat-card-space">
                    <div class="stat-value-space">{{ getStatistics()['average_time'] }}</div>
                    <div class="stat-label-space">Average Time to First Cashout</div>
                </div>
                <div class="stat-card-space">
                    <div class="stat-value-space">${{ getStatistics()['average_money'] }}</div>
                    <div class="stat-label-space">Average Earned Yesterday</div>
                </div>
                <div class="stat-card-space">
                    <div class="stat-value-space">${{ getStatistics()['total_earned'] }}</div>
                    <div class="stat-label-space">Total Earned on {{ siteName() }}</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section-space">
        <div class="container-space">
            <div class="section-header-space">
                <h2 class="heading-section">
                    Welcome to <span class="text-gradient-blue">{{ siteName() }}</span>
                </h2>
                <p class="text-body-lg">
                    Your gateway to the crypto rewards universe. Discover opportunities, complete missions, 
                    and earn digital assets. Fast, secure, and built for the crypto generation.
                </p>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="section-space" id="how-it-works">
        <div class="container-space">
            <div class="section-header-space">
                <h2 class="heading-section">How It Works</h2>
                <p class="section-subtitle">Get started in three simple steps</p>
            </div>
            
            <div class="grid-3">
                <div class="card-float">
                    <div class="step-number-space">1</div>
                    <h4 style="margin-bottom: var(--space-sm);">Create Account</h4>
                    <p class="text-body" style="margin: 0;">Sign up in 30 seconds and join thousands earning crypto daily.</p>
                </div>
                
                <div class="card-float">
                    <div class="step-number-space">2</div>
                    <h4 style="margin-bottom: var(--space-sm);">Complete Tasks</h4>
                    <p class="text-body" style="margin: 0;">Choose from thousands of offers, surveys, and games. Earn as you go.</p>
                </div>
                
                <div class="card-float">
                    <div class="step-number-space">3</div>
                    <h4 style="margin-bottom: var(--space-sm);">Get Paid</h4>
                    <p class="text-body" style="margin: 0;">Cash out instantly to Bitcoin, Ethereum, or USDT. No minimums, no delays.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Methods -->
    <section class="section-space" style="background: var(--space-dark);">
        <div class="container-space">
            <div class="section-header-space">
                <h2 class="heading-section">Cash Out Your Way</h2>
                <p class="section-subtitle">Multiple withdrawal options available</p>
            </div>
            
            <div class="payment-grid-space">
                @foreach ($paymentMethods as $image)
                    <div class="payment-card-space">
                        <img src="{{ url($image) }}" alt="Payment Method">
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section-space">
        <div class="container-space">
            <div class="section-header-space">
                <h2 class="heading-section">Questions?</h2>
                <p class="section-subtitle">Everything you need to know</p>
            </div>
            
            <div class="faq-container-space">
                @foreach ($faqs as $index => $faq)
                    <div class="faq-item-space">
                        <button class="faq-question-space" type="button" 
                                data-bs-toggle="collapse" data-bs-target="#faq{{ $index }}">
                            {{ $faq->question }}
                            <span class="faq-icon-space">+</span>
                        </button>
                        <div id="faq{{ $index }}" class="collapse">
                            <div class="faq-answer-space">
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
        // FAQ toggle
        document.querySelectorAll('.faq-question-space').forEach(btn => {
            btn.addEventListener('click', function() {
                const icon = this.querySelector('.faq-icon-space');
                const isOpen = this.nextElementSibling.classList.contains('show');
                icon.textContent = isOpen ? '+' : '−';
            });
        });
    </script>

    <style>
    /* Hero Section */
    .hero-space {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: var(--space-4xl) 0;
        position: relative;
    }

    .hero-content-space {
        position: relative;
        z-index: 10;
    }

    /* Step Numbers */
    .step-number-space {
        width: 56px;
        height: 56px;
        background: var(--primary-glow);
        color: var(--space-black);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: var(--space-md);
    }

    /* Payment Grid */
    .payment-grid-space {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: var(--space-md);
        max-width: 1000px;
        margin: 0 auto;
    }

    .payment-card-space {
        background: rgba(18, 18, 26, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: var(--radius-md);
        padding: var(--space-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 120px;
        transition: all 0.3s ease;
    }

    .payment-card-space:hover {
        border-color: rgba(0, 184, 212, 0.3);
        transform: translateY(-4px);
    }

    .payment-card-space img {
        max-width: 100%;
        max-height: 50px;
        object-fit: contain;
        filter: brightness(1.1);
    }

    /* FAQ */
    .faq-container-space {
        max-width: 900px;
        margin: 0 auto;
    }

    .faq-item-space {
        background: rgba(18, 18, 26, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: var(--radius-md);
        margin-bottom: var(--space-md);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-item-space:hover {
        border-color: rgba(0, 184, 212, 0.2);
    }

    .faq-question-space {
        width: 100%;
        background: transparent;
        border: none;
        color: var(--text-white);
        font-size: 17px;
        font-weight: 600;
        padding: var(--space-lg);
        text-align: left;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .faq-icon-space {
        color: var(--primary-glow);
        font-size: 24px;
        font-weight: 300;
        transition: transform 0.3s ease;
    }

    .faq-answer-space {
        padding: 0 var(--space-lg) var(--space-lg);
        color: var(--text-gray);
        line-height: 1.8;
    }
    </style>
@endsection

