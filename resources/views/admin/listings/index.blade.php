<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listings Manager - AutoLikerLive Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f2f5; }
        .stat-card { border: none; border-radius: 12px; }
        .stat-number { font-size: 2rem; font-weight: 700; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <span class="navbar-brand">AutoLikerLive - Listings Manager</span>
            <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm">Back to Site</a>
        </div>
    </nav>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-number text-primary">{{ $total }}</div>
                        <div class="text-muted">Total Listings</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-number text-success">{{ $linked }}</div>
                        <div class="text-muted">With Blog Post</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <div class="stat-number text-warning">{{ $unlinked }}</div>
                        <div class="text-muted">No Blog Post</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Search by name</label>
                        <input type="text" name="search" class="form-control" placeholder="e.g. facebook auto followers" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Filter</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="linked" {{ request('status') === 'linked' ? 'selected' : '' }}>With Blog Post</option>
                            <option value="unlinked" {{ request('status') === 'unlinked' ? 'selected' : '' }}>No Blog Post</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('admin.listings.index') }}" class="btn btn-outline-secondary">Clear</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-bold">All Listings</span>
                <a href="{{ route('admin.listings.create') }}" class="btn btn-success btn-sm">+ Add New</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Keyword / Name</th>
                            <th>Blog Post ID</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>URL</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($listings as $listing)
                            <tr>
                                <td>{{ $listing->id }}</td>
                                <td><strong>{{ $listing->name }}</strong></td>
                                <td>
                                    @if ($listing->post_id)
                                        <span class="badge bg-success">#{{ $listing->post_id }}</span>
                                    @else
                                        <span class="badge bg-secondary">None</span>
                                    @endif
                                </td>
                                <td>{{ $listing->type ?? '-' }}</td>
                                <td>
                                    @if ($listing->post_id)
                                        <span class="badge bg-success">Linked</span>
                                    @else
                                        <span class="badge bg-warning text-dark">No Post</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url(str_replace(' ', '-', strtolower($listing->name))) }}" target="_blank" class="text-decoration-none">
                                        /{{ str_replace(' ', '-', strtolower($listing->name)) }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.listings.edit', $listing->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="POST" action="{{ route('admin.listings.destroy', $listing->id) }}" class="d-inline" onsubmit="return confirm('Delete this listing?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No listings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $listings->withQueryString()->links() }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
