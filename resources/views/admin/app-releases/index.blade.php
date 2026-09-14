@extends('admin.layout')

@section('title', 'App Updates')
@section('heading', 'App Updates')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span class="fw-bold">All Apps ({{ $apps->total() }})</span>
        <a href="{{ route('admin.app-releases.create') }}" class="btn btn-success btn-sm">+ Add App</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>App Key</th>
                    <th>Name</th>
                    <th>Version</th>
                    <th>Release Code</th>
                    <th>APK</th>
                    <th>Status</th>
                    <th>API / Download</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($apps as $app)
                    <tr>
                        <td><code>{{ $app->app_name }}</code></td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($app->icon_url)
                                    <img src="{{ $app->icon_url }}" alt="{{ $app->name }} icon" style="width:36px;height:36px;border-radius:10px;object-fit:cover;border:1px solid #dee2e6;">
                                @endif
                                <strong>{{ $app->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $app->version }}</td>
                        <td><span class="badge bg-secondary">{{ $app->release_code }}</span></td>
                        <td>
                            @if ($app->apk_path)
                                <span class="badge bg-success">Uploaded</span>
                                <div class="small text-muted">{{ $app->apk_original_name }}@if($app->apk_size) ({{ number_format($app->apk_size / 1024 / 1024, 1) }} MB)@endif</div>
                                <div class="small text-muted">Saves as: <code>{{ $app->download_filename }}</code></div>
                            @else
                                <span class="badge bg-warning text-dark">No APK</span>
                            @endif
                        </td>
                        <td>
                            {!! $app->is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Disabled</span>' !!}
                            @if($app->force_update) <span class="badge bg-danger">Force</span> @endif
                        </td>
                        <td class="small">
                            <div><code>/api/app-update/{{ $app->app_name }}</code></div>
                            @if($app->apk_path)
                                <a href="{{ route('apk.download.app', $app->app_name) }}" target="_blank">Download APK</a>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('admin.app-releases.edit', $app->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="POST" action="{{ route('admin.app-releases.destroy', $app->id) }}" class="d-inline" onsubmit="return confirm('Delete {{ $app->name }} and its APK?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">No apps yet. Add your 2 apps here — more can be added any time.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($apps, 'links'))
    <div class="card-footer">{{ $apps->links() }}</div>
    @endif
</div>
@endsection
