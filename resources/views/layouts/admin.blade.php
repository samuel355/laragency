@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('light/css/db-style.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('light/js/db-scripts.js') }}"></script>
@endpush

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="breadcrumbs-list bl_flat">
            <a href="{{ route('admin.dashboard') }}">Admin</a> <span>@yield('admin-title', 'Dashboard')</span>
            <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
        </div>
        <div class="main-content ms_vir_height">
            <div class="boxed-container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="boxed-content btf_init">
                            <div class="user-dasboard-menu_wrap">
                                <div class="user-dasboard-menu-header">
                                    <div class="user-dasboard-menu_header-avatar">
                                        <span>Welcome : <strong>{{ auth()->user()->name }}</strong></span>
                                        <div class="db-menu_modile_btn">
                                            <strong>Menu</strong><i class="fa-regular fa-bars"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="user-dasboard-menu faq-nav">
                                    <ul>
                                        <li><a href="{{ route('admin.dashboard') }}" @class(['act-scrlink' => request()->routeIs('admin.dashboard')])>Dashboard</a></li>
                                        <li><a href="{{ route('admin.listings.index') }}" @class(['act-scrlink' => request()->routeIs('admin.listings.*')])>Property Listings</a></li>
                                        <li><a href="{{ route('admin.parcels.index') }}" @class(['act-scrlink' => request()->routeIs('admin.parcels.*')])>Land Parcels</a></li>
                                        <li>
                                            <a href="{{ route('admin.requests.index') }}" @class(['act-scrlink' => request()->routeIs('admin.requests.*')])>
                                                Requests @if($newLeadsCount > 0)<span>{{ $newLeadsCount }}</span>@endif
                                            </a>
                                        </li>
                                        <li><a href="{{ route('admin.orders.index') }}" @class(['act-scrlink' => request()->routeIs('admin.orders.*')])>Payments</a></li>
                                        <li><a href="{{ route('admin.services.index') }}" @class(['act-scrlink' => request()->routeIs('admin.services.*')])>Services</a></li>
                                        <li><a href="{{ route('admin.team.index') }}" @class(['act-scrlink' => request()->routeIs('admin.team.*')])>Team</a></li>
                                        <li><a href="{{ route('admin.content.index') }}" @class(['act-scrlink' => request()->routeIs('admin.content.*')])>Website Content</a></li>
                                        <li><a href="{{ route('admin.faqs.index') }}" @class(['act-scrlink' => request()->routeIs('admin.faqs.*')])>FAQs</a></li>
                                    </ul>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="hum_log-out_btn" style="width: 100%; border: 0; cursor: pointer;">
                                            <i class="fa-light fa-power-off"></i> Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        @if(session('status'))
                            <div class="dashboard-title" style="margin-bottom: 20px;">
                                <div class="dashboard-title-item"><span>{{ session('status') }}</span></div>
                            </div>
                        @endif
                        @yield('admin-content')
                    </div>
                </div>
                <div class="limit-box"></div>
            </div>
        </div>
    </div>
</section>
@endsection
