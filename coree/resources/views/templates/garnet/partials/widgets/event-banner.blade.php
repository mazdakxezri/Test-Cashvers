@php
    $eventService = new \App\Services\EventService();
    $banners = $eventService->getActiveBanners();
@endphp

@if($banners->isNotEmpty())
    <div class="event-banners-container" style="margin-bottom: var(--space-lg);">
        @foreach($banners as $event)
            @if(Auth::check() && $eventService->userCanSeeEvent(Auth::user(), $event))
                <div class="event-banner" style="background: linear-gradient(135deg, {{ $event->banner_color }}20, {{ $event->banner_color }}10); border-left: 4px solid {{ $event->banner_color }};">
                    <div class="event-banner-content">
                        <div class="event-icon">
                            @if($event->event_type === 'bonus_multiplier')
                                🎁
                            @elseif($event->event_type === 'special_offers')
                                ⭐
                            @elseif($event->event_type === 'contest')
                                🏆
                            @else
                                📢
                            @endif
                        </div>
                        <div class="event-info">
                            <h4 class="event-title">{{ $event->name }}</h4>
                            <p class="event-description">{{ $event->description }}</p>
                            @if($event->event_type === 'bonus_multiplier' && $event->bonus_multiplier > 1)
                                <span class="event-multiplier">{{ $event->bonus_multiplier }}x Earnings!</span>
                            @endif
                        </div>
                        <div class="event-countdown" data-end="{{ $event->end_date->timestamp }}">
                            <div class="countdown-timer">
                                <div class="countdown-segment">
                                    <span class="countdown-value" id="days-{{ $event->id }}">0</span>
                                    <span class="countdown-label">Days</span>
                                </div>
                                <div class="countdown-segment">
                                    <span class="countdown-value" id="hours-{{ $event->id }}">0</span>
                                    <span class="countdown-label">Hours</span>
                                </div>
                                <div class="countdown-segment">
                                    <span class="countdown-value" id="minutes-{{ $event->id }}">0</span>
                                    <span class="countdown-label">Min</span>
                                </div>
                                <div class="countdown-segment">
                                    <span class="countdown-value" id="seconds-{{ $event->id }}">0</span>
                                    <span class="countdown-label">Sec</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    (function() {
                        const endTime = {{ $event->end_date->timestamp }};
                        const eventId = {{ $event->id }};

                        function updateCountdown() {
                            const now = Math.floor(Date.now() / 1000);
                            const timeLeft = Math.max(0, endTime - now);

                            const days = Math.floor(timeLeft / 86400);
                            const hours = Math.floor((timeLeft % 86400) / 3600);
                            const minutes = Math.floor((timeLeft % 3600) / 60);
                            const seconds = timeLeft % 60;

                            document.getElementById('days-' + eventId).textContent = days;
                            document.getElementById('hours-' + eventId).textContent = hours;
                            document.getElementById('minutes-' + eventId).textContent = minutes;
                            document.getElementById('seconds-' + eventId).textContent = seconds;

                            if (timeLeft === 0) {
                                location.reload(); // Refresh page when event ends
                            }
                        }

                        updateCountdown();
                        setInterval(updateCountdown, 1000);
                    })();
                </script>
            @endif
        @endforeach
    </div>

    <style>
        .event-banners-container {
            display: flex;
            flex-direction: column;
            gap: var(--space-md);
        }

        .event-banner {
            padding: var(--space-lg);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .event-banner-content {
            display: flex;
            align-items: center;
            gap: var(--space-lg);
        }

        .event-icon {
            font-size: 48px;
            flex-shrink: 0;
        }

        .event-info {
            flex: 1;
        }

        .event-title {
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 4px;
        }

        .event-description {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }

        .event-multiplier {
            display: inline-block;
            margin-top: 8px;
            padding: 4px 12px;
            background: rgba(255, 215, 0, 0.2);
            border: 1px solid rgba(255, 215, 0, 0.4);
            border-radius: 8px;
            color: #FFD700;
            font-size: 12px;
            font-weight: 700;
        }

        .event-countdown {
            flex-shrink: 0;
        }

        .countdown-timer {
            display: flex;
            gap: 8px;
        }

        .countdown-segment {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(0, 0, 0, 0.3);
            padding: 8px 12px;
            border-radius: 8px;
            min-width: 60px;
        }

        .countdown-value {
            font-size: 20px;
            font-weight: 700;
            color: #00B8D4;
        }

        .countdown-label {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.6);
            text-transform: uppercase;
        }

        @media (max-width: 768px) {
            .event-banner-content {
                flex-direction: column;
                text-align: center;
            }

            .event-icon {
                font-size: 36px;
            }

            .countdown-segment {
                min-width: 50px;
                padding: 6px 8px;
            }

            .countdown-value {
                font-size: 16px;
            }
        }
    </style>
@endif

