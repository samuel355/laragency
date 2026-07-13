@extends('layouts.admin')

@section('title', 'Admin Parcels - SOMA PROPERTIES')
@section('admin-title', 'Land Parcels')

@section('admin-content')
<div class="dashboard-title">
    <div class="dashboard-title-item"><span>Parcel Admin</span></div>
    <a class="btn float-btn color-bg" href="{{ route('admin.parcels.create') }}" style="position: absolute; right: 30px; top: 50%; transform: translateY(-50%);">Add Parcel</a>
</div>
@php
    $statusCounts = $parcels->groupBy('status')->map->count();
@endphp
<div class="app-stat-grid" style="margin-bottom: 20px;">
    <div class="app-stat"><span>Total plots</span><strong>{{ number_format($parcels->count()) }}</strong></div>
    <div class="app-stat"><span>Available</span><strong>{{ number_format($statusCounts->get('available', 0)) }}</strong></div>
    <div class="app-stat"><span>Reserved</span><strong>{{ number_format($statusCounts->get('reserved', 0)) }}</strong></div>
    <div class="app-stat"><span>Sold</span><strong>{{ number_format($statusCounts->get('sold', 0)) }}</strong></div>
</div>
<div class="dasboard-widget-box fl-wrap">
    <table class="app-table">
        <thead>
            <tr>
                <th>Plot</th>
                <th>Title</th>
                <th>Price</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($parcels as $parcel)
                <tr>
                    <td>{{ $parcel->plot_number }}</td>
                    <td>{{ $parcel->title }}</td>
                    <td>{{ $parcel->currency }} {{ number_format((float) $parcel->price, 2) }}</td>
                    <td><span class="status-pill"><span class="status-dot" style="background: {{ $parcel->statusColor() }}"></span>{{ $parcel->statusLabel() }}</span></td>
                    <td><a href="{{ route('admin.parcels.edit', $parcel) }}">Edit</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
