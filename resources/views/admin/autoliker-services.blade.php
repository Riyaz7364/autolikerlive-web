@extends('admin.layout')

@section('title', 'AutoLiker Services')
@section('heading', 'AutoLiker Services — delivery mode, pricing & visibility')

@section('content')
<div class="alert alert-info">
    <strong>How it works:</strong>
    Each AutoLiker tab is driven by the backend <code>services</code> table.
    <ul class="mb-0 mt-2">
        <li><strong>WebSocket</strong> — the existing real-time service. Credits are charged by the backend per successful hit.</li>
        <li><strong>Order</strong> — places an order on the SMM provider (same provider as the Instagram Boost page). The order price is
            <code>quantity × credits per unit</code> and is deducted from the user's storage credits only after the provider accepts the order.</li>
        <li><strong>Visible</strong> — inactive services are hidden from the AutoLiker app tabs.</li>
    </ul>
</div>

<form method="POST" action="{{ route('admin.autoliker-services.update') }}">
    @csrf
    @method('PUT')

    <div class="row g-3">
        @foreach ($services as $service)
            @php
                $id = $service['id'];
                $isOrder = $service['mode'] === 'order';
                $total = (int) $service['min'] * (int) $service['cost'];
                $old = fn($field, $default = null) => old("services.$id.$field", $default);
            @endphp
            <div class="col-xl-4 col-lg-6">
                <div class="card shadow-sm h-100" style="border-top:4px solid {{ $service['enabled'] ? '#198754' : '#adb5bd' }}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <span class="fw-bold">{{ $service['name'] }}</span>
                            <div class="small text-muted">
                                <code>{{ $service['type'] }}</code> ·
                                {{ $service['enabled'] ? 'Visible' : 'Hidden' }} ·
                                {{ $isOrder ? 'Order service' : 'WebSocket service' }}
                            </div>
                        </div>
                        <button type="submit"
                                form="toggle-service-{{ $id }}"
                                class="btn btn-sm {{ $service['enabled'] ? 'btn-outline-warning' : 'btn-outline-success' }}">
                            {{ $service['enabled'] ? 'Hide' : 'Unhide' }}
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold">Visibility</label>
                                <select name="services[{{ $id }}][status]" class="form-select form-select-sm">
                                    <option value="active" @selected($old('status', $service['enabled'] ? 'active' : 'inactive') === 'active')>Visible</option>
                                    <option value="inactive" @selected($old('status', $service['enabled'] ? 'active' : 'inactive') === 'inactive')>Hidden</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Delivery</label>
                                <select name="services[{{ $id }}][mode]" class="form-select form-select-sm service-mode" data-id="{{ $id }}">
                                    <option value="websocket" @selected($old('mode', $service['mode']) === 'websocket')>WebSocket</option>
                                    <option value="order" @selected($old('mode', $service['mode']) === 'order')>Order (SMM)</option>
                                </select>
                            </div>

                            <div class="col-6">
                                <label class="form-label small fw-bold">Credits / unit</label>
                                <input type="number" min="0" max="100000" step="1"
                                       name="services[{{ $id }}][cost]"
                                       value="{{ $old('cost', $service['cost']) }}"
                                       class="form-control form-control-sm">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Default qty</label>
                                <input type="number" min="1" max="100000" step="1"
                                       name="services[{{ $id }}][quantity]"
                                       value="{{ $old('quantity', $service['quantity']) }}"
                                       class="form-control form-control-sm">
                            </div>

                            <div class="col-6">
                                <label class="form-label small fw-bold">Min qty</label>
                                <input type="number" min="1" max="100000" step="1"
                                       name="services[{{ $id }}][min]"
                                       value="{{ $old('min', $service['min']) }}"
                                       class="form-control form-control-sm">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Max qty</label>
                                <input type="number" min="1" max="100000" step="1"
                                       name="services[{{ $id }}][max]"
                                       value="{{ $old('max', $service['max']) }}"
                                       class="form-control form-control-sm">
                            </div>

                            <div class="col-12 order-provider" data-id="{{ $id }}">
                                <hr class="my-1">
                                <div class="small text-muted mb-2">SMM provider (used when Delivery = Order)</div>

                                <label class="form-label small fw-bold">Provider service ID</label>
                                <input type="text" maxlength="100"
                                       name="services[{{ $id }}][provider_id]"
                                       value="{{ $old('provider_id', $service['order_data']['id'] ?? $service['provider']['id'] ?? '') }}"
                                       class="form-control form-control-sm"
                                       placeholder="e.g. 4825">

                                <label class="form-label small fw-bold mt-2">Provider API URL</label>
                                <input type="text" maxlength="255"
                                       name="services[{{ $id }}][provider_api]"
                                       value="{{ $old('provider_api', $service['order_data']['api'] ?? '') }}"
                                       class="form-control form-control-sm"
                                       placeholder="{{ \App\Services\AutolikerServiceConfig::PROVIDER_API }}">

                                <label class="form-label small fw-bold mt-2">Provider API key</label>
                                <input type="text" maxlength="255"
                                       name="services[{{ $id }}][provider_key]"
                                       value="{{ $old('provider_key', $service['order_data']['key'] ?? '') }}"
                                       class="form-control form-control-sm"
                                       placeholder="Leave blank to use the default key">

                                @if ($service['key'] === 'comment')
                                    <label class="form-label small fw-bold mt-2">Comment field name</label>
                                    <input type="text" maxlength="50"
                                           name="services[{{ $id }}][comment_field]"
                                           value="{{ $old('comment_field', $service['order_data']['comment_field'] ?? '') }}"
                                           class="form-control form-control-sm"
                                           placeholder="comments">
                                @endif
                            </div>

                            <div class="col-12">
                                <div class="alert alert-light border mb-0 py-2 small">
                                    <div class="d-flex justify-content-between">
                                        <span>Minimum order price</span>
                                        <strong>{{ $total }} credits</strong>
                                    </div>
                                    <div class="text-muted">
                                        {{ $service['min'] }} × {{ $service['cost'] }} credits
                                        @if ($service['min'] !== $service['max'])
                                            · max {{ $service['max'] }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary">Save all services</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back to dashboard</a>
    </div>
</form>

@foreach ($services as $service)
    <form id="toggle-service-{{ $service['id'] }}" method="POST"
          action="{{ route('admin.autoliker-services.toggle', $service['id']) }}" class="d-none">
        @csrf
    </form>
@endforeach

<div class="card shadow-sm mt-4">
    <div class="card-header fw-bold">Recent AutoLiker orders</div>
    <div class="table-responsive">
        <table class="table table-sm table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Service</th>
                    <th>Link</th>
                    <th>Qty</th>
                    <th>Provider order</th>
                    <th>Status</th>
                    <th>Placed</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td><code>{{ $order->uid }}</code></td>
                        <td><span class="badge bg-secondary">{{ $order->service }}</span></td>
                        <td class="text-truncate" style="max-width:280px"><a href="{{ $order->link }}" target="_blank" rel="noopener">{{ $order->link }}</a></td>
                        <td>{{ $order->limit }}</td>
                        <td><code>{{ $order->order_id }}</code></td>
                        <td><span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'canceled' ? 'danger' : 'warning text-dark') }}">{{ $order->status }}</span></td>
                        <td class="small text-muted">{{ $order->created_at }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-3">No AutoLiker orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer small text-muted">
        Orders are also written to the existing <code>links</code> table, so <code>php artisan app:update-order-status</code> keeps their status in sync.
    </div>
</div>

<script>
    document.querySelectorAll('.service-mode').forEach(function (select) {
        var sync = function () {
            var holder = document.querySelector('.order-provider[data-id="' + select.dataset.id + '"]');
            if (holder) {
                holder.style.opacity = select.value === 'order' ? '1' : '.55';
            }
        };
        select.addEventListener('change', sync);
        sync();
    });
</script>
@endsection
