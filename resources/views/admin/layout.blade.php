<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - AutoLikerLive Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .sidebar { min-height: 100vh; }
        .sidebar .nav-link { color: #ced4da; border-radius: 8px; margin-bottom: 2px; }
        .sidebar .nav-link:hover { background: #343a40; color: #fff; }
        .sidebar .nav-link.active { background: #0d6efd; color: #fff; }
        .stat-number { font-size: 2rem; font-weight: 700; }
        @media (max-width: 767px) { .sidebar { min-height: auto; } }
    </style>
    @stack('styles')
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar p-3">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand text-white fw-bold d-block mb-1">AutoLikerLive</a>
            <div class="text-secondary small mb-3">Unified Admin Panel</div>
            @php
                $current = Route::currentRouteName() ?? '';
                $isActive = fn($patterns) => collect((array) $patterns)->contains(fn($p) => str_starts_with($current, $p));
            @endphp
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ $current === 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">&#127968; Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $isActive('admin.listings') ? 'active' : '' }}" href="{{ route('admin.listings.index') }}">&#128221; Listings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $isActive('admin.facebook-settings') ? 'active' : '' }}" href="{{ route('admin.facebook-settings') }}">&#128293; Facebook Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $isActive('game.editor') ? 'active' : '' }}" href="{{ route('game.editor.list') }}">&#127918; Games Control</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $isActive('admin.app-releases') ? 'active' : '' }}" href="{{ route('admin.app-releases.index') }}">&#128241; App Updates</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $isActive('admin.promotions') ? 'active' : '' }}" href="{{ route('admin.promotions.index') }}">&#128226; Promotions</a>
                </li>
            </ul>
            <hr class="border-secondary">
            <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm w-100">Back to Site</a>
        </nav>

        <main class="col-md-9 col-lg-10 px-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4 mb-0">@yield('heading', 'Admin')</h1>
                <span class="text-muted small d-none d-md-block">{{ $current }}</span>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
