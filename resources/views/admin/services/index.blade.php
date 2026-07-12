@extends('layouts.app')

@section('title', 'Admin Services - BlueGate Realty')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="dashboard-title fl-wrap">
            <h3>Agency Services</h3>
            <a class="btn float-btn color-bg" href="{{ route('admin.services.create') }}">Add Service</a>
        </div>
        @if(session('status'))<p>{{ session('status') }}</p>@endif
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
    </div>
</section>
@endsection
