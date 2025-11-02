<button class="api-offers-card swiper-slide mb-2" data-bs-toggle="modal" data-bs-target="#ApiModal"
    data-name="{{ $name }}" data-creative="{{ $creative }}" data-payout="{{ number_format($payout, 2) }}"
    data-device="{{ $device }}" data-requirements="{{ $requirements }}" data-link="{{ $link }}"
    data-description="{{ $description }}" data-event='@json($event)'>
    <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center h-100 w-100">
        <div class="col-auto my-lg-0 ">
            <img src="{{ $creative }}" alt="{{ $name }}" class="img-fluid" />
        </div>
        <div class="col w-100 ps-lg-3">
            <p class="mb-0 fw-semibold pt-1 pt-lg-0">
                {{ strlen($name) > 10 ? substr($name, 0, 10) . '...' : $name }}</p>
            <div class="d-flex align-items-center justify-content-start mb-2 ">
                <small class="fs-12">Game</small>
                <div class="system d-flex align-items-center justify-content-center ms-auto d-lg-none">
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/' . ($device ?: 'desktop') . '.svg') }}"
                        alt="{{ $device ?: 'desktop' }}" />
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                @php
                    $formattedPayout = number_format($payout, 2);
                    [$integerPart, $decimalPart] = explode('.', $formattedPayout);
                @endphp
                <div class="cpi fs-13">{{ $integerPart }}.<span>{{ $decimalPart }}</span>
                    <strong>{{ siteSymbol() }}</strong>
                </div>
                <div class="system d-none d-lg-flex align-items-center ms-auto">
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/' . ($device ?: 'desktop') . '.svg') }}"
                        alt="{{ $device ?: 'desktop' }}" />
                </div>

            </div>
        </div>
    </div>
</button>
