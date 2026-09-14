<div class="mb-3">
    <label for="app_name" class="form-label">App Key (for API lookup) <span class="text-danger">*</span></label>
    <input type="text" name="app_name" id="app_name" class="form-control @error('app_name') is-invalid @enderror"
           value="{{ old('app_name', $release->app_name ?? '') }}" placeholder="e.g. autolikerlive" required>
    @error('app_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Lowercase, no spaces. Your app calls <code>GET /api/app-update/<b>this-key</b></code>.</div>
</div>

<div class="mb-3">
    <label for="name" class="form-label">Display Name <span class="text-danger">*</span></label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $release->name ?? '') }}" placeholder="e.g. AutoLiker Live" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="version" class="form-label">Version <span class="text-danger">*</span></label>
        <input type="text" name="version" id="version" class="form-control @error('version') is-invalid @enderror"
               value="{{ old('version', $release->version ?? '1.0.0') }}" placeholder="e.g. 1.0.6" required>
        @error('version')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="release_code" class="form-label">Release Code <span class="text-danger">*</span></label>
        <input type="number" name="release_code" id="release_code" min="1" class="form-control @error('release_code') is-invalid @enderror"
               value="{{ old('release_code', $release->release_code ?? 1) }}" required>
        @error('release_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Integer the app compares to detect updates (e.g. 7).</div>
    </div>
</div>

<div class="mb-3">
    <label for="tagline" class="form-label">Button Subtitle (tagline)</label>
    <input type="text" name="tagline" id="tagline" maxlength="100" class="form-control @error('tagline') is-invalid @enderror"
           value="{{ old('tagline', $release->tagline ?? '') }}" placeholder="e.g. Instagram only">
    @error('tagline')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Small text under the download button on the download page.</div>
</div>

<div class="mb-3">
    <label for="icon" class="form-label">App Icon</label>
    @if(($release ?? null) && $release->icon_url)
        <div class="mb-2">
            <img src="{{ $release->icon_url }}" alt="Current app icon" style="width:56px;height:56px;border-radius:14px;object-fit:cover;border:1px solid #dee2e6;">
            <span class="small text-muted ms-1">Current icon — upload a new one to replace it.</span>
        </div>
    @endif
    <input type="file" name="icon" id="icon" accept="image/png,image/jpeg,image/webp" class="form-control @error('icon') is-invalid @enderror">
    @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Square PNG/JPG/WebP, max 2 MB. Shown on the download button.</div>
</div>

<div class="mb-3">
    <label for="apk_file" class="form-label">APK File {{ isset($release) ? '(leave empty to keep current)' : '' }}</label>
    <input type="file" name="apk_file" id="apk_file" accept=".apk" class="form-control @error('apk_file') is-invalid @enderror">
    @error('apk_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Max 200 MB. Stored under <code>storage/app/builds/</code>, served at <code>/download/apk/{app-key}</code>.</div>
</div>

<div class="mb-3">
    <label for="changelog" class="form-label">What's New / Changelog</label>
    <textarea name="changelog" id="changelog" rows="3" class="form-control @error('changelog') is-invalid @enderror"
              placeholder="Bug fixes and improvements...">{{ old('changelog', $release->changelog ?? '') }}</textarea>
    @error('changelog')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                   {{ old('is_active', $release->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active (visible in API)</label>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="force_update" value="1" id="force_update"
                   {{ old('force_update', $release->force_update ?? false) ? 'checked' : '' }}>
            <label class="form-check-label" for="force_update">Force update</label>
        </div>
    </div>
</div>
