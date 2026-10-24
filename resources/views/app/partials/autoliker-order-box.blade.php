@php
    $serviceKey = $service['key'] ?? 'like';
    $cost = max(0, (int) ($service['cost'] ?? 0));
    $min = max(1, (int) ($service['min'] ?? 1));
    $max = max($min, (int) ($service['max'] ?? $min));
    $quantity = max($min, min($max, (int) ($service['quantity'] ?? $max)));
    $total = $cost * $quantity;
    $accent = $accent ?? '#1877f2';
    $unitLabel = $cost === 1 ? 'credit' : 'credits';
@endphp

<div class="order-box"
     id="{{ $serviceKey }}-order-box"
     data-service="{{ $serviceKey }}"
     data-cost="{{ $cost }}"
     data-min="{{ $min }}"
     data-max="{{ $max }}"
     data-quantity="{{ $quantity }}">
    <div class="order-box-head">
        <span class="order-badge" style="background: {{ $accent }};">
            <i class="fas fa-bolt"></i> Instant Order
        </span>
        <span class="order-rate">{{ $cost }} {{ $unitLabel }} / unit</span>
    </div>

    <div class="order-qty-row">
        <button type="button" class="qty-step" data-step="-1" aria-label="Decrease quantity">&minus;</button>
        <input type="number"
               class="order-qty"
               value="{{ $quantity }}"
               min="{{ $min }}"
               max="{{ $max }}"
               step="1"
               inputmode="numeric"
               aria-label="Order quantity">
        <button type="button" class="qty-step" data-step="1" aria-label="Increase quantity">+</button>
    </div>

    <div class="order-total-row order-storage-row">
        <span>Storage Credits</span>
        <span class="order-storage-actions">
            <strong><span class="storage-credits-value">{{ $credits['storage'] }}</span></strong>
            <button type="button" class="btn-primary open-storage-btn">
                <i class="fa-solid fa-warehouse"></i> Open Storage
            </button>
        </span>
    </div>

    <div class="order-total-row">
        <span>Total cost</span>
        <strong class="order-total" data-total>{{ $total }} credits</strong>
    </div>
    <div class="order-hint">Min {{ $min }} &middot; Max {{ $max }}</div>
</div>
