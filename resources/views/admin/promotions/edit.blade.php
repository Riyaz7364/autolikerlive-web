@extends('admin.layout')

@section('title', 'Edit Promotion')
@section('heading', 'Edit Promotion')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.promotions.update', $promotion->id) }}">
            @csrf
            @method('PUT')
            @include('admin.promotions._form')
            <div class="d-flex gap-2 mt-2">
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
