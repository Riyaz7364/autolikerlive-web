@extends('admin.layout')

@section('title', 'Incoming Mails')
@section('heading', 'Incoming Mails')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="btn-group mb-3" role="group">
                @foreach ($boxes as $key => $box)
                    <a href="{{ route('admin.mails.index', ['box' => $key]) }}"
                       class="btn {{ $boxKey === $key ? 'btn-primary' : 'btn-outline-primary' }}">{{ $box['label'] }}</a>
                @endforeach
            </div>
            <form method="GET" action="{{ route('admin.mails.index') }}" class="row g-2">
                <input type="hidden" name="box" value="{{ $boxKey }}">
                <div class="col-md-10">
                    <input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Search subject, sender, recipient...">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-secondary w-100" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    @if ($error)
        <div class="alert alert-danger">{{ $error }}</div>
    @elseif ($paginator)
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><strong>{{ $paginator->total() }}</strong> message(s) <span class="text-muted small">(last 90 days, newest first)</span></span>
                <a href="{{ route('admin.mails.index', ['box' => $boxKey, 'q' => $search]) }}" class="btn btn-sm btn-outline-secondary">Refresh</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width:34px;"></th>
                            <th>Subject</th>
                            <th>From</th>
                            <th>To</th>
                            <th style="white-space:nowrap;">Date</th>
                            <th style="width:110px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paginator as $mail)
                            <tr class="{{ $mail['seen'] ? '' : 'table-light fw-bold' }}">
                                <td>{{ $mail['seen'] ? '&#9898;' : '&#128309;' }}</td>
                                <td>
                                    <a href="{{ route('admin.mails.show', ['box' => $boxKey, 'uid' => $mail['uid']]) }}">
                                        {{ \Illuminate\Support\Str::limit($mail['subject'] ?: '(no subject)', 70) }}
                                    </a>
                                </td>
                                <td>
                                    <div>{{ $mail['from_name'] }}</div>
                                    <div class="text-muted small">{{ $mail['from_email'] }}</div>
                                </td>
                                <td class="small">{{ $mail['to'] }}</td>
                                <td class="small" style="white-space:nowrap;">{{ $mail['date'] ? $mail['date']->format('d M Y H:i') : '—' }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.mails.destroy', ['box' => $boxKey, 'uid' => $mail['uid']]) }}" onsubmit="return confirm('Delete this message?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-muted py-4">No messages found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($paginator->hasPages())
                <div class="card-footer">{{ $paginator->links() }}</div>
            @endif
        </div>
    @endif
@endsection
