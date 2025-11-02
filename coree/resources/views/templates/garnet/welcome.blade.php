@extends($activeTemplate . '.layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection

@section('title', 'Home')

@section('landing-content')
    <div class="hero">
        <span class="shape-l"></span>
        <span class="shape-r"></span>
        <div class="container">
            <div class="title d-flex flex-column align-items-center justify-content-center">
                <h1 class="d-flex justify-content-center align-items-center d-md-block flex-wrap">
                    <span>Earn Money</span> While Having Fun <br>
                    Test Apps & Games Now!
                </h1>
            </div>
            <div class="hero-description d-flex align-items-baseline justify-content-center">
                <div class="chevron"></div>
                <p>Get more money for the things you love, or start saving for the future by joining {{ siteName() }}
                    today.
                </p>
                <div class="chevron"></div>
            </div>
            <div class="text-center">
                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#authModal"
                    onclick="selectCreateAccountTab()">
                    <div class="position-relative">
                        <svg width="189" height="40" viewBox="0 0 189 40" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0 11.9602C0 11.4461 0.197956 10.9518 0.552781 10.5798L10.0533 0.619581C10.4307 0.223896 10.9537 0 11.5005 0H187C188.105 0 189 0.978667 189 2.08324C189 47.7945 189 -16.4661 189 28.6591C189 29.1615 188.811 29.6962 188.47 30.0655L179.904 39.3557C179.526 39.7664 178.992 40 178.434 40H2C0.895435 40 0 39.1046 0 38V11.9602Z"
                                fill="var(--primary-color)" />
                        </svg>
                        <div class="gar-btn-text">
                            start earning now
                        </div>
                    </div>
                </a>
                <div class="landing-device">
                    <div class="col-12">
                        <svg class="arrow" width="65" height="76" viewBox="0 0 65 76" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_d_828_1338)">
                                <path d="M23 53L38 38L23 23" stroke="white" stroke-width="10" />
                            </g>
                            <defs>
                                <filter id="filter0_d_828_1338" x="0.0648441" y="0.0644779" width="64.4064" height="75.871"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                    <feOffset />
                                    <feGaussianBlur stdDeviation="9.7" />
                                    <feComposite in2="hardAlpha" operator="out" />
                                    <feColorMatrix type="matrix" values="0 0 0 0 1 0 0 0 0 1 0 0 0 0 1 0 0 0 0.75 0" />
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_828_1338" />
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_828_1338"
                                        result="shape" />
                                </filter>
                            </defs>
                        </svg>
                    </div>
                    <div class="col-12">
                        <img src="{{ asset('assets/' . $activeTemplate . '/images/landing-device.png') }}"
                            class="img-fluid mb-5" alt="Device">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="statistics text-center" id="statistics">
        <div class="container">
            <div class="responsive-svg mx-auto">
                <!-- Desktop Shape: 960x190 with 45° corners -->
                <svg viewBox="0 0 960 190" class="d-none d-lg-block" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="borderGradientDesktop" x1="100%" y1="0%" x2="0%"
                            y2="0%">
                            <stop offset="0%" stop-color="rgba(255,255,255,0)" />
                            <stop offset="100%" stop-color="rgba(255,255,255,1)" />
                        </linearGradient>
                    </defs>
                    <polygon points="0,0 930,0 960,30 960,190 30,190 0,160" fill="#15171E"
                        stroke="url(#borderGradientDesktop)" stroke-width="1" />
                </svg>

                <!-- Mobile Shape: 394x522 with same 45° corners -->
                <svg viewBox="0 0 394 522" class="d-block d-lg-none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="borderGradientMobile" x1="100%" y1="0%" x2="0%"
                            y2="0%">
                            <stop offset="0%" stop-color="rgba(255,255,255,0)" />
                            <stop offset="100%" stop-color="rgba(255,255,255,1)" />
                        </linearGradient>
                    </defs>
                    <polygon points="0,0 364,0 394,30 394,522 30,522 0,492" fill="#15171E"
                        stroke="url(#borderGradientMobile)" stroke-width="1" />
                </svg>
                <div
                    class="row mx-0 h-100 justify-content-center align-items-center position-absolute top-50 start-0 translate-middle-y w-100">
                    <div class="col-12 col-lg-4 px-5 px-md-0 stat-box position-relative">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/rocket.svg') }}"
                                class="img-fluid" alt="Rocket Icon">
                            <p class="stat-title">{{ getStatistics()['average_time'] }}</p>
                        </div>
                        <p class="stat-description">Average time until user makes first cashout</p>
                    </div>
                    <div class="col-12 col-lg-4 px-5 px-md-0 stat-box position-relative">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/fire.svg') }}"
                                class="img-fluid" alt="Rocket Icon">
                            <p class="stat-title">{{ getStatistics()['average_money'] }}</p>
                        </div>
                        <p class="stat-description">Average money earned
                            by users yesterday</p>
                    </div>
                    <div class="col-12 col-lg-4 px-5 px-md-0 stat-box position-relative">
                        <div class="d-flex justify-content-center align-items-center">
                            <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/usd.svg') }}"
                                class="img-fluid" alt="Rocket Icon">
                            <p class="stat-title">{{ getStatistics()['total_earned'] }}</p>
                        </div>
                        <p class="stat-description">Total money earned on {{ siteName() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-second-desc">
        <span class="shape-l"></span>
        <span class="shape-r"></span>
        <div class="container">
            <h2 class="text-center">Turn Your Time Into Money</h2>
            <div class="row align-items-center">
                <div class="col-12 col-md-6 hero-description-card position-relative px-md-0">
                    <div class="hero-description-content" style="max-width: 499px;">
                        <h3>Welcome to {{ siteName() }}</h3>
                        <p>Your new favorite way to earn rewards online. Whether you're completing fun challenges,
                            trying new apps, or sharing your thoughts through surveys, {{ siteName() }} turns your time
                            into real
                            value.
                            It's quick, secure, and designed to keep you engaged while you earn.</p>
                        <p>Unlike other platforms, {{ siteName() }} brings together simplicity and excitement in a
                            futuristic
                            environment. With a vibrant community and a growing list of reward options, your journey
                            here is just getting started. Start exploring — and let every click bring you closer to the
                            rewards
                            you deserve.</p>

                        <a href="#" class="d-inline-block position-relative px-md-0" style="max-width: 189px;">
                            <svg width="189" height="40" viewBox="0 0 189 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0 11.9602C0 11.4461 0.197956 10.9518 0.552781 10.5798L10.0533 0.619581C10.4307 0.223896 10.9537 0 11.5005 0H187C188.105 0 189 0.978667 189 2.08324C189 47.7945 189 -16.4661 189 28.6591C189 29.1615 188.811 29.6962 188.47 30.0655L179.904 39.3557C179.526 39.7664 178.992 40 178.434 40H2C0.895435 40 0 39.1046 0 38V11.9602Z"
                                    fill="#E9213D"></path>
                            </svg>
                            <div
                                class="gar-btn-text position-absolute top-50 start-50 translate-middle text-white fw-bold">
                                Start Earning
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-6 position-relative">
                    <svg width="100%" height="470" viewBox="0 0 636 470" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <!-- Define clip path -->
                            <clipPath id="clip-shape">
                                <path
                                    d="M13.6523 40.4855C13.6523 39.958 13.8607 39.4518 14.2321 39.0773L39.3887 13.7061C39.7642 13.3273 40.2755 13.1143 40.8089 13.1143H620.652C621.757 13.1143 622.652 13.8438 622.652 14.9484C622.652 73.9195 622.652 378.392 622.652 431.551C622.652 432.074 622.447 432.484 622.08 432.858L598.882 456.515C598.506 456.898 597.992 457.114 597.454 457.114H15.6523C14.5478 457.114 13.6523 456.219 13.6523 455.114V40.4855Z" />
                            </clipPath>

                            <!-- Existing filter stays -->
                            <filter id="filter0_di_543_5063" x="0.952344" y="0.414258" width="634.4" height="469.4"
                                filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset />
                                <feGaussianBlur stdDeviation="6.35" />
                                <feComposite in2="hardAlpha" operator="out" />
                                <feColorMatrix type="matrix"
                                    values="0 0 0 0 0.913725 0 0 0 0 0.129412 0 0 0 0 0.239216 0 0 0 0.75 0" />
                                <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_543_5063" />
                                <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_543_5063"
                                    result="shape" />
                                <feColorMatrix in="SourceAlpha" type="matrix"
                                    values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                                <feOffset />
                                <feGaussianBlur stdDeviation="8" />
                                <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1" />
                                <feColorMatrix type="matrix"
                                    values="0 0 0 0 0.913725 0 0 0 0 0.129412 0 0 0 0 0.239216 0 0 0 0.5 0" />
                                <feBlend mode="normal" in2="shape" result="effect2_innerShadow_543_5063" />
                            </filter>
                        </defs>

                        <g filter="url(#filter0_di_543_5063)">
                            <!-- Add the image first, and clip it -->
                            <image href="{{ asset('assets/' . $activeTemplate . '/images/about/1.png') }}" x="0" y="0"
                                width="636" height="470" preserveAspectRatio="xMidYMid slice"
                                clip-path="url(#clip-shape)" class="img-fluid" />

                            <!-- Then draw the red shape on top (optional if you want a red overlay) -->
                            <path
                                d="M13.6523 40.4855C13.6523 39.958 13.8607 39.4518 14.2321 39.0773L39.3887 13.7061C39.7642 13.3273 40.2755 13.1143 40.8089 13.1143H620.652C621.757 13.1143 622.652 13.8438 622.652 14.9484C622.652 73.9195 622.652 378.392 622.652 431.551C622.652 432.074 622.447 432.484 622.08 432.858L598.882 456.515C598.506 456.898 597.992 457.114 597.454 457.114H15.6523C14.5478 457.114 13.6523 456.219 13.6523 455.114V40.4855Z"
                                fill="none" fill-opacity="0.1" />
                        </g>
                    </svg>

                </div>
            </div>
        </div>
    </div>


    <div class="how-start" id="how-it-works">
        <div class="container">
            <h2 class="section-title">How Does It Work?</h2>
            <div class="row steps">
                <div class="col-12 col-md-3 px-0 step-arrow position-relative">
                    <div class="d-flex justify-content-center align-items-center position-relative">
                        <div class="primary-box">
                            <div class="icon-box">
                                <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/steps/1.svg') }}"
                                    alt="Create Account">
                            </div>
                        </div>

                    </div>
                    <p>1. Create Account</p>
                </div>
                <div class="col-12 col-md-3 px-0 step-arrow position-relative">
                    <div class="d-flex justify-content-center align-items-center position-relative">
                        <div class="primary-box">
                            <div class="icon-box">
                                <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/steps/2.svg') }}"
                                    alt="Create Account">
                            </div>
                        </div>
                    </div>
                    <p>2. Choose an offer</p>
                </div>
                <div class="col-12 col-md-3 px-0 step-arrow position-relative">
                    <div class="d-flex justify-content-center align-items-center position-relative">
                        <div class="primary-box">
                            <div class="icon-box">
                                <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/steps/3.svg') }}"
                                    alt="Create Account">
                            </div>
                        </div>

                    </div>
                    <p>3. Complete the offer</p>
                </div>
                <div class="col-12 col-md-3 px-0 step-arrow position-relative">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="primary-box">
                            <div class="icon-box">
                                <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/steps/4.svg') }}"
                                    alt="Create Account">
                            </div>
                        </div>
                    </div>
                    <p>4. get paid</p>
                </div>

            </div>
        </div>
    </div>

    <div class="about-us" id="who-we-are">
        <div class="container-fluid">
            <div class="title position-relative">
                <p class="mb-0">{{ siteName() }}</p>
                <span class="about-identity d-md-none">{{ siteName() }}</span>
            </div>
            <div class="about-us-content">
                <span class="about-identity d-none d-md-block">{{ siteName() }}</span>
                <p class="text-center">
                    {{ siteName() }} is a next-generation rewards platform that lets users earn real money by completing
                    simple
                    tasks, playing mobile games, and answering surveys. Whether you're downloading apps or sharing your
                    opinion, every action brings you closer to valuable gift cards, cash, and crypto rewards. Designed for
                    speed, trust, and fun, {{ siteName() }} makes it easy for anyone to turn spare time into real
                    earnings — from
                    anywhere in the world.
                </p>
            </div>

        </div>
    </div>

    <div class="payment-method" id="cashout">
        <div class="container">
            <div class="title text-center">
                <h3>Redeem Gift Cards & Get Rewarded</h3>
                <p class="mx-0 mb-4">Exchange your points for top-tier gift cards — from gaming, shopping, to global brands
                    you love.</p>
            </div>
            <div class="arrow position-relative py-md-0">
                <div class="next-method"></div>
                <div class="prev-method"></div>
                <div class="swiper" id="payments-methods">
                    <div class="swiper-wrapper flex-column flex-md-row align-items-center" id="payments-methods-wrapper">
                        @foreach ($paymentMethods as $image)
                            <div class="payments-methods-container swiper-slide">
                                <svg width="240" height="150" viewBox="0 0 240 150" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3 0.5H221.758C222.338 0.500106 222.897 0.701925 223.342 1.06641L223.525 1.23242L238.768 16.4746C239.236 16.9433 239.5 17.5793 239.5 18.2422V147C239.5 148.381 238.381 149.5 237 149.5H18.2217C17.6506 149.5 17.099 149.304 16.6572 148.95L16.4756 148.789L1.25391 133.935C0.771871 133.464 0.5 132.819 0.5 132.146V3C0.5 1.61929 1.61929 0.5 3 0.5Z"
                                        fill="url(#paint0_linear_543_4643)" />
                                    <path
                                        d="M3 0.5H221.758C222.338 0.500106 222.897 0.701925 223.342 1.06641L223.525 1.23242L238.768 16.4746C239.236 16.9433 239.5 17.5793 239.5 18.2422V147C239.5 148.381 238.381 149.5 237 149.5H18.2217C17.6506 149.5 17.099 149.304 16.6572 148.95L16.4756 148.789L1.25391 133.935C0.771871 133.464 0.5 132.819 0.5 132.146V3C0.5 1.61929 1.61929 0.5 3 0.5Z"
                                        fill="url(#paint1_linear_543_4643)" />
                                    <path
                                        d="M3 0.5H221.758C222.338 0.500106 222.897 0.701925 223.342 1.06641L223.525 1.23242L238.768 16.4746C239.236 16.9433 239.5 17.5793 239.5 18.2422V147C239.5 148.381 238.381 149.5 237 149.5H18.2217C17.6506 149.5 17.099 149.304 16.6572 148.95L16.4756 148.789L1.25391 133.935C0.771871 133.464 0.5 132.819 0.5 132.146V3C0.5 1.61929 1.61929 0.5 3 0.5Z"
                                        stroke="url(#paint2_linear_543_4643)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_543_4643" x1="7.99937" y1="-0.000118267"
                                            x2="62.5755" y2="189.908" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#303030" />
                                            <stop offset="1" stop-color="#0C0B08" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear_543_4643" x1="240" y1="75"
                                            x2="0" y2="75" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#E9213D" />
                                            <stop offset="1" stop-color="#831322" />
                                        </linearGradient>
                                        <linearGradient id="paint2_linear_543_4643" x1="0" y1="75"
                                            x2="240" y2="75" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="white" />
                                            <stop offset="1" stop-color="white" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <img src="{{ url($image) }}"
                                    class="position-absolute top-50 start-50 translate-middle img-fluid">
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="faqs" id="faq">
        <div class="container">
            <div class="title text-center">
                <h3>Questions? Answers...</h3>
                <p class="mx-0 mb-4">We answer what you’re thinking — clear, honest, and straight to the point.</p>
            </div>

            <div class="faq-list mt-5" id="faqAccordion">
                @foreach ($faqs as $index => $faq)
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $index }}">
                                <button class="accordion-button h-100 collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $index }}" aria-expanded="false"
                                    aria-controls="collapse{{ $index }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                                <div class="accordion-body pb-4 pt-0">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>




@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        function initSwiper() {
            const isMobile = window.innerWidth <= 768;

            new Swiper('#payments-methods', {
                direction: isMobile ? 'vertical' : 'horizontal',
                slidesPerView: 'auto',
                loop: false,
                spaceBetween: 20,
                navigation: {
                    nextEl: isMobile ? '.next-method' : '.prev-method',
                    prevEl: isMobile ? '.prev-method' : '.next-method',
                },
            });
        }

        initSwiper();

        window.addEventListener('resize', () => {
            document.querySelector('#payments-methods').swiper.destroy(true, true);
            initSwiper();
        });
    </script>
@endsection
