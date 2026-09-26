@extends('admin.layout')

@section('title', 'View Message')
@section('heading', 'View Message')

@section('content')
    <a href="{{ route('admin.mails.index', ['box' => $boxKey]) }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Back to {{ $boxes[$boxKey]['label'] }}</a>

    @if ($error)
        <div class="alert alert-danger">{{ $error }}</div>
    @elseif ($mail)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>{{ $mail['subject'] }}</strong>
                <form method="POST" action="{{ route('admin.mails.destroy', ['box' => $boxKey, 'uid' => $mail['uid']]) }}" onsubmit="return confirm('Delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                </form>
            </div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-sm-2">From</dt>
                    <dd class="col-sm-10">{{ $mail['from_name'] }} &lt;{{ $mail['from_email'] }}&gt;</dd>
                    <dt class="col-sm-2">To</dt>
                    <dd class="col-sm-10">{{ $mail['to'] }}</dd>
                    <dt class="col-sm-2">Date</dt>
                    <dd class="col-sm-10">{{ $mail['date'] ? $mail['date']->format('d M Y H:i:s') : '—' }}</dd>
                    @if (!empty($mail['attachments']))
                        <dt class="col-sm-2">Attachments</dt>
                        <dd class="col-sm-10">
                            @foreach ($mail['attachments'] as $att)
                                <span class="badge bg-secondary">{{ $att['name'] }} ({{ number_format($att['size'] / 1024, 1) }} KB)</span>
                            @endforeach
                        </dd>
                    @endif
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @if ($mail['body_html'])
                    <iframe sandbox srcdoc="{{ $mail['body_html'] }}" style="width:100%; min-height:500px; border:0; background:#fff;"></iframe>
                @else
                    <pre style="white-space:pre-wrap; margin-bottom:0;">{{ $mail['body_text'] }}</pre>
                @endif
            </div>
        </div>
    @endif
@endsection
