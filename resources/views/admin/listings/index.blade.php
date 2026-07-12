@extends('layouts.app')

@section('title', 'Admin Listings - BlueGate Realty')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="dashboard-title fl-wrap">
            <h3>Property Listings</h3>
            <a class="btn float-btn color-bg" href="{{ route('admin.listings.create') }}">Add Listing</a>
        </div>
        @if(session('status'))<p>{{ session('status') }}</p>@endif
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
    </div>
</section>
@endsection
