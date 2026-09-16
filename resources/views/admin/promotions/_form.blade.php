<div class="mb-3">
    <label for="name" class="form-label">Internal name <span class="text-danger">*</span></label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $promotion->name ?? '') }}" placeholder="e.g. InstaLiker launch" required>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Only visible in admin.</div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="badge_text" class="form-label">Badge (small pill)</label>
        <input type="text" name="badge_text" id="badge_text" maxlength="50" class="form-control @error('badge_text') is-invalid @enderror"
               value="{{ old('badge_text', $promotion->badge_text ?? '') }}" placeholder="e.g. NEW APP">
        @error('badge_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="emoji" class="form-label">Emoji / icon</label>
        <input type="text" name="emoji" id="emoji" maxlength="10" class="form-control @error('emoji') is-invalid @enderror"
               value="{{ old('emoji', $promotion->emoji ?? '📸') }}" placeholder="📸">
        @error('emoji')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3">
    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $promotion->title ?? '') }}" placeholder="e.g. Try our new Instagram Comment Liker app" required>
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label for="subtitle" class="form-label">Subtitle</label>
    <input type="text" name="subtitle" id="subtitle" maxlength="500" class="form-control @error('subtitle') is-invalid @enderror"
           value="{{ old('subtitle', $promotion->subtitle ?? '') }}" placeholder="e.g. Auto-like IG comments in minutes — free Android APK">
    @error('subtitle')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="button_text" class="form-label">Button text <span class="text-danger">*</span></label>
        <input type="text" name="button_text" id="button_text" maxlength="50" class="form-control @error('button_text') is-invalid @enderror"
               value="{{ old('button_text', $promotion->button_text ?? 'Try it now') }}" required>
        @error('button_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="button_url" class="form-label">Button URL <span class="text-danger">*</span></label>
        <input type="text" name="button_url" id="button_url" class="form-control @error('button_url') is-invalid @enderror"
               value="{{ old('button_url', $promotion->button_url ?? '/instagram-comment-liker') }}" required>
        @error('button_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Use <code>/instagram-comment-liker</code> to promote the new app.</div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="image_url" class="form-label">Image URL (optional)</label>
        <input type="text" name="image_url" id="image_url" class="form-control @error('image_url') is-invalid @enderror"
               value="{{ old('image_url', $promotion->image_url ?? '') }}" placeholder="e.g. /storage/instaliker/app_logo.webp">
        @error('image_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Square app icon works best. Leave empty to use emoji.</div>
    </div>
    <div class="col-md-6 mb-3">
        <label for="sort_order" class="form-label">Sort order</label>
        <input type="number" name="sort_order" id="sort_order" min="0" max="9999" class="form-control @error('sort_order') is-invalid @enderror"
               value="{{ old('sort_order', $promotion->sort_order ?? 0) }}">
        @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Lower shows first (0 = top).</div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="show_on_tiktok_views" value="1" id="show_on_tiktok_views"
                   {{ old('show_on_tiktok_views', $promotion->show_on_tiktok_views ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="show_on_tiktok_views">Show on TikTok Views</label>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="show_on_tiktok_likes" value="1" id="show_on_tiktok_likes"
                   {{ old('show_on_tiktok_likes', $promotion->show_on_tiktok_likes ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="show_on_tiktok_likes">Show on TikTok Likes</label>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                   {{ old('is_active', $promotion->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active (live on site)</label>
        </div>
    </div>
</div>
