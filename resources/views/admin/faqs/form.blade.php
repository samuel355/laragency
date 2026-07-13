@extends('layouts.admin')

@section('title', ($faq->exists ? 'Edit' : 'Add').' FAQ - SOMA PROPERTIES')
@section('admin-title', 'FAQs')

@section('admin-content')
<div class="list-single-main-item fl-wrap">
    <div class="list-single-main-item-title"><h3>{{ $faq->exists ? 'Edit FAQ' : 'Add FAQ' }}</h3></div>
    <form method="POST" action="{{ $faq->exists ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" class="custom-form">
        @csrf
        @if($faq->exists) @method('PUT') @endif
        <label>Question</label><input name="question" value="{{ old('question', $faq->question) }}" required>
        <label>Category</label><input name="category" value="{{ old('category', $faq->category ?: 'General') }}" required>
        <label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?: 0) }}" required>
        <label>Answer</label><textarea name="answer" rows="8" required>{{ old('answer', $faq->answer) }}</textarea>
        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $faq->exists ? $faq->is_active : true))> Active</label>
        @if($errors->any())<p class="error" style="color:#c0392b;">{{ $errors->first() }}</p>@endif
        <button class="btn float-btn color-bg" type="submit">Save FAQ</button>
    </form>
</div>
@endsection
