@extends('layouts.game')

@section('title', 'Login')
@section('description', 'Login to create your fun image game.')

@section('content')
<div class="login-page">
    <h1>🎮 Create Your Image</h1>
    <p class="subtitle">Choose how you'd like to login</p>

    @if (\Session::has('error'))
        <div class="alert alert-danger mb-12">{{ Session::get('error') }}</div>
    @endif
    @if (\Session::has('success'))
        <div class="alert alert-success mb-12">{{ Session::get('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mb-12">
            <ul class="m-0" style="padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="login-card">
        @php
            $sid = request()->cookie('game_session');
            $gameSession = $sid ? \App\Models\GameSession::find($sid) : null;
        @endphp

        @if ($gameSession)
            <div class="text-center">
                <div style="font-size:3rem;margin-bottom:12px;">
                    @if ($gameSession->profile_pic)
                        <img src="{{ $gameSession->profile_pic }}" alt="" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                    @else
                        👤
                    @endif
                </div>
                <h3 style="margin:0 0 4px;">{{ $gameSession->name ?? $gameSession->username }}</h3>
                <p class="text-secondary" style="font-size:0.85rem;margin-bottom:16px;">
                    Logged in as {{ is_numeric($gameSession->id) ? 'Guest' : 'Facebook' }}
                </p>
                <div style="display:flex;gap:10px;justify-content:center;">
                    <a href="{{ request('redirect', url('/')) }}" class="fb-btn">Continue →</a>
                    <a href="{{ route('session.logout') }}" class="fb-btn fb-btn-outline" style="color:#dc3545;border-color:#dc3545;">Log Out</a>
                </div>
            </div>
        @else
            <div class="tab-bar">
                <button class="tab active" onclick="switchTab('auto', event)">Auto</button>
                <button class="tab" onclick="switchTab('manual', event)">Manual</button>
            </div>

            <div class="tab-content active" id="tab-auto">
                <form method="POST" action="{{ route('session.login.fb') }}">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request('redirect', url()->previous() !== url()->current() ? url()->previous() : '/') }}">
                    <div class="form-group">
                        <label>Facebook Username or URL</label>
                        <input name="fburl" type="text" class="fb-input" placeholder="e.g. zuck or https://facebook.com/zuck" value="{{ old('fburl') }}" required>
                        @error('fburl') <span style="color:#c62828;font-size:0.75rem;">{{ $message }}</span> @enderror
                        <div class="hint">We'll fetch your public profile info (name, picture, ID). No password needed.</div>
                    </div>
                    <button type="submit" class="fb-btn w-full py-14">Continue with Facebook</button>
                </form>
            </div>

            <div class="tab-content" id="tab-manual">
                <form method="POST" action="{{ route('session.login.manual') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request('redirect', url()->previous() !== url()->current() ? url()->previous() : '/') }}">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input name="name" type="text" class="fb-input" placeholder="Enter your name" value="{{ old('name') }}" required>
                        @error('name') <span style="color:#c62828;font-size:0.75rem;">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label>Profile Photo (optional)</label>
                        <div class="file-input-wrap">
                            <input name="image" type="file" accept="image/*">
                            <div class="file-label">
                                <span id="fileLabelText">📷 Choose a photo</span>
                            </div>
                        </div>
                        @error('image') <span style="color:#c62828;font-size:0.75rem;">{{ $message }}</span> @enderror
                        <div class="hint">Upload any image to use as your profile picture.</div>
                    </div>
                    <button type="submit" class="fb-btn w-full py-14">Continue as Guest</button>
                </form>
            </div>
        @endif
    </div>
</div>
@stop

@section('sidebar')
    <div class="widget">
        <h3>🔐 Why Login?</h3>
        <p>We need your name and profile picture to generate a personalized image just for you.</p>
    </div>
    <div class="widget">
        <h3>📋 How It Works</h3>
        <ol class="styled-ol">
            <li>Choose Auto (Facebook) or Manual (Guest)</li>
            <li>Enter your details</li>
            <li>Get your personalized image</li>
            <li>Share with friends!</li>
        </ol>
    </div>
    <div class="widget">
        <h3>⚠️ Privacy</h3>
        <p>We only use your public info. No data is stored permanently.</p>
    </div>
@stop

@push('footer')
<script>
function switchTab(tab, e) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab').forEach(el => el.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    e.target.classList.add('active');
}

document.querySelector('input[type="file"]')?.addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        document.getElementById('fileLabelText').textContent = '📸 ' + this.files[0].name;
    }
});
</script>
@endpush
