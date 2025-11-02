<div class="redeem-card" data-bs-toggle="modal" data-bs-target="#redeemModal-{{ $withdrawal->id }}"
    style="background: {{ $withdrawal->bg_color }}; cursor: pointer;">
    <img src="{{ url($withdrawal->cover) }}" class="redeem-card-img" alt="{{ $withdrawal->name }}" />
    <div class="redeem-card-name">{{ $withdrawal->name }}</div>
</div>

@include($activeTemplate . '.partials.modals.cashout', ['withdrawal' => $withdrawal])
