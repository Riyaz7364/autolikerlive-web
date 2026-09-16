@extends('admin.layout')

@section('title', 'Dashboard')
@section('heading', 'Dashboard — all tools in one place')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <div class="stat-number text-primary">{{ $stats['listings_total'] }}</div>
                <div class="text-muted">Listings</div>
                <a href="{{ route('admin.listings.index') }}" class="btn btn-sm btn-outline-primary mt-2">Manage</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <div class="stat-number text-success">{{ $stats['games_total'] }}</div>
                <div class="text-muted">Games ({{ $stats['games_published'] }} published)</div>
                <a href="{{ route('game.editor.list') }}" class="btn btn-sm btn-outline-success mt-2">Games Control</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <div class="stat-number text-info">{{ $stats['apps_total'] }}</div>
                <div class="text-muted">Apps ({{ $stats['apps_active'] }} active)</div>
                <a href="{{ route('admin.app-releases.index') }}" class="btn btn-sm btn-outline-info mt-2">App Updates</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0" style="border-top:3px solid #7c3aed !important">
            <div class="card-body text-center">
                <div class="stat-number" style="color:#7c3aed">{{ $stats['promotions_active'] ?? 0 }}<span class="text-muted fs-6">/{{ $stats['promotions_total'] ?? 0 }}</span></div>
                <div class="text-muted">Promotions live</div>
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-sm btn-outline-primary mt-2">📣 Manage Promotions</a>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4" style="border-left:4px solid #7c3aed !important">
    <div class="card-body d-flex flex-wrap gap-3 align-items-center justify-content-between">
        <div>
            <div class="fw-bold">📣 Promote your Instagram Comment Liker app</div>
            <div class="text-muted small">Active promos show automatically on Free TikTok Views + Free TikTok Likes, right under the tool card.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.promotions.index') }}" class="btn btn-sm btn-primary">Open Promotions</a>
            <a href="{{ route('admin.promotions.create') }}" class="btn btn-sm btn-success">+ New Promotion</a>
        </div>
    </div>
    @if(($promotions ?? collect())->count())
    <ul class="list-group list-group-flush">
        @foreach($promotions as $promo)
        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span><strong>{{ $promo->emoji }} {{ $promo->title }}</strong> <span class="text-muted small">— {{ $promo->name }}</span></span>
            <span class="d-flex gap-2 align-items-center">
                {!! $promo->is_active ? '<span class="badge bg-success">Live</span>' : '<span class="badge bg-secondary">Paused</span>' !!}
                <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
            </span>
        </li>
        @endforeach
    </ul>
    @endif
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold">App Updates</span>
                <a href="{{ route('admin.app-releases.create') }}" class="btn btn-sm btn-success">+ Add App</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr><th>App</th><th>Version</th><th>Code</th><th>APK</th><th></th></tr>
                    </thead>
                    <tbody>
                        @forelse ($apps as $app)
                            <tr>
                                <td><strong>{{ $app->name }}</strong><br><code class="small">{{ $app->app_name }}</code></td>
                                <td>{{ $app->version }}</td>
                                <td><span class="badge bg-secondary">{{ $app->release_code }}</span></td>
                                <td>{!! $app->apk_path ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-warning text-dark">No</span>' !!}</td>
                                <td><a href="{{ route('admin.app-releases.edit', $app->id) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No apps yet. <a href="{{ route('admin.app-releases.create') }}">Add your first app</a>.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer small text-muted">
                API: <code>GET /api/app-update/{app_name}</code> &nbsp; Download: <code>/download/apk/{app_name}</code>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card shadow-sm mb-3">
            <div class="card-header fw-bold">Quick Links</div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.listings.index') }}" class="list-group-item list-group-item-action">Listings Manager</a>
                <a href="{{ route('admin.listings.create') }}" class="list-group-item list-group-item-action">+ New Listing</a>
                <a href="{{ route('admin.facebook-settings') }}" class="list-group-item list-group-item-action">Facebook Settings</a>
                <a href="{{ route('game.editor.list') }}" class="list-group-item list-group-item-action">Games Control Panel</a>
                <a href="{{ route('game.editor.create') }}" class="list-group-item list-group-item-action">+ New Game</a>
                <a href="{{ route('admin.app-releases.index') }}" class="list-group-item list-group-item-action">App Updates</a>
                <a href="{{ route('admin.promotions.index') }}" class="list-group-item list-group-item-action">📣 Promotions</a>
            </div>
        </div>
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Recent Games</div>
            <ul class="list-group list-group-flush">
                @forelse ($recentGames as $game)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-truncate">{{ \Str::limit(resolveGameTitle($game->title), 30) }}</span>
                        <span class="badge bg-{{ $game->status === 'published' ? 'success' : 'secondary' }}">{{ $game->status }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted">No games yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Listings Snapshot</div>
            <div class="card-body text-center">
                <div class="display-6">{{ $stats['listings_linked'] }}<span class="text-muted fs-6">/{{ $stats['listings_total'] }}</span></div>
                <div class="text-muted small mb-2">linked to blog posts ({{ $stats['listings_unlinked'] }} unlinked)</div>
                <a href="{{ route('admin.listings.index') }}" class="btn btn-sm btn-outline-primary">Open Listings</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse ($recentListings as $listing)
                    <li class="list-group-item small">{{ $listing->name }}</li>
                @empty
                    <li class="list-group-item text-muted">No listings.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
