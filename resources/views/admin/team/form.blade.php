@extends('layouts.admin')

@section('title', ($member->exists ? 'Edit' : 'Add').' Team Member - SOMA PROPERTIES')
@section('admin-title', 'Team')

@section('admin-content')
<div class="list-single-main-item fl-wrap">
    <div class="list-single-main-item-title"><h3>{{ $member->exists ? 'Edit Team Member' : 'Add Team Member' }}</h3></div>
    <form method="POST" action="{{ $member->exists ? route('admin.team.update', $member) : route('admin.team.store') }}" class="custom-form">
        @csrf
        @if($member->exists) @method('PUT') @endif
        <label>Name</label><input name="name" value="{{ old('name', $member->name) }}" required>
        <label>Role</label><input name="role" value="{{ old('role', $member->role) }}" required>
        <label>Email</label><input type="email" name="email" value="{{ old('email', $member->email) }}">
        <label>Phone</label><input name="phone" value="{{ old('phone', $member->phone) }}">
        <label>Image path</label><input name="image_path" value="{{ old('image_path', $member->image_path) }}" placeholder="/light/images/avatar/1.jpg">
        <label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order', $member->sort_order ?: 0) }}" required>
        <label>Bio</label><textarea name="bio" rows="8" required>{{ old('bio', $member->bio) }}</textarea>
        <label>Social links, one per line</label><textarea name="social_links" rows="4">{{ old('social_links', implode("\n", $member->social_links ?? [])) }}</textarea>
        <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $member->exists ? $member->is_active : true))> Active</label>
        @if($errors->any())<p class="error" style="color:#c0392b;">{{ $errors->first() }}</p>@endif
        <button class="btn float-btn color-bg" type="submit">Save Member</button>
    </form>
</div>
@endsection
