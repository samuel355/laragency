@extends('layouts.app')

@section('title', 'Property Listings - SOMA PROPERTIES')

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <h2>Property Listings</h2>
                        <h5>Search verified homes, apartments, and land across Greater Accra.</h5>
                    </div>
                </div>
            </div>
            <div class="hs-scroll-down-wrap">
                <div class="scroll-down-item">
                    <div class="mousey"><div class="scroller"></div></div>
                    <span>Scroll Down To Discover</span>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="bg" data-bg="{{ asset('light/images/bg/12.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<!--container-->
<div class="container">
    <!--breadcrumbs-list-->
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a> <span>Listings</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <!--breadcrumbs-list end-->
    <!--main-content-->
    <div class="main-content">
        <!--boxed-container-->
        <div class="boxed-container">
            <div class="coming-soon-panel">
                <i class="fa-light fa-house-building"></i>
                <h3>Property listings is coming soon</h3>
            </div>

            {{--
            <!-- list-searh-input-wrap-->
            <div class="list-searh-input-wrap box_list-searh-input-wrap">
                <div class="list-searh-input-wrap-title_wrap">
                    <div class="list-searh-input-wrap-title"><i class="far fa-sliders-h"></i><span>Search Filters</span></div>
                </div>
                <form class="custom-form" method="GET">
                    <div class="row">
                        <!-- listsearch-input-item -->
                        <div class="col-lg-3">
                            <div class="cs-intputwrap">
                                <i class="fa-light fa-location-dot"></i>
                                <input type="text" name="city" placeholder="Location, e.g. East Legon" value="{{ request('city') }}">
                            </div>
                        </div>
                        <!-- listsearch-input-item -->
                        <div class="col-lg-3">
                            <div class="cs-intputwrap">
                                <i class="fa-light fa-layer-group"></i>
                                <select data-placeholder="Categories" class="chosen-select on-radius no-search-select" name="property_type">
                                    <option value="">All Categories</option>
                                    @foreach($propertyTypes as $value => $label)
                                        <option value="{{ $value }}" @selected(request('property_type') === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- listsearch-input-item -->
                        <div class="col-lg-2">
                            <div class="cs-intputwrap">
                                <i class="fa-light fa-file-signature"></i>
                                <select data-placeholder="Buy, Rent or Lease" class="chosen-select on-radius no-search-select" name="type">
                                    <option value="">Buy, Rent or Lease</option>
                                    <option value="sale" @selected(request('type') === 'sale')>For Sale</option>
                                    <option value="rent" @selected(request('type') === 'rent')>For Rent</option>
                                    <option value="lease" @selected(request('type') === 'lease')>For Lease</option>
                                </select>
                            </div>
                        </div>
                        <!-- listsearch-input-item -->
                        <div class="col-lg-3">
                            <div class="cs-intputwrap">
                                <div class="price-range-wrap fl-wrap">
                                    <label>Price Range</label>
                                    <div class="price-rage-item">
                                        <input type="text" class="price-range-double" data-min="0" data-max="5000000" data-from="0" data-to="5000000" name="price_range" data-step="10000" data-prefix="GHS ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- listsearch-input-item -->
                        <div class="col-lg-4">
                            <div class="quantity_wrap">
                                <div class="quantity_wrap_title"><i class="fa-light fa-bed"></i><span>Bedrooms</span></div>
                                <div class="quantity">
                                    <div class="quantity-item">
                                        <input type="button" value="-" class="minus">
                                        <input type="text" name="bedrooms" title="Bedrooms" class="qty" data-min="0" data-max="10" data-step="1" value="{{ request('bedrooms', 0) }}">
                                        <input type="button" value="+" class="plus">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="commentssubmit commentssubmit_fw">Search Properties</button>
                </form>
            </div>
            <!-- list-searh-input-wrap end-->

            <div class="listing-grid_heroheader">
                <h3>{{ $listings->total() }} Properties Found</h3>
            </div>

            <!-- listing-grid-->
            <div class="listing-grid gisp">
                @forelse($listings as $listing)
                    <div class="listing-grid-item">
                        <div class="listing-item"><x-property-card :listing="$listing" /></div>
                    </div>
                @empty
                    <p>No properties match your search. Try adjusting your filters.</p>
                @endforelse
            </div>
            <!-- listing-grid end-->

            <div class="pagination-wrap">{{ $listings->links() }}</div>
            --}}
        </div>
        <!--boxed-container end-->
    </div>
    <!--main-content end-->
</div>
<!--container end-->
@endsection
