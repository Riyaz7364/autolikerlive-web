<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facebook Settings - AutoLikerLive Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <span class="navbar-brand">AutoLikerLive - Facebook Settings</span>
            <a href="{{ route('admin.listings.index') }}" class="btn btn-outline-light btn-sm">Back to Listings</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

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
                                @enderror>
                                <div class="form-text">Format: <code>datr=VALUE; sb=VALUE</code> — include both datr and sb cookies separated by a semicolon.</div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Save Settings</button>
                                <a href="{{ route('admin.listings.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
