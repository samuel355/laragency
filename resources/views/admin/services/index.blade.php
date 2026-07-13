@extends('layouts.admin')

@section('title', 'Admin Services - SOMA PROPERTIES')
@section('admin-title', 'Services')

@section('admin-content')
<div class="dashboard-title">
    <div class="dashboard-title-item"><span>Agency Services</span></div>
    <a class="btn float-btn color-bg" href="{{ route('admin.services.create') }}" style="position: absolute; right: 30px; top: 50%; transform: translateY(-50%);">Add Service</a>
</div>
<div class="dasboard-widget-box fl-wrap">
    <table class="app-table">
        <thead><tr><th>Title</th><th>Summary</th><th>Order</th><th>Active</th><th></th></tr></thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->title }}</td>
                    <td>{{ $service->summary }}</td>
                    <td>{{ $service->sort_order }}</td>
                    <td>{{ $service->is_active ? 'Yes' : 'No' }}</td>
                    <td><a href="{{ route('admin.services.edit', $service) }}">Edit</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
