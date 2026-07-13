@extends('layouts.app')

@section('title', 'Book a Site Visit - SOMA PROPERTIES')

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <h2>Book a Site Visit</h2>
                        <h5>Pick a listing or land parcel and a preferred date. An advisor will confirm the exact time.</h5>
                    </div>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="bg" data-bg="{{ asset('light/images/bg/12.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a> <span>Book a Site Visit</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <div class="main-content ms_vir_height">
        <div class="boxed-container" style="max-width: 760px; margin: 0 auto;">
            <div class="boxed-content">
                <div class="boxed-content-title"><h3>Schedule an Inspection</h3></div>
                <div class="boxed-content-item">
                    @if(session('status'))<p style="color: var(--app-blue-700); font-weight: 800;">{{ session('status') }}</p>@endif
                    <form method="POST" action="{{ route('site-visits.store') }}" class="custom-form">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="cs-intputwrap"><i class="fa-light fa-user"></i><input name="name" placeholder="Full Name" value="{{ old('name') }}" required></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="cs-intputwrap"><i class="fa-light fa-envelope"></i><input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="cs-intputwrap"><i class="fa-light fa-phone"></i><input name="phone" placeholder="Phone" value="{{ old('phone') }}" required></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="cs-intputwrap">
                                    <i class="fa-light fa-layer-group"></i>
                                    <select data-placeholder="Select a Listing" class="chosen-select on-radius no-search-select" name="property_listing_id">
                                        <option value="">Select a Listing (optional)</option>
                                        @foreach($listings as $listing)
                                            <option value="{{ $listing->id }}" @selected(old('property_listing_id', $selectedListing) == $listing->id)>{{ $listing->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="cs-intputwrap">
                                    <i class="fa-light fa-map-location-dot"></i>
                                    <select data-placeholder="Select a Land Parcel" class="chosen-select on-radius no-search-select" name="parcel_id">
                                        <option value="">Select a Land Parcel (optional)</option>
                                        @foreach($parcels as $parcel)
                                            <option value="{{ $parcel->id }}" @selected(old('parcel_id', $selectedParcel) == $parcel->id)>{{ $parcel->title }} ({{ $parcel->plot_number }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="cs-intputwrap"><i class="fa-light fa-calendar"></i><input type="date" name="preferred_date" value="{{ old('preferred_date') }}" min="{{ now()->toDateString() }}" required></div>
                            </div>
                            <div class="col-sm-3">
                                <div class="cs-intputwrap"><i class="fa-light fa-clock"></i><input name="preferred_time" placeholder="e.g. 10:00 AM" value="{{ old('preferred_time') }}"></div>
                            </div>
                        </div>
                        <textarea name="notes" placeholder="Notes (optional)">{{ old('notes') }}</textarea>
                        <button class="commentssubmit commentssubmit_fw" type="submit" style="margin-top: 20px;">Request Site Visit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
