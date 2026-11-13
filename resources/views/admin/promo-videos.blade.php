@extends('admin.layout')

@section('title', 'Promo Videos')
@section('heading', 'Promo Videos')

@section('content')
    @php($oldLinks = old('links', []))

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <p class="text-muted mb-0">
                These videos are shown randomly by the video gate. Set a link for each video — visitors open
                that link by clicking the video while it plays.
            </p>
        </div>
    </div>

    @if (empty($videos))
        <div class="alert alert-warning">
            No promotion videos found in <code>storage/app/public/promo_videos</code>.
        </div>
    @else
        <form method="POST" action="{{ route('admin.promo-videos.update') }}">
            @csrf
            @method('PUT')

            <div class="card shadow-sm border-0">
                <div class="card-header fw-bold">{{ count($videos) }} Promotion Video(s)</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 240px;">Preview</th>
                                    <th>File</th>
                                    <th style="min-width: 280px;">Link to open</th>
                                    <th style="width: 120px;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($videos as $video)
                                    <tr>
                                        <td>
                                            <video src="{{ $video['url'] }}" controls preload="metadata"
                                                   style="width: 220px; max-width: 100%; border-radius: 8px; background: #000;"></video>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-break">{{ $video['filename'] }}</div>
                                            <a href="{{ $video['url'] }}" target="_blank" rel="noopener"
                                               class="small">Open video file</a>
                                        </td>
                                        <td>
                                            <label class="form-label small text-muted" for="link-{{ $loop->index }}">
                                                Opens when this video is clicked
                                            </label>
                                            <input type="url" class="form-control" id="link-{{ $loop->index }}"
                                                   name="links[{{ $video['filename'] }}]"
                                                   value="{{ $oldLinks[$video['filename']] ?? $video['link'] }}"
                                                   placeholder="https://example.com">
                                        </td>
                                        <td>
                                            <a href="{{ $video['link'] }}" target="_blank" rel="noopener"
                                               class="btn btn-sm btn-outline-primary {{ $video['link'] ? '' : 'disabled' }}">
                                                Open link
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Save Links</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Back to Dashboard</a>
            </div>
        </form>
    @endif
@endsection