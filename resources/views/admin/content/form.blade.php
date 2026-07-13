@extends('layouts.admin')

@section('title', 'Edit Content - SOMA PROPERTIES')
@section('admin-title', 'Website Content')

@section('admin-content')
<div class="list-single-main-item fl-wrap">
    <div class="list-single-main-item-title"><h3>Edit {{ $content->key }}</h3></div>
    <form method="POST" action="{{ route('admin.content.update', $content) }}" class="custom-form">
        @csrf
        @method('PUT')
        <label>Title</label><input name="title" value="{{ old('title', $content->title) }}" required>
        <label>Subtitle</label><input name="subtitle" value="{{ old('subtitle', $content->subtitle) }}">
        <label>Image path</label><input name="image_path" value="{{ old('image_path', $content->image_path) }}">
        <label>Body</label><textarea name="body" rows="8">{{ old('body', $content->body) }}</textarea>
        <button class="btn float-btn color-bg" type="submit">Save Content</button>
    </form>
</div>
@endsection
