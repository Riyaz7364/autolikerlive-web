@extends('admin.layout')

@section('title', 'Create Listing')
@section('heading', 'Create New Listing')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Create New Listing</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.listings.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Keyword / Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required placeholder="e.g. Facebook Auto Followers">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">This becomes the URL slug: /facebook-auto-followers</div>
                    </div>

                    <div class="mb-3">
                        <label for="post_id" class="form-label">WordPress Blog Post ID</label>
                        <input type="number" name="post_id" id="post_id" class="form-control @error('post_id') is-invalid @enderror"
                               value="{{ old('post_id') }}" placeholder="e.g. 53">
                        @error('post_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">The WordPress post ID from the blog. Leave empty if no blog post yet.</div>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror"
                               value="{{ old('type', 'tool') }}" placeholder="e.g. tool">
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Create Listing</button>
                        <a href="{{ route('admin.listings.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
