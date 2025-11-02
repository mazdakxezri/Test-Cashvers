@extends($activeTemplate . '.layouts.app')
@section('styles')
@endsection

@section('title', 'Home')

@section('landing-content')
    <!-- Hero Section -->
    <section class="hero-modern">
        <div class="decorative-dots"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title-modern">
                        <span class="highlight">Earn Money</span> While Having Fun
                    </h1>
                    <p class="hero-subtitle-modern">
                        Turn your spare time into real rewards. Complete simple tasks, play games, and get paid instantly.
                    </p>
                    <a href="javascript:void(0)" class="cta-button-modern" data-bs-toggle="modal" 
                       data-bs-target="#authModal" onclick="selectCreateAccountTab()">
                        Start Earning Now
                    </a>
                </div>
                <div class="col-lg-6 d-none d-lg-block text-center">
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/landing-device.png') }}"
                        class="img-fluid" alt="Device" style="max-width: 400px; position: relative; z-index: 10;">
                </div>
            </div>
        </div>
    </section>
    <!-- Statistics Section -->
    <section class="stats-modern" id="statistics">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="stat-card-modern">
                        <div class="stat-icon-modern">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                            </svg>
                        </div>
                        <div class="stat-value-modern">{{ getStatistics()['average_time'] }}</div>
                        <div class="stat-label-modern">Average time to first cashout</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-modern">
                        <div class="stat-icon-modern">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <path d="M12 1v22M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                        </div>
                        <div class="stat-value-modern">{{ getStatistics()['average_money'] }}</div>
                        <div class="stat-label-modern">Average earned yesterday</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-card-modern">
                        <div class="stat-icon-modern">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                <line x1="7" y1="7" x2="7.01" y2="7"/>
                            </svg>
                        </div>
                        <div class="stat-value-modern">{{ getStatistics()['total_earned'] }}+</div>
                        <div class="stat-label-modern">Total earned on {{ siteName() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section -->
    <section class="about-section-modern" id="who-we-are">
        <div class="container">
            <div class="about-content-modern">
                <h2 class="section-title-modern">Welcome to <span class="brand-highlight">{{ siteName() }}</span></h2>
                <p>
                    Your new favorite way to earn rewards online. Whether you're completing fun challenges,
                    trying new apps, or sharing your thoughts through surveys, <span class="brand-highlight">{{ siteName() }}</span> turns your time
                    into real value. It's quick, secure, and designed to keep you engaged while you earn.
                </p>
                <p>
                    Unlike other platforms, {{ siteName() }} brings together simplicity and excitement.
                    With a vibrant community and a growing list of reward options, your journey
                    here is just getting started. Start exploring — and let every click bring you closer to the
                    rewards you deserve.
                </p>
            </div>
        </div>
    </section>


    <!-- How It Works Section -->
    <section class="section-modern" id="how-it-works" style="background: #FFFFFF;">
        <div class="container">
            <h2 class="section-title-modern">How Does It Work?</h2>
            <p class="section-subtitle-modern">Get started in four simple steps and start earning today</p>
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="step-card-modern">
                        <div class="step-number-modern">1</div>
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#E9213D" stroke-width="2" style="margin: 0 auto;">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        <h4>Create Account</h4>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="step-card-modern">
                        <div class="step-number-modern">2</div>
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#E9213D" stroke-width="2" style="margin: 0 auto;">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <h4>Choose an Offer</h4>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="step-card-modern">
                        <div class="step-number-modern">3</div>
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#E9213D" stroke-width="2" style="margin: 0 auto;">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        <h4>Complete the Task</h4>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="step-card-modern">
                        <div class="step-number-modern">4</div>
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#E9213D" stroke-width="2" style="margin: 0 auto;">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        <h4>Get Paid</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Payment Methods Section -->
    <section class="payment-methods-modern" id="cashout">
        <div class="container">
            <h2 class="section-title-modern">Redeem Gift Cards & Get Rewarded</h2>
            <p class="section-subtitle-modern">Exchange your points for top-tier gift cards — from gaming, shopping, to global brands you love</p>
            <div class="row g-4">
                @foreach ($paymentMethods as $image)
                    <div class="col-lg-2 col-md-3 col-6">
                        <div class="payment-card-modern">
                            <img src="{{ url($image) }}" alt="Payment Method">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="section-modern faq-modern" id="faq">
        <div class="container">
            <h2 class="section-title-modern">Questions? Answers...</h2>
            <p class="section-subtitle-modern">We answer what you're thinking — clear, honest, and straight to the point.</p>
            
            <div class="accordion" id="faqAccordion" style="max-width: 900px; margin: 0 auto;">
                @foreach ($faqs as $index => $faq)
                    <div class="faq-item-modern">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="faq-question-modern accordion-button collapsed" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" 
                                    aria-expanded="false" aria-controls="collapse{{ $index }}">
                                {{ $faq->question }}
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="#E9213D" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse" 
                             aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                            <div class="faq-answer-modern">
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
        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== 'javascript:void(0)') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.stat-card-modern, .step-card-modern, .payment-card-modern, .faq-item-modern').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
@endsection
