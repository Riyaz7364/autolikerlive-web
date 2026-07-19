<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Listing - AutoLikerLive Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <span class="navbar-brand">AutoLikerLive - Listings Manager</span>
            <a href="{{ route('admin.listings.index') }}" class="btn btn-outline-light btn-sm">Back to Listings</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Edit: {{ $listing->name }}</span>
                        <a href="{{ url(str_replace(' ', '-', strtolower($listing->name))) }}" target="_blank" class="btn btn-outline-primary btn-sm">View Live</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.listings.update', $listing->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Keyword / Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $listing->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">URL: /{{ str_replace(' ', '-', strtolower(old('name', $listing->name))) }}</div>
                            </div>

                            <div class="mb-3">
                                <label for="post_id" class="form-label">WordPress Blog Post ID</label>
                                <input type="number" name="post_id" id="post_id" class="form-control @error('post_id') is-invalid @enderror"
                                       value="{{ old('post_id', $listing->post_id) }}" placeholder="e.g. 53">
                                @error('post_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">The WordPress post ID from the blog. Leave empty if no blog post yet.</div>
                                @if ($listing->post_id)
                                    <div class="mt-1">
                                        <a href="https://www.autolikerlive.com/blog/wp-json/trs/v1/post/{{ $listing->post_id }}" target="_blank" class="text-decoration-none">
                                            View Blog Post API <i class="small">&#8599;</i>
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror"
                                       value="{{ old('type', $listing->type ?? 'tool') }}">
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update Listing</button>
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
