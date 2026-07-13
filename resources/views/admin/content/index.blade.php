@extends('layouts.admin')

@section('title', 'Admin Content - SOMA PROPERTIES')
@section('admin-title', 'Website Content')

@section('admin-content')
<div class="dashboard-title">
    <div class="dashboard-title-item"><span>Editable Content</span></div>
</div>
<div class="dasboard-widget-box fl-wrap">
    <table class="app-table">
        <thead><tr><th>Key</th><th>Title</th><th>Image</th><th></th></tr></thead>
        <tbody>
            @foreach($contents as $content)
                <tr>
                    <td>{{ $content->key }}</td>
                    <td>{{ $content->title }}</td>
                    <td>{{ $content->image_path }}</td>
                    <td><a href="{{ route('admin.content.edit', $content) }}">Edit</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
