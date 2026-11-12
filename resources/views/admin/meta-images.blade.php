@extends('admin.layout')

@section('title', 'Meta Images')
@section('heading', 'Meta Images')

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header fw-bold">Open Graph &amp; Twitter images per route</div>
        <div class="card-body">
            <p class="text-muted small mb-4">
                Upload an image for each route, or paste an image URL / storage path. Leave the field blank to use the
                default image. Game pages always use the game thumbnail automatically.
            </p>

            @foreach($images as $image)
                <form method="POST" action="{{ route('admin.meta-images.update', $image) }}" enctype="multipart/form-data"
                      class="border rounded p-3 mb-3">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 align-items-start">
                        <div class="col-md-3">
                            <div class="fw-semibold">/{{ $image->key }}</div>
                            <div class="text-muted small">{{ $image->label }}</div>
                            @if($image->is_dynamic)
                                <span class="badge bg-info text-dark mt-1">Dynamic</span>
                            @endif
                        </div>

                        <div class="col-md-3">
                            @if($image->image)
                                <img src="{{ \App\Support\MetaImages::url($image->image) }}" alt=""
                                     class="img-fluid rounded border" style="max-height:110px;">
                            @else
                                <span class="text-muted small">No image set</span>
                            @endif
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small">Image URL or storage path</label>
                            <input type="text" name="image" value="{{ $image->image }}"
                                   class="form-control form-control-sm"
                                   placeholder="meta-images/{{ $image->key }}.webp">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small">Upload (max 4 MB)</label>
                            <input type="file" name="file" accept="image/*" class="form-control form-control-sm">
                        </div>

                        <div class="col-md-1 d-grid">
                            <label class="form-label small">&nbsp;</label>
                            <button class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
@endsection
