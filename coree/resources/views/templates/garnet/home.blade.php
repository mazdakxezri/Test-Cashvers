@extends($activeTemplate . '.layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection
@section('title', 'Earn')

@section('content')

    @include($activeTemplate . '.partials.live-stats')

    @if (isset($isVPNDetected) && $isVPNDetected)
        <!--VPN Detected -->
        <section class="vpn-detect d-flex align-items-center justify-content-center px-4 py-5">
            <div class="text-center">
                <h2 class="mb-0">
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/shield.png') }}" class="img-fluid"
                        alt="shield" />
                </h2>
                <div class="vpn mt-3">
                    <h2>VPN Detected</h2>
                    <p>Please turn off your VPN for a smoother browsing experience. Thank you for your understanding!</p>
                </div>

            </div>
        </section>
    @else
        @if (isOgadsApiEnabled() || count($allOffers) > 0)
            <!--API Offers-->
            <section class="cover api-offers mb-3">
                <div class="sec-title pt-4 pb-2 px-4 d-flex align-items-center justify-content-between">
                    <h2 class="mb-0">
                        <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/rocket.svg') }}" class="img-fluid"
                            alt="rocket" />
                        Latest Offers
                    </h2>
                    <div class="slid-button d-flex align-items-center gap-2">
                        <a href="{{ route('all.offers') }}" class="text-white text-capitalize fw-semibold fs-13">view
                            all</a>
                        <div id="prev-api-offers" class="prev d-none d-lg-flex">&lt;</div>
                        <div id="next-api-offers" class="next d-none d-lg-flex">&gt;</div>
                    </div>
                </div>
                @if (count($allOffers) > 0)
                    <div class="row api-offers-row flex-nowrap overflow-hidden pt-3 mx-0 swiper-container"
                        id="api-offers-1">
                        <div class="swiper-wrapper px-0">
                            @foreach ($allOffers as $offer)
                                @include($activeTemplate . '.partials.slide', [
                                    'name' => $offer->name,
                                    'creative' => $offer->creative,
                                    'payout' => $offer->payout,
                                    'device' => $offer->device ?: 'desktop',
                                    'requirements' => $offer->requirements,
                                    'link' => Auth::check() ? $offer->link : '#',
                                    'description' => $offer->description,
                                    'event' => $offer->event ?? null,
                                ])
                            @endforeach

                        </div>

                    </div>
                @endif
                @if (count($ogadsOffers) > 0)
                    <div class="row api-offers-row flex-nowrap overflow-hidden pt-3 mx-0 swiper-container"
                        id="api-offers-2">
                        <div class="swiper-wrapper px-0">
                            @foreach ($ogadsOffers as $ogads)
                                @include($activeTemplate . '.partials.slide', [
                                    'name' => $ogads['name_short'],
                                    'creative' => $ogads['picture'],
                                    'payout' => $ogads['payout'],
                                    'device' => detectDevicePlatform(),
                                    'requirements' => $ogads['adcopy'],
                                    'link' => Auth::check() ? $ogads['link'] . Auth::user()->uid : '#',
                                    'description' => $ogads['description'],
                                    'event' => null,
                                ])
                            @endforeach
                        </div>

                    </div>
                @endif
            </section>
        @endif
        <!--Offerwalls-->
        <section class="offerwalls px-4 position-relative overflow-hidden">
            <h1 class="site-name text-uppercase">{{ SiteName() }}</h1>
            @if (count($offer_networks) > 0)
                <div class="offerwall mb-3">
                    <div class="sec-title pt-4 pb-0 d-flex align-items-center justify-content-between">
                        <h2 class="mb-0">
                            <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/joystick.svg') }}"
                                class="img-fluid" alt="joystick" />
                            Offer Partners
                        </h2>
                        <div class="slid-button d-flex gap-2">
                            <div id="prev-offerwalls" class="prev">&lt;</div>
                            <div id="next-offerwalls" class="next">&gt;</div>
                        </div>
                    </div>

                    <div class="row flex-nowrap overflow-x-hidden pt-5 swiper-container" id="offerwalls">
                        @include($activeTemplate . '.partials.networks', [
                            'networks' => $offer_networks,
                        ])
                    </div>
                </div>
            @endif
            @if (count($survey_networks) > 0)
                <div class="surveys mb-3">
                    <div class="sec-title pt-4 pb-0 d-flex align-items-center justify-content-between">
                        <h2 class="mb-0">
                            <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/joystick.svg') }}"
                                class="img-fluid" alt="joystick" />
                            Survey Partners
                        </h2>
                        <div class="slid-button d-flex gap-2">
                            <div id="prev-surveys" class="prev">&lt;</div>
                            <div id="next-surveys" class="next">&gt;</div>
                        </div>
                    </div>
                    <div class="row flex-nowrap overflow-x-hidden pt-5 swiper-container" id="surveys">
                        @include($activeTemplate . '.partials.networks', [
                            'networks' => $survey_networks,
                        ])
                    </div>
                </div>
            @endif
        </section>
        @include($activeTemplate . '.partials.modals.offerwall')
        @include($activeTemplate . '.partials.modals.api')

    @endif

@endsection

@section('scripts')
    @include($activeTemplate . '.partials.scripts.live-stats')
    <script>
        const initSwiper = (container, nextEl, prevEl, paginationEl) => new Swiper(container, {
            slidesPerView: 'auto',
            loop: false,
            freeMode: true,
            pagination: {
                el: paginationEl,
                clickable: true,
            },
            navigation: {
                nextEl,
                prevEl,
            },
        });

        const offerwallsSwiper = initSwiper('#offerwalls', '#next-offerwalls', '#prev-offerwalls',
            '.swiper-pagination');
        const surveysSwiper = initSwiper('#surveys', '#next-surveys', '#prev-surveys', '.swiper-pagination');
        const apiOffers1Swiper = initSwiper('#api-offers-1', '#next-api-offers', '#prev-api-offers',
            '#api-offers-1 .swiper-pagination');
        const apiOffers2Swiper = initSwiper('#api-offers-2', '#next-api-offers', '#prev-api-offers',
            '#api-offers-2 .swiper-pagination');

        const syncNavigations = (buttonId, action) => {
            const button = document.getElementById(buttonId);
            if (button) {
                button.addEventListener('click', () => {
                    if (action === 'prev') {
                        apiOffers1Swiper.slidePrev();
                        apiOffers2Swiper.slidePrev();
                    } else {
                        apiOffers1Swiper.slideNext();
                        apiOffers2Swiper.slideNext();
                    }
                });
            }
        };

        syncNavigations('prev-api-offers', 'prev');
        syncNavigations('next-api-offers', 'next');
    </script>

    @include($activeTemplate . '.partials.scripts.api-offers')


    @auth
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const modal = new bootstrap.Modal(document.getElementById("WallModal"));
                const iframe = document.getElementById("offerwallIframe");
                const preloader = document.getElementById("offerwall-preloader");

                document.querySelectorAll('[data-bs-toggle="modal"]').forEach(element => {
                    element.addEventListener("click", function() {
                        const offerUrl = this.getAttribute("data-url");

                        if (!offerUrl || !modal || !iframe || !preloader) return;

                        iframe.src = offerUrl;
                        preloader.style.display = "flex";
                        modal.show();

                        iframe.onload = () => {
                            preloader.style.display = "none";
                        };
                    });
                });
            });
        </script>
    @endauth

@endsection
