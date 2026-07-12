@extends('layouts.app')

@section('title', 'Admin Dashboard - BlueGate Realty')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="dashboard-title fl-wrap">
            <h3>Admin Dashboard</h3>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn float-btn color-bg">Logout</button>
            </form>
        </div>

        <div class="app-stat-grid">
            <div class="app-stat"><span>Listings</span><strong>{{ number_format($listingCount) }}</strong></div>
            <div class="app-stat"><span>Published</span><strong>{{ number_format($publishedListingCount) }}</strong></div>
            <div class="app-stat"><span>Parcels</span><strong>{{ number_format($parcelCount) }}</strong></div>
            <div class="app-stat"><span>Available plots</span><strong>{{ number_format($availableParcelCount) }}</strong></div>
        </div>

        <div class="dasboard-widget-box fl-wrap" style="margin-top: 24px;">
            <div class="dashboard-title fl-wrap">
                <h3>Manage Site</h3>
            </div>
            <div class="row">
                <div class="col-md-4"><a class="btn float-btn color-bg" href="{{ route('admin.listings.index') }}">Listings</a></div>
                <div class="col-md-4"><a class="btn float-btn color-bg" href="{{ route('admin.parcels.index') }}">Parcels</a></div>
                <div class="col-md-4"><a class="btn float-btn color-bg" href="{{ route('admin.services.index') }}">Services</a></div>
                <div class="col-md-4"><a class="btn float-btn color-bg" href="{{ route('admin.content.index') }}">Content</a></div>
                <div class="col-md-4"><a class="btn float-btn color-bg" href="{{ route('admin.team.index') }}">Team</a></div>
                <div class="col-md-4"><a class="btn float-btn color-bg" href="{{ route('admin.faqs.index') }}">FAQs</a></div>
            </div>
        </div>

        <div class="app-stat-grid" style="margin-top: 24px;">
            <div class="app-stat"><span>Active services</span><strong>{{ number_format($serviceCount) }}</strong></div>
            <div class="app-stat"><span>Published posts</span><strong>{{ number_format($blogPostCount) }}</strong></div>
            <div class="app-stat"><span>Team members</span><strong>{{ number_format($teamCount) }}</strong></div>
            <div class="app-stat"><span>FAQs</span><strong>{{ number_format($faqCount) }}</strong></div>
        </div>
    </div>
</section>
@endsection
