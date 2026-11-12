@extends('admin.layout')

@section('title', 'Ads')
@section('heading', 'Ads Manager')

@section('content')
    <form method="POST" action="{{ route('admin.ads.update') }}">
        @csrf
        @method('PUT')

        {{-- Ad networks --}}
        <div class="card shadow-sm border-0 mb-3" style="border-top:4px solid #0d6efd !important;">
            <div class="card-header fw-bold">Ad Networks</div>
            <div class="card-body">
                @foreach($ads['networks'] as $network)
                    <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2 bg-light">
                        <div>
                            <div class="fw-semibold">{{ $network['label'] }}</div>
                            <div class="text-muted small">{{ $network['description'] }}</div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   id="network-{{ $network['key'] }}" name="{{ $network['key'] }}_enabled" value="1"
                                   @checked($network['value'])>
                            <label class="form-check-label" for="network-{{ $network['key'] }}">Enabled</label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Google AdSense units --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header fw-bold">Google AdSense Units</div>
            <div class="card-body">
                @foreach($ads['units'] as $unit)
                    @if($unit['network'] === 'adsense')
                        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">
                            <div>
                                <div class="fw-semibold">{{ $unit['label'] }}</div>
                                <div class="text-muted small">{{ $unit['description'] }}</div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       id="unit-{{ $unit['key'] }}" name="{{ $unit['key'] }}" value="1"
                                       @checked($unit['value'])>
                                <label class="form-check-label" for="unit-{{ $unit['key'] }}">Enabled</label>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Adsterra units --}}
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header fw-bold">Adsterra Ad Units</div>
            <div class="card-body">
                @foreach($ads['units'] as $unit)
                    @if($unit['network'] === 'adsterra')
                        <div class="d-flex justify-content-between align-items-center border rounded p-3 mb-2">
                            <div>
                                <div class="fw-semibold">{{ $unit['label'] }}</div>
                                <div class="text-muted small">{{ $unit['description'] }}</div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch"
                                       id="unit-{{ $unit['key'] }}" name="{{ $unit['key'] }}" value="1"
                                       @checked($unit['value'])>
                                <label class="form-check-label" for="unit-{{ $unit['key'] }}">Enabled</label>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Ad Settings</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
        </div>
    </form>
@endsection
