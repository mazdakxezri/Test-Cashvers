@extends($activeTemplate . '.layouts.app')
@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
@endsection
@section('title', 'All Offers')

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
                </div>
                @if (count($allOffers) > 0)
                    <div class="api-offers-row all-offers d-flex flex-wrap align-items-center justify-content-start flex-lg-row pt-3 mx-0"
                        id="api-offers-1">
                        @foreach ($allOffers as $offer)
                            <div class="col-4 col-md-2 col-lg-auto">
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
                            </div>
                        @endforeach
                    </div>
                @endif
                @if (count($ogadsOffers) > 0)
                    <div class="row api-offers-row flex-wrap pt-3 mx-0" id="api-offers-2">
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
                @endif
                <nav aria-label="offers pagination">
                    <ul class="pagination offers-pagination justify-content-center">
                        <li class="page-item {{ $allOffers->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $allOffers->previousPageUrl() ?? '#' }}">« PREV</a>
                        </li>

                        @php
                            $lastPage = $allOffers->lastPage();
                            $currentPage = $allOffers->currentPage();
                            $ellipsisShown = false;
                        @endphp

                        @for ($page = 1; $page <= $lastPage; $page++)
                            @if ($page == $currentPage)
                                <li class="page-item active">
                                    <div class="position-relative">
                                        <svg width="31" height="30" viewBox="0 0 31 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.84375 2C0.84375 0.89543 1.73918 0 2.84375 0H23.0153C23.5458 0 24.0545 0.210714 24.4295 0.585786L30.258 6.41421C30.633 6.78929 30.8438 7.29799 30.8438 7.82843V28C30.8438 29.1046 29.9483 30 28.8438 30H8.67218C8.14174 30 7.63304 29.7893 7.25796 29.4142L1.42954 23.5858C1.05446 23.2107 0.84375 22.702 0.84375 22.1716V2Z"
                                                fill="none" />
                                        </svg>
                                        <a class="page-link offers" href="#">{{ $page }}</a>
                                    </div>
                                </li>
                                @php $ellipsisShown = false; @endphp
                            @elseif ($page == 1 || $page == $lastPage || abs($currentPage - $page) <= 2)
                                <li class="page-item">
                                    <div class="position-relative">
                                        <svg width="31" height="30" viewBox="0 0 31 30" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.84375 2C0.84375 0.89543 1.73918 0 2.84375 0H23.0153C23.5458 0 24.0545 0.210714 24.4295 0.585786L30.258 6.41421C30.633 6.78929 30.8438 7.29799 30.8438 7.82843V28C30.8438 29.1046 29.9483 30 28.8438 30H8.67218C8.14174 30 7.63304 29.7893 7.25796 29.4142L1.42954 23.5858C1.05446 23.2107 0.84375 22.702 0.84375 22.1716V2Z"
                                                fill="none" />
                                        </svg>
                                        <a class="page-link offers"
                                            href="{{ $allOffers->url($page) }}">{{ $page }}</a>
                                    </div>
                                </li>
                                @php $ellipsisShown = false; @endphp
                            @elseif (!$ellipsisShown)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                @php $ellipsisShown = true; @endphp
                            @endif
                        @endfor

                        <li class="page-item {{ !$allOffers->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $allOffers->nextPageUrl() ?? '#' }}">NEXT »</a>
                        </li>
                    </ul>
                </nav>


            </section>
        @endif
        @include($activeTemplate . '.partials.modals.api')
    @endif

@endsection

@section('scripts')
    @include($activeTemplate . '.partials.scripts.live-stats')
    @include($activeTemplate . '.partials.scripts.api-offers')
@endsection
