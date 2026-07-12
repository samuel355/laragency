@extends('layouts.app')

@section('title', $listing->title.' - BlueGate Realty')

@section('content')
<!--container-->
<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a><a href="{{ route('listings.index') }}">Listings</a><span>{{ $listing->title }}</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
</div>

<!--single-carousle-container-->
<div class="fw-carousel-container">
    <div class="fw-carousel-wrap">
        <!-- fw-carousel  -->
        <div class="fw-carousel">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @forelse($listing->image_paths ?? [] as $image)
                        <div class="swiper-slide"><img src="{{ asset($image) }}" alt="{{ $listing->title }}" @if($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif decoding="async"></div>
                    @empty
                        <div class="swiper-slide"><img src="{{ asset($listing->primaryImage()) }}" alt="{{ $listing->title }}" loading="eager" fetchpriority="high" decoding="async"></div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- fw-carousel end -->
    </div>
    <div class="fw-carousel-button-prev slider-button"><i class="fa-solid fa-caret-left"></i></div>
    <div class="fw-carousel-button-next slider-button"><i class="fa-solid fa-caret-right"></i></div>
</div>
<!--single-carousle-container end-->

<div class="container">
    <div class="main-content">
        <div class="boxed-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="scroll-content-wrap">
                        <div class="list-single-opt_header hsc_flat_bci">
                            <div class="hero-section_categories">
                                <a href="{{ route('listings.index', ['type' => $listing->type]) }}">For {{ ucfirst($listing->type) }}</a>
                                <a href="{{ route('listings.index', ['property_type' => $listing->property_type]) }}">{{ \App\Models\PropertyListing::propertyTypeOptions()[$listing->property_type] ?? ucfirst($listing->property_type) }}</a>
                            </div>
                            <div class="hero-opt-btnns">
                                <a href="#single_cf" class="custom-scroll-link tolt" data-microtip-position="left" data-tooltip="Contact to View"><i class="fa-light fa-envelope"></i></a>
                            </div>
                        </div>
                        <div class="boxed-content">
                            <div class="boxed-content-item">
                                <div class="hero-section-title_container hsc_flat">
                                    <div class="hero-section-title">
                                        <h2>{{ $listing->title }}</h2>
                                        <h4><i class="fa-solid fa-location-dot"></i> <span>{{ $listing->address }}, {{ $listing->city }}, {{ $listing->region }}</span></h4>
                                        <div class="property-single-header-price">
                                            <strong>Price:</strong>
                                            <span class="pshp_item">{{ $listing->formattedPrice() }}@if($listing->type === 'rent') / per month @endif</span>
                                        </div>
                                    </div>
                                    <div class="hero-section-opt">
                                        @if($listing->agent)
                                            <div class="property-single-header-date author_avatar_ps">
                                                <a href="{{ route('team.show', $listing->agent) }}"><img src="{{ asset($listing->agent->image_path) }}" alt="{{ $listing->agent->name }}" loading="lazy" decoding="async"> By {{ $listing->agent->name }}</a>
                                            </div>
                                        @endif
                                        <div class="property-single-header-date"><span>Property Code:</span> {{ $listing->property_code ?? '—' }}</div>
                                        <div class="property-single-header-date"><span>Status:</span> {{ ucfirst($listing->status) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--ps-facts-wrapper-->
                        <div class="ps-facts-wrapper">
                            @unless($listing->property_type === 'land')
                                <div class="ps-facts-item"><h4>Bedrooms</h4><h5>{{ $listing->bedrooms }}</h5><i class="fa-light fa-bed"></i></div>
                                <div class="ps-facts-item"><h4>Bathrooms</h4><h5>{{ $listing->bathrooms }}</h5><i class="fa-light fa-bath"></i></div>
                                <div class="ps-facts-item"><h4>Garages</h4><h5>{{ $listing->garages }}</h5><i class="fa-light fa-car"></i></div>
                            @endunless
                            <div class="ps-facts-item"><h4>Area</h4><h5>{{ number_format((float) $listing->area_sqm) }} sqm</h5><i class="fa-light fa-chart-area"></i></div>
                            @if($listing->year_built)
                                <div class="ps-facts-item"><h4>Year Built</h4><h5>{{ $listing->year_built }}</h5><i class="fa-light fa-hammer"></i></div>
                            @endif
                        </div>
                        <!--ps-facts-wrapper end-->

                        <!--boxed-content-->
                        <div class="boxed-content">
                            <div class="boxed-content-title"><h3>About this Property</h3></div>
                            <div class="boxed-content-item">
                                <p>{{ $listing->description }}</p>
                                @if($listing->title_status)
                                    <p><strong>Title status:</strong> {{ $listing->title_status }}</p>
                                @endif
                                @if(!empty($listing->floor_plan_paths) || $listing->virtual_tour_url || $listing->video_url)
                                    <div class="pp-single-opt-wrap">
                                        <div class="pp-single-opt-links">
                                            <ul>
                                                @foreach($listing->floor_plan_paths ?? [] as $plan)
                                                    <li><a href="{{ asset($plan) }}" target="_blank"><i class="fa-light fa-file-pdf"></i> View Floor Plan</a></li>
                                                @endforeach
                                                @if($listing->virtual_tour_url)
                                                    <li><a href="{{ $listing->virtual_tour_url }}" target="_blank"><i class="fa-light fa-vr-cardboard"></i> 360&deg; Virtual Tour</a></li>
                                                @endif
                                            </ul>
                                            @if($listing->video_url)
                                                <a href="{{ $listing->video_url }}" target="_blank" class="pp-single-opt-link_silngle">Watch Video</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--boxed-content end-->

                        @if(!empty($listing->features))
                            <!--boxed-content-->
                            <div class="boxed-content">
                                <div class="boxed-content-title"><h3>Property Features</h3></div>
                                <div class="boxed-content-item">
                                    <div class="pp-single-opt">
                                        <div class="pp-single-features">
                                            <ul>
                                                @foreach($listing->features as $feature)
                                                    <li><a href="#"><i class="fal fa-circle-check"></i> {{ $feature }}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--boxed-content end-->
                        @endif

                        <!--boxed-content-->
                        <div class="boxed-content">
                            <div class="boxed-content-title"><h3>Property Location</h3></div>
                            <div class="boxed-content-item">
                                <div class="row">
                                    <div class="col-lg-{{ !empty($listing->nearby_places) ? 6 : 12 }}">
                                        <div class="map-container mapC_vis2">
                                            @if($listing->latitude && $listing->longitude)
                                                <div id="listing-map" style="height: 360px; border-radius: 10px;"></div>
                                            @else
                                                <p>Map coordinates not available for this listing.</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if(!empty($listing->nearby_places))
                                        <div class="col-lg-6">
                                            <div class="nerby-list-wrap">
                                                <div class="nerby-list-container">
                                                    <div class="nerby-list">
                                                        <span class="nerby-title">What's Nearby</span>
                                                        <div class="nerby-list-box">
                                                            <ul>
                                                                @foreach($listing->nearby_places as $place)
                                                                    <li><i class="fa-light fa-location-dot"></i> {{ $place }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--boxed-content end-->
                    </div>
                </div>

                <div class="col-lg-4">
                    <!--boxed-container-->
                    <div class="sb-container">
                        <!--boxed-content-->
                        <div class="fixed-form-wrap">
                            <div class="fixed-form">
                                <div class="boxed-content">
                                    <div class="boxed-content-title"><h3>Request More Information</h3></div>
                                    <div class="boxed-content-item">
                                        @if($listing->agent)
                                            <div class="property-contacts-wrap">
                                                <div class="property-contacts-item sh-links">
                                                    <div class="property-contacts_profile">
                                                        <a href="{{ route('team.show', $listing->agent) }}" class="property-contacts_profile_link">
                                                            <img src="{{ asset($listing->agent->image_path) }}" alt="{{ $listing->agent->name }}" loading="lazy" decoding="async">
                                                            <span>Agent:</span>{{ $listing->agent->name }}
                                                        </a>
                                                    </div>
                                                    <div class="property-contacts-links">
                                                        @if($listing->agent->phone)
                                                            <a href="tel:{{ $listing->agent->phone }}" class="tolt pcl_btn" data-microtip-position="left" data-tooltip="Call"><i class="fa-solid fa-phone"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="log-separator"><span>or</span></div>
                                            </div>
                                        @endif
                                        <p>Use the form below to request more details or schedule an inspection.</p>
                                        <div class="custom-form" id="single_cf">
                                            <form method="POST" action="{{ route('listings.inquire', $listing) }}">
                                                @csrf
                                                @if(session('status'))<p>{{ session('status') }}</p>@endif
                                                <div class="cs-intputwrap"><i class="fa-light fa-user"></i><input type="text" name="name" placeholder="Your Name" required></div>
                                                <div class="cs-intputwrap"><i class="fa-light fa-envelope"></i><input type="email" name="email" placeholder="Your Email" required></div>
                                                <div class="cs-intputwrap"><i class="fa-light fa-phone"></i><input type="text" name="phone" placeholder="Your Phone"></div>
                                                <div class="cs-intputwrap"><i class="fa-light fa-message"></i><textarea name="message" placeholder="Message" required>I would like more details about {{ $listing->title }}.</textarea></div>
                                                <button type="submit" class="commentssubmit commentssubmit_fw">Send Inquiry</button>
                                            </form>
                                        </div>
                                        <a href="{{ route('site-visits.create', ['property_listing_id' => $listing->id]) }}" class="commentssubmit commentssubmit_fw" style="margin-top: 10px; background: transparent; border: 1px solid var(--app-blue-600); color: var(--app-blue-700);">Schedule a Viewing</a>
                                        @if($listing->type === 'sale')
                                            <a href="{{ route('mortgage.create', ['property_listing_id' => $listing->id]) }}" class="commentssubmit commentssubmit_fw" style="margin-top: 10px; background: transparent; border: 1px solid var(--app-blue-600); color: var(--app-blue-700);">Mortgage Calculator</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--boxed-content end-->
                    </div>
                </div>
            </div>
            <div class="limit-box"></div>
        </div>
    </div>
</div>
<!--container end-->

@if($related->isNotEmpty())
<div class="container">
    <div class="boxed-container">
        <div class="listing-grid_heroheader"><h3>Similar Properties</h3></div>
        <div class="listing-grid gisp">
            @foreach($related as $item)
                <div class="listing-grid-item">
                    <div class="listing-item"><x-property-card :listing="$item" /></div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($listing->latitude && $listing->longitude)
    @push('scripts')
        <script>
            window.initListingMap = function () {
                var position = { lat: {{ (float) $listing->latitude }}, lng: {{ (float) $listing->longitude }} };
                var listingMap = new google.maps.Map(document.getElementById('listing-map'), {
                    center: position,
                    zoom: 14,
                    zoomControl: true,
                    streetViewControl: true,
                    fullscreenControl: true,
                    mapTypeControl: true,
                    scaleControl: true,
                    mapTypeControlOptions: {
                        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                        position: google.maps.ControlPosition.TOP_RIGHT,
                    },
                    zoomControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_CENTER,
                    },
                    streetViewControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_CENTER,
                    },
                    fullscreenControlOptions: {
                        position: google.maps.ControlPosition.RIGHT_TOP,
                    },
                });
                var marker = new google.maps.Marker({
                    position: position,
                    map: listingMap,
                    title: {{ Illuminate\Support\Js::from($listing->title) }},
                });
                var infoWindow = new google.maps.InfoWindow({
                    content: {{ Illuminate\Support\Js::from($listing->title) }},
                });

                marker.addListener('click', function () {
                    infoWindow.open(listingMap, marker);
                });
            };
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initListingMap"></script>
    @endpush
@endif
@endsection
