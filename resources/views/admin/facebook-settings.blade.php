@extends('admin.layout')

@section('title', 'Facebook Settings')
@section('heading', 'Facebook Service Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Facebook Service Settings</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.facebook-settings.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="lsd" class="form-label">LSD Token <span class="text-danger">*</span></label>
                        <input type="text" name="lsd" id="lsd" class="form-control @error('lsd') is-invalid @enderror"
                               value="{{ old('lsd', $setting->lsd) }}" placeholder="e.g. AdTuUrZmNxaQUwUfxWzM5RBoMpA">
                        @error('lsd')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">The LSD CSRF token used in Facebook bulk-route-definitions requests.</div>
                    </div>

                    <div class="mb-3">
                        <label for="fb_cookie" class="form-label">Facebook Cookie <span class="text-danger">*</span></label>
                        <textarea name="fb_cookie" id="fb_cookie" rows="3" class="form-control @error('fb_cookie') is-invalid @enderror"
                                  placeholder="datr=xxx; sb=xxx">{{ old('fb_cookie', $setting->fb_cookie) }}</textarea>
                        @error('fb_cookie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format: <code>datr=VALUE; sb=VALUE</code> — include both datr and sb cookies separated by a semicolon.</div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
