@extends('admin.layout')

@section('title', 'Website Leads')
@section('heading', 'Website Leads')

@section('content')
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-semibold">Total leads</div>
                    <div class="stat-number">{{ $total }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-semibold">New</div>
                    <div class="stat-number text-primary">{{ $newCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-semibold">Contacted</div>
                    <div class="stat-number text-success">{{ $contactedCount }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="text-muted small text-uppercase fw-semibold">Closed</div>
                    <div class="stat-number text-secondary">{{ $closedCount }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.website-leads.index') }}" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label for="q" class="form-label small text-muted mb-1">Search</label>
                    <input type="search" class="form-control" id="q" name="q" value="{{ $search }}"
                           placeholder="Name, email, company or message">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label small text-muted mb-1">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All statuses</option>
                        @foreach (['new', 'contacted', 'closed'] as $option)
                            <option value="{{ $option }}" @selected($status === $option)>{{ ucfirst($option) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    @if ($search !== '' || $status)
                        <a href="{{ route('admin.website-leads.index') }}" class="btn btn-outline-secondary">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="fw-bold">Enquiries from the main site and demo</span>
            <span class="text-muted small">{{ $leads->total() }} {{ \Illuminate\Support\Str::plural('lead', $leads->total()) }}</span>
        </div>

        @if ($leads->isEmpty())
            <div class="card-body text-center py-5">
                <h5 class="mb-2">No leads found</h5>
                <p class="text-muted mb-0">New submissions from the web solutions, services, and contact forms will appear here.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Contact</th>
                            <th>Project</th>
                            <th style="min-width: 260px;">Message</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th style="min-width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                                <td>
                                    <div class="fw-semibold">
                                        <a href="mailto:{{ $lead->email }}" class="text-decoration-none">{{ $lead->name }}</a>
                                    </div>
                                    <div class="small text-muted">
                                        <a href="mailto:{{ $lead->email }}" class="text-decoration-none">{{ $lead->email }}</a>
                                    </div>
                                    @if ($lead->phone)
                                        <div class="small"><a href="tel:{{ $lead->phone }}" class="text-decoration-none">{{ $lead->phone }}</a></div>
                                    @endif
                                    @if ($lead->company)
                                        <div class="small text-muted">{{ $lead->company }}</div>
                                    @endif
                                    <div class="small text-muted" title="{{ $lead->created_at->format('l, F j, Y \a\t g:i A') }}">
                                        {{ $lead->created_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td>
                                    @if ($lead->project_type)
                                        <span class="badge text-bg-light border">{{ ucwords(str_replace(['-', '_'], ' ', $lead->project_type)) }}</span>
                                    @endif
                                    @if ($lead->budget)
                                        <span class="badge text-bg-light border">{{ ucwords(str_replace(['-', '_'], ' ', $lead->budget)) }}</span>
                                    @endif
                                    @if (! $lead->project_type && ! $lead->budget)
                                        <span class="text-muted small">Not specified</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">{{ \Illuminate\Support\Str::limit($lead->message, 110) }}</div>
                                    @if (strlen($lead->message) > 110)
                                        <details class="mt-1">
                                            <summary class="small text-primary" style="cursor:pointer;">Read full message</summary>
                                            <div class="small text-muted mt-2" style="white-space:pre-line;">{{ $lead->message }}</div>
                                        </details>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge text-bg-light border">{{ ucwords(str_replace(['-', '_'], ' ', $lead->source)) }}</span>
                                    <div class="small text-muted">{{ $lead->ip_address ?: 'IP unavailable' }}</div>
                                </td>
                                <td>
                                    @php
                                        $badge = match ($lead->status) {
                                            'contacted' => 'success',
                                            'closed' => 'secondary',
                                            default => 'primary',
                                        };
                                    @endphp
                                    <span class="badge text-bg-{{ $badge }} text-capitalize">{{ $lead->status }}</span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.website-leads.status', $lead) }}" class="d-flex gap-1 mb-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm" aria-label="Status for {{ $lead->name }}">
                                            @foreach (['new', 'contacted', 'closed'] as $option)
                                                <option value="{{ $option }}" @selected($lead->status === $option)>{{ ucfirst($option) }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-dark">Save</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.website-leads.destroy', $lead) }}"
                                          onsubmit="return confirm('Delete this lead permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link btn-sm text-danger p-0">Delete lead</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $leads->links() }}
            </div>
        @endif
    </div>
@endsection