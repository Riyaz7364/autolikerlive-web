@extends('layouts.autoliker')

@section('title', 'Settings - ' . $user['loginType'])
@section('description', '')

@section('content')
    <h1 class="alk-page-title">Settings</h1>

    <section class="alk-card" aria-label="Earn source settings">
        <div class="alk-card-title"><i class="bi bi-gear-fill"></i> Earn source</div>
        <p class="alk-muted" style="margin-bottom:14px;">Choose which platform you want to earn credits from.</p>

        <form method="post" action="{{ route('autoliker.settings.update') }}">
            @csrf
            <label class="alk-radio">
                <input type="radio" name="earn_source" value="FB"
                    {{ data_get($user, 'earnType') == 'FB' ? 'checked' : '' }}>
                <span>📘 Facebook <span class="alk-muted">— like &amp; follow FB posts</span></span>
            </label>

            <label class="alk-radio">
                <input type="radio" name="earn_source" value="IG"
                    {{ data_get($user, 'earnType') == 'IG' ? 'checked' : '' }}>
                <span>📸 Instagram <span class="alk-muted">— like &amp; follow IG posts</span></span>
            </label>

            <button class="alk-btn alk-btn-primary mt-2" type="submit">Save Settings</button>
        </form>
    </section>
@endsection
