@extends('admin.layout')

@section('title', 'Add App')
@section('heading', 'Add App')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header fw-bold">New App Release</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.app-releases.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('admin.app-releases._form')
                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary">Create App</button>
                        <a href="{{ route('admin.app-releases.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
