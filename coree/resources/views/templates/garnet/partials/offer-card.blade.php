<div class="offer-card-grid" data-bs-toggle="modal" data-bs-target="#ApiModal"
    data-name="{{ $name }}" data-creative="{{ $creative }}" data-payout="{{ number_format($payout, 2) }}"
    data-device="{{ $device }}" data-requirements="{{ $requirements }}" data-link="{{ $link }}"
    data-description="{{ $description }}" data-event='@json($event)'>
    
    <div class="offer-card-image">
        <img src="{{ $creative }}" alt="{{ $name }}" />
        @if(isset($event) && $event)
            <div class="offer-event-badge">{{ is_array($event) ? ($event['name'] ?? 'Event') : $event }}</div>
        @endif
    </div>
    
    <div class="offer-card-content">
        <h4 class="offer-card-title">{{ strlen($name) > 30 ? substr($name, 0, 30) . '...' : $name }}</h4>
        
        <div class="offer-card-footer">
            @php
                $formattedPayout = number_format($payout, 2);
                [$integerPart, $decimalPart] = explode('.', $formattedPayout);
            @endphp
            <div class="offer-payout">
                <span class="payout-integer">{{ $integerPart }}</span>.<span class="payout-decimal">{{ $decimalPart }}</span>
                <span class="payout-symbol">{{ siteSymbol() }}</span>
            </div>
            <div class="offer-device">
                <img src="{{ asset('assets/' . $activeTemplate . '/images/icons/' . ($device ?: 'desktop') . '.svg') }}" 
                     alt="{{ $device ?: 'desktop' }}" width="16" height="16" />
            </div>
        </div>
    </div>
</div>

<style>
.offer-card-grid {
    background: rgba(20, 25, 35, 0.6);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    overflow: hidden;
    cursor: pointer;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.offer-card-grid:hover {
    border-color: #00B8D4;
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 184, 212, 0.2);
}

.offer-card-image {
    width: 100%;
    height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
}

.offer-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.offer-event-badge {
    position: absolute;
    top: 8px;
    right: 8px;
    background: rgba(255, 152, 0, 0.9);
    color: #fff;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
}

.offer-card-content {
    padding: 12px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.offer-card-title {
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 12px;
    line-height: 1.3;
    min-height: 36px;
}

.offer-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.offer-payout {
    display: flex;
    align-items: baseline;
    gap: 2px;
}

.payout-integer {
    font-size: 20px;
    font-weight: 700;
    color: #00B8D4;
}

.payout-decimal {
    font-size: 14px;
    font-weight: 600;
    color: #00B8D4;
}

.payout-symbol {
    font-size: 12px;
    font-weight: 600;
    color: rgba(0, 184, 212, 0.8);
    margin-left: 2px;
}

.offer-device {
    opacity: 0.6;
}
</style>

