@extends('layouts.app')

@section('title', $member->name.' - BlueGate Realty')

@php($memberListings = $member->listings()->with('agent')->where('is_published', true)->latest()->get())

@section('content')
<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a><a href="{{ route('team.index') }}">Our Team</a><span>{{ $member->name }}</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <!--main-content-->
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            <div class="row">
                <!-- boxed-content -->
                <div class="col-lg-4">
                    <div class="boxed-content">
                        <div class="agent-preofile-wrap">
                            <div class="agent-preofile-header sh-links">
                                <div class="agent-preofile-header-bg"></div>
                                <div class="agent-preofile-header-avatar">
                                    <div class="agent-preofile-header-avatar-item">
                                        <img src="{{ asset($member->image_path) }}" alt="{{ $member->name }}">
                                    </div>
                                </div>
                                <div class="abs_bg"></div>
                                <div class="profile-card-stats">
                                    <ul>
                                        <li><span>{{ $memberListings->count() }}</span>Properties</li>
                                    </ul>
                                </div>
                                <div class="property-contacts-links">
                                    @if($member->phone)
                                        <a href="tel:{{ $member->phone }}" class="tolt pcl_btn" data-microtip-position="left" data-tooltip="Call"><i class="fa-solid fa-phone"></i></a>
                                    @endif
                                    @if($member->email)
                                        <a href="mailto:{{ $member->email }}" class="tolt pcl_btn" data-microtip-position="left" data-tooltip="Email"><i class="fa-solid fa-envelope"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="agent-preofile-content">
                                <div class="agent-preofile-content-text">
                                    <h4>{{ $member->name }}</h4>
                                    <p>{{ $member->bio }}</p>
                                </div>
                            </div>
                            @if(!empty($member->social_links))
                                <div class="agent-preofile-footer">
                                    <div class="agent-preofile-footer_title">Follow:</div>
                                    <div class="agent-preofile-footer-social">
                                        @foreach($member->social_links as $network => $url)
                                            <a href="{{ $url }}" target="_blank"><i class="fa-brands fa-{{ $network }}"></i></a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="boxed-content" style="margin-top: 20px;">
                        <div class="boxed-content-item">
                            <a class="commentssubmit commentssubmit_fw" href="{{ route('contact') }}">Contact {{ Str::before($member->name, ' ') }}</a>
                        </div>
                    </div>
                </div>
                <!-- boxed-content end-->
                <div class="col-lg-8">
                    <div class="list-main-wrap-header box-list-header" style="margin-top: 0">
                        <div class="list-main-wrap-title">
                            <h2>{{ $member->name }}'s Listings: <strong>{{ $memberListings->count() }}</strong></h2>
                        </div>
                    </div>
                    <div class="listing-grid gisp">
                        @forelse($memberListings as $listing)
                            <div class="listing-grid-item">
                                <div class="listing-item"><x-property-card :listing="$listing" /></div>
                            </div>
                        @empty
                            <p>No active listings from this advisor right now.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--main-content end-->
</div>
@endsection
