@extends('layouts.app')

@section('title', 'Admin Content - BlueGate Realty')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="dashboard-title fl-wrap"><h3>Editable Content</h3></div>
        @if(session('status'))<p>{{ session('status') }}</p>@endif
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
    </div>
</section>
@endsection
