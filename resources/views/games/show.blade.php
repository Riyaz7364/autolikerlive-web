@extends('layouts.game')

@section('title', $game->title)
@section('description', $game->description)
@if($game->thumbnail)
@section('ogimage', asset('storage/' . $game->thumbnail))
@endif

@push('styles')
<style>
.modal-overlay {
    display: none;
    position: fixed; inset: 0; z-index: 9999;
    background: rgba(0,0,0,0.5);
    align-items: center; justify-content: center;
}
.modal-overlay.active { display: flex; }
.modal-box {
    background: #fff; border-radius: 12px;
    padding: 24px; max-width: 420px; width: 90%;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    max-height: 90vh; overflow-y: auto;
}
.modal-box h2 { margin: 0 0 16px; font-size: 1.1rem; }
.modal-field { margin-bottom: 14px; }
.modal-field label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; }
.modal-field input, .modal-field input[type="file"] { width: 100%; }
</style>
@endpush

@section('content')
<div class="pb-20">
    <div class="game-header">
        <h1>{{ $game->title }}</h1>

    </div>

    <div class="preview-frame">
        <div class="preview-img" id="previewEmoji" style="background: linear-gradient(135deg, {{ $game->bg_color ?? '#1a1a2e' }}, {{ $game->bg_color ?? '#16213e' }}); overflow:hidden;">
            @if ($game->thumbnail)
                <img src="{{ Storage::disk('public')->url($game->thumbnail) }}" alt="{{ $game->title }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                @switch($game->slug)
                    @case('which-bollywood-star-are-you') 🎬 @break
                    @case('my-facebook-superpower') ⚡ @break
                    @case('my-facebook-report-card') 📋 @break
                    @case('which-animal-are-you') 🦁 @break
                    @case('my-facebook-award') 🏆 @break
                    @default 🎮
                @endswitch
            @endif
        </div>
       
    </div>

    <div class="result-box" id="resultBox" style="display:none;">
        <img id="resultImage" src="" alt="Your Image">
        <div class="share-bar">
            <a id="fbShareBtn" href="#" target="_blank" class="fb-btn share-bar-btn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                Share on Facebook
            </a>
            <button class="fb-btn fb-btn-green" onclick="resetGame()">Create New</button>
        </div>
    </div>

    <div class="cta-section" id="ctaSection">
        @if ($session)
            <button class="cta-btn btn-create" id="generateBtn" onclick="startGame()">
                ✨ Create Your Image
            </button>
        @else
            <a href="{{ route('session.login', ['redirect' => url()->current()]) }}" class="cta-btn btn-create">
                ✨ Create Your Image
            </a>
        @endif
    </div>

    <div class="widget mt-16">
        <p class="text-xs text-center m-0 text-secondary">
            ⚠️ For entertainment purposes only. Results are randomly generated and not based on real data.
        </p>
    </div>
</div>

{{-- User Input Dialog --}}
<div class="modal-overlay" id="inputModal">
    <div class="modal-box">
        <h2>Fill in your details</h2>
        <form id="inputForm" onsubmit="submitWithInput(event)">
            @csrf
            @foreach ($userInputLayers as $layer)
                <div class="modal-field">
                    @if ($layer->source_type === 'ai')
                        <label style="margin-bottom:8px;">{{ $layer->prompt_label ?? 'Enter your details' }}</label>
                        @foreach ($layer->aiFields->sortBy('sort_order') as $field)
                            @php
                                $sessionKey = 'game_field_' . $field->field_key;
                                $existingVal = '';
                                if ($field->field_key === 'dob') $existingVal = $session->dob ?? '';
                                elseif ($field->field_key === 'name') $existingVal = $session->name ?? '';
                                else $existingVal = session($sessionKey, '');
                            @endphp
                            @if ($existingVal)
                                <input type="hidden" name="user_input[{{ $layer->id }}_{{ $field->field_key }}]" value="{{ $existingVal }}">
                            @else
                                <div style="margin-bottom:6px;">
                                    <label style="font-size:0.8rem;font-weight:500;margin-bottom:2px;">{{ $field->field_label }}</label>
                                    @if ($field->field_type === 'dob')
                                        <input type="date" name="user_input[{{ $layer->id }}_{{ $field->field_key }}]" class="fb-input" max="{{ date('Y-m-d') }}" required>
                                    @elseif ($field->field_type === 'number')
                                        <input type="number" name="user_input[{{ $layer->id }}_{{ $field->field_key }}]" class="fb-input" placeholder="{{ $field->field_placeholder }}" value="{{ $field->field_default }}" required>
                                    @elseif ($field->field_type === 'file')
                                        <input type="file" name="user_images[{{ $layer->id }}_{{ $field->field_key }}]" accept="image/*" required>
                                    @else
                                        <input type="text" name="user_input[{{ $layer->id }}_{{ $field->field_key }}]" class="fb-input" placeholder="{{ $field->field_placeholder }}" value="{{ $field->field_default }}" required>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @elseif ($layer->source_type === 'hidden')
                        <label style="margin-bottom:8px;">{{ $layer->prompt_label ?? 'Enter your details' }}</label>
                        @foreach ($layer->aiFields->sortBy('sort_order') as $field)
                            @php
                                $sessionKey = 'game_field_' . $field->field_key;
                                $existingVal = '';
                                if ($field->field_key === 'dob') $existingVal = $session->dob ?? '';
                                elseif ($field->field_key === 'name') $existingVal = $session->name ?? '';
                                else $existingVal = session($sessionKey, '');
                            @endphp
                            @if ($existingVal)
                                <input type="hidden" name="user_input[{{ $layer->id }}_{{ $field->field_key }}]" value="{{ $existingVal }}">
                            @else
                                <div style="margin-bottom:6px;">
                                    <label style="font-size:0.8rem;font-weight:500;margin-bottom:2px;">{{ $field->field_label }}</label>
                                    @if ($field->field_type === 'dob')
                                        <input type="date" name="user_input[{{ $layer->id }}_{{ $field->field_key }}]" class="fb-input" max="{{ date('Y-m-d') }}" required>
                                    @elseif ($field->field_type === 'number')
                                        <input type="number" name="user_input[{{ $layer->id }}_{{ $field->field_key }}]" class="fb-input" placeholder="{{ $field->field_placeholder }}" value="{{ $field->field_default }}" required>
                                    @elseif ($field->field_type === 'file')
                                        <input type="file" name="user_images[{{ $layer->id }}_{{ $field->field_key }}]" accept="image/*" required>
                                    @else
                                        <input type="text" name="user_input[{{ $layer->id }}_{{ $field->field_key }}]" class="fb-input" placeholder="{{ $field->field_placeholder }}" value="{{ $field->field_default }}" required>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    @else
                        @php
                            $existingVal = '';
                            if ($layer->source_type === 'dob') $existingVal = $session->dob ?? '';
                        @endphp
                        @if ($existingVal && $layer->source_type === 'dob')
                            <input type="hidden" name="user_input[{{ $layer->id }}]" value="{{ $existingVal }}">
                        @else
                            <label>{{ $layer->prompt_label ?? ($layer->source_type === 'dob' ? 'Date of Birth' : ($layer->source_type === 'manual' ? 'Text' : 'Upload Photo')) }}</label>
                            @if ($layer->source_type === 'dob')
                                <input type="date" name="user_input[{{ $layer->id }}]" class="fb-input" max="{{ date('Y-m-d') }}" required>
                            @elseif ($layer->source_type === 'manual')
                                <input type="text" name="user_input[{{ $layer->id }}]" class="fb-input" placeholder="{{ $layer->prompt_label ?? 'Enter value' }}" required>
                            @elseif ($layer->source_type === 'user')
                                <input type="file" name="user_images[{{ $layer->id }}]" accept="image/*" required>
                            @endif
                        @endif
                    @endif
                </div>
            @endforeach
            <button type="submit" class="fb-btn fb-btn-green w-full">Generate ✨</button>
        </form>
    </div>
</div>

@if ($game->description)
    <p>{{ $game->description }}</p>
@endif

@stop

@section('sidebar')
    <div class="widget">
        <h3>🎮 {{ $game->title }}</h3>
        <a href="{{ route('game.show', $game->slug) }}" class="fb-btn w-full">Play Now</a>
    </div>

    <div class="widget">
        <h3>📋 How It Works</h3>
        <ol class="styled-ol">
            <li>Click "Create Your Image"</li>
            <li>Login with Facebook or as Guest</li>
            <li>Get your personalized image</li>
            <li>Share with friends on Facebook!</li>
        </ol>
    </div>

    <div class="widget">
        <h3>📱 AutoLiker App</h3>
        <p style="font-size:0.85rem;margin:0 0 8px;">Get the official AutoLiker Android app</p>
        <a href="{{ url('/download') }}" class="fb-btn w-full" style="display:flex;align-items:center;justify-content:center;gap:6px;">
            ⬇️ Download AutoLiker app
        </a>
    </div>

    @php
        $otherGames = \App\Models\Game::where('status', 'published')
            ->where('id', '!=', $game->id)
            ->limit(5)
            ->get(['id', 'title', 'slug', 'description']);
    @endphp
    @if ($otherGames->count() > 0)
        <div class="widget">
            <h3>🎲 More Games</h3>
            @foreach ($otherGames as $og)
                <a href="{{ route('game.show', $og->slug) }}" class="widget-link">{{ $og->title }}</a>
            @endforeach
        </div>
    @endif

    <div class="widget">
        <h3>⚠️ Disclaimer</h3>
        <p>For entertainment purposes only. Results are randomly generated.</p>
    </div>
@stop

@push('footer')
<script>
function startGame() {
    @if ($hasUserInput)
        const form = document.getElementById('inputForm');
        const hasEmpty = form.querySelector('input[type=date]:not([type=hidden]), input[type=text]:not([type=hidden]):not([name=csrf_token]), input[type=number]:not([type=hidden]), input[type=file]');
        if (!hasEmpty) {
            submitWithInput(new Event('submit'));
        } else {
            document.getElementById('inputModal').classList.add('active');
        }
    @else
        callPlayApi(null);
    @endif
}

function submitWithInput(e) {
    e.preventDefault();
    const form = document.getElementById('inputForm');
    const fd = new FormData(form);
    document.getElementById('inputModal').classList.remove('active');
    if (form.querySelector('input[type=file]')) {
        callPlayApi(fd);
    } else {
        const data = {};
        form.querySelectorAll('input,select,textarea').forEach(el => {
            if (!el.name) return;
            const m = el.name.match(/^(\w+)\[(\w+)\]$/);
            if (m) {
                if (!data[m[1]]) data[m[1]] = {};
                data[m[1]][m[2]] = el.value;
            } else {
                data[el.name] = el.value;
            }
        });
        callPlayApi(data);
    }
}

function callPlayApi(data) {
    const btn = document.getElementById('generateBtn');
    btn.disabled = true;
    btn.textContent = '⏳ Generating...';

    const opts = {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
    };

    if (data instanceof FormData) {
        data.append('_token', '{{ csrf_token() }}');
        opts.body = data;
    } else if (data) {
        data._token = '{{ csrf_token() }}';
        opts.headers['Content-Type'] = 'application/json';
        opts.body = JSON.stringify(data);
    } else {
        opts.headers['Content-Type'] = 'application/json';
        opts.body = JSON.stringify({ _token: '{{ csrf_token() }}' });
    }

    fetch('{{ route('game.play', $game->slug) }}', opts)
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('resultImage').src = data.image_url;
            document.getElementById('fbShareBtn').href =
                'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(data.share_url);
            document.getElementById('resultBox').style.display = 'block';
            document.getElementById('ctaSection').style.display = 'none';
            document.getElementById('previewEmoji').style.display = 'none';
        } else {
            alert(data.error || 'Something went wrong');
        }
    })
    .catch(e => alert('Error: ' + e.message))
    .finally(() => {
        btn.disabled = false;
        btn.textContent = '✨ Create Your Image';
    });
}

function resetGame() {
    document.getElementById('resultBox').style.display = 'none';
    document.getElementById('ctaSection').style.display = 'block';
    document.getElementById('previewEmoji').style.display = 'flex';
}
</script>
@endpush
