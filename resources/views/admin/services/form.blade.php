@extends('layouts.app')

@section('title', ($service->exists ? 'Edit' : 'Add').' Service - BlueGate Realty')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="list-single-main-item fl-wrap">
            <div class="list-single-main-item-title"><h3>{{ $service->exists ? 'Edit Service' : 'Add Service' }}</h3></div>
            <form method="POST" action="{{ $service->exists ? route('admin.services.update', $service) : route('admin.services.store') }}" class="custom-form">
                @csrf
                @if($service->exists) @method('PUT') @endif
                <label>Title</label><input name="title" value="{{ old('title', $service->title) }}" required>
                <label>Summary</label><input name="summary" value="{{ old('summary', $service->summary) }}" required>
                <label>Icon class</label><input name="icon" value="{{ old('icon', $service->icon) }}" placeholder="fa-solid fa-house">
                <label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $service->sort_order ?: 0) }}" required>
                <label>Body</label><textarea name="body" rows="8" required>{{ old('body', $service->body) }}</textarea>
                <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->exists ? $service->is_active : true))> Active</label>
                @if($errors->any())<p class="error" style="color:#c0392b;">{{ $errors->first() }}</p>@endif
                <button class="btn float-btn color-bg" type="submit">Save Service</button>
            </form>
        </div>
    </div>
</section>
@endsection
