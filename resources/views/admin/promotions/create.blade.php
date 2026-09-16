@extends('admin.layout')

@section('title', 'New Promotion')
@section('heading', 'New Promotion')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.promotions.store') }}">
            @csrf
            @include('admin.promotions._form')
            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-success">Create promotion</button>
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
