@extends('admin.layout')

@section('title', 'Promotions')
@section('heading', 'Promotions — cross-promote apps on high-traffic pages')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold">All Promotions ({{ $promotions->total() }})</span>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-success btn-sm">+ New Promotion</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Preview</th>
                    <th>Shows on</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($promotions as $promo)
                    <tr>
                        <td>
                            <strong>{{ $promo->name }}</strong>
                            <div class="small text-muted">Order: {{ $promo->sort_order }} · <code>{{ $promo->button_url }}</code></div>
                            @php $themeLabel = $promo->theme ?? 'default'; @endphp
                            @if($themeLabel === 'fb')<span class="badge" style="background:#1877F2">FB theme</span>
                            @elseif($themeLabel === 'instagram')<span class="badge" style="background:linear-gradient(45deg,#833AB4,#FD1D1D,#FCB045)">IG theme</span>
                            @else<span class="badge bg-secondary">Default theme</span>@endif
                            @if($promo->short_name)<span class="badge bg-light text-dark border">{{ $promo->short_name }}</span>@endif
                        </td>
                        <td style="max-width:320px">
                            <div class="small fw-bold">{{ $promo->emoji }} {{ $promo->title }}</div>
                            @if($promo->subtitle)<div class="small text-muted">{{ \Str::limit($promo->subtitle, 80) }}</div>@endif
                            @if($promo->badge_text)<span class="badge bg-warning text-dark">{{ $promo->badge_text }}</span>@endif
                            <span class="badge bg-primary">{{ $promo->button_text }}</span>
                        </td>
                        <td class="small">
                            @if($promo->show_on_tiktok_views)<span class="badge bg-dark">TikTok Views</span>@endif
                            @if($promo->show_on_tiktok_likes)<span class="badge bg-dark">TikTok Likes</span>@endif
                            @if($promo->show_on_fb_1000_likes ?? false)<span class="badge bg-primary">FB 1000 Popup</span>@endif
                            @if($promo->show_on_landing ?? false)<span class="badge bg-info text-dark">Landing Banner</span>@endif
                            @if($promo->show_on_homepage ?? false)<span class="badge bg-success">Homepage</span>@endif
                            @if($promo->show_on_tools ?? false)<span class="badge bg-warning text-dark">Tool pages</span>@endif
                            @if(!$promo->show_on_tiktok_views && !$promo->show_on_tiktok_likes && !($promo->show_on_fb_1000_likes ?? false) && !($promo->show_on_landing ?? false) && !($promo->show_on_homepage ?? false) && !($promo->show_on_tools ?? false))<span class="text-muted">Hidden</span>@endif
                        </td>
                        <td>
                            {!! $promo->is_active ? '<span class="badge bg-success">Live</span>' : '<span class="badge bg-secondary">Paused</span>' !!}
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ $promo->button_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">View</a>
                            <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.promotions.toggle', $promo->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $promo->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">{{ $promo->is_active ? 'Pause' : 'Enable' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.promotions.destroy', $promo->id) }}" class="d-inline" onsubmit="return confirm('Delete this promotion?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No promotions yet. <a href="{{ route('admin.promotions.create') }}">Create one to promote your Instagram Comment Liker app</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($promotions, 'links'))
    <div class="card-footer">{{ $promotions->links() }}</div>
    @endif
</div>
<div class="alert alert-info mt-3 mb-0">
    <strong>How it works:</strong> Active promotions appear automatically on your most-visited pages.
    TikTok placements show as inline banner under the tool card. <strong>FB 1000 Popup</strong> shows as a delayed modal with cross button on <code>/auto-liker-1000-likes</code>. <strong>Landing Banner</strong> shows as inline banner on SEO landing pages.     <strong>Tool pages</strong> covers <code>/call-bomber</code> and <code>/session/login</code> (browser pages — promos never show inside the Android WebView <code>/app/*</code> pages where redirects/downloads don't work). Pause anytime — pages update within 5 minutes (cache).
</div>
@endsection
