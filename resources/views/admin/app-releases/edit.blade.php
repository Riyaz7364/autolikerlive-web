@extends('admin.layout')

@section('title', 'Edit ' . $release->name)
@section('heading', 'Edit App: ' . $release->name)

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        @if($release->apk_path)
            <div class="alert alert-info">
                Current APK: <strong>{{ $release->apk_original_name }}</strong>
                @if($release->apk_size) ({{ number_format($release->apk_size / 1024 / 1024, 1) }} MB) @endif
                — <a href="{{ route('apk.download.app', $release->app_name) }}" target="_blank">Download</a><br>
                <span class="small">Visitors download it as <code>{{ $release->download_filename }}</code>. API: <code>/api/app-update/{{ $release->app_name }}</code></span>
            </div>
        @endif
        <div class="card shadow-sm">
            <div class="card-header fw-bold">App Details</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.app-releases.update', $release->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('admin.app-releases._form')
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                        <a href="{{ route('admin.app-releases.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
