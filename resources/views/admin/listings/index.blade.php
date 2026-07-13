@extends('layouts.admin')

@section('title', 'Admin Listings - SOMA PROPERTIES')
@section('admin-title', 'Property Listings')

@section('admin-content')
<div class="dashboard-title">
    <div class="dashboard-title-item"><span>Property Listings</span></div>
    <a class="btn float-btn color-bg" href="{{ route('admin.listings.create') }}" style="position: absolute; right: 30px; top: 50%; transform: translateY(-50%);">Add Listing</a>
</div>
<div class="dasboard-widget-box fl-wrap">
    <table class="app-table">
        <thead><tr><th>Title</th><th>Type</th><th>Price</th><th>Status</th><th>Published</th><th></th></tr></thead>
        <tbody>
            @foreach($listings as $listing)
                <tr>
                    <td>{{ $listing->title }}</td>
                    <td>{{ ucfirst($listing->type) }}</td>
                    <td>{{ $listing->formattedPrice() }}</td>
                    <td>{{ ucfirst($listing->status) }}</td>
                    <td>{{ $listing->is_published ? 'Yes' : 'No' }}</td>
                    <td><a href="{{ route('admin.listings.edit', $listing) }}">Edit</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
