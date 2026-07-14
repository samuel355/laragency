@extends('layouts.app')

@section('title', 'SOMA PROPERTIES - Professional Real Estate Advisory in Ghana')

@section('content')
<!--section-->
<div class="section hero-section home-hero-section">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="hero-slider-wrapper">
                                <div class="hero-slider">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            <!-- swiper-slide-->
                                            <div class="swiper-slide">
                                                <div class="hero-carousel_item" data-imbg="{{ asset($hero?->image_path ?? '/light/images/bg/12.jpg') }}">
                                                    <div class="hero-section-title hs_align-title">
                                                        <div class="hero-section-title_sub">Professional property advisors - Accra, Ghana</div>
                                                        <h2>{{ $hero?->title }}</h2>
                                                        <h5>{{ $hero?->subtitle }}</h5>
                                                        <a href="{{ route('listings.index') }}" class="commentssubmit csb_color" style="margin-top: 40px">Explore Listings</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- swiper-slide end-->
                                            @if($featuredListings->first())
                                                <!-- swiper-slide-->
                                                <div class="swiper-slide">
                                                    <div class="hero-carousel_item" data-imbg="{{ asset($featuredListings->first()->primaryImage()) }}">
                                                        <div class="hero-section-title hs_align-title">
                                                            <div class="hero-section-title_sub">Featured Listing</div>
                                                            <h2><a href="{{ route('listings.show', $featuredListings->first()) }}">{{ $featuredListings->first()->title }}</a></h2>
                                                            <div class="geodir-category-location">
                                                                <a href="#" class="map-item single-map-item"><i class="fas fa-map-marker-alt"></i> {{ $featuredListings->first()->city }}, {{ $featuredListings->first()->region }}</a>
                                                            </div>
                                                            <p>{{ \Illuminate\Support\Str::limit($featuredListings->first()->description, 120) }}</p>
                                                            <a href="{{ route('listings.show', $featuredListings->first()) }}" class="commentssubmit csb_color" style="margin-top: 40px">View Details</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- swiper-slide end-->
                                            @endif
                                            <!-- swiper-slide-->
                                            <div class="swiper-slide">
                                                <div class="hero-carousel_item" data-imbg="{{ asset('light/images/bg/8.jpg') }}">
                                                    <div class="hero-section-title hs_align-title">
                                                        <div class="hero-section-title_sub">About SOMA PROPERTIES</div>
                                                        <h2>{{ $about?->title }}</h2>
                                                        <h5>{{ $about?->subtitle }}</h5>
                                                        <a href="{{ route('about') }}" class="commentssubmit csb_color custom-scroll-link" style="margin-top: 40px">Read more about us</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- swiper-slide end-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- hero-carousel-wrapper -->
                        </div>
                        <div class="col-lg-4 mob-hid">
                            <!-- list-searh-input-wrap-->
                            <div class="list-searh-input-wrap box_list-searh-input-wrap lws_column hero_home_search lsiw_dec">
                                <div class="list-searh-input-wrap-title_wrap">
                                    <div class="list-searh-input-wrap-title"><i class="far fa-sliders-h"></i><span>Use Quick Search</span></div>
                                </div>
                                <form class="custom-form" action="{{ route('listings.index') }}" method="GET">
                                    <div class="row">
                                        <!-- listsearch-input-item -->
                                        <div class="col-lg-12">
                                            <div class="cs-intputwrap">
                                                <i class="fa-light fa-location-dot"></i>
                                                <input type="text" name="city" placeholder="Location, e.g. East Legon" value="{{ request('city') }}">
                                            </div>
                                        </div>
                                        <!-- listsearch-input-item -->
                                        <div class="col-lg-12">
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
                                        <div class="col-lg-12">
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
                                    </div>
                                    <button type="submit" class="commentssubmit commentssubmit_fw">Search</button>
                                </form>
                            </div>
                            <!-- list-searh-input-wrap end-->
                            <div class="hero-notifer">Need more search options? <a href="{{ route('listings.index') }}">Advanced Search</a></div>
                        </div>
                    </div>
                </div>
                <div class="hs-scroll-down-wrap">
                    <div class="scroll-down-item">
                        <div class="mousey"><div class="scroller"></div></div>
                        <span>Scroll Down To Discover</span>
                    </div>
                </div>
                <div class="sc-controls shc_controls2 shc_controls3 slideshow-container-pag-init"></div>
                <div class="hs-slider-controls">
                    <div class="hs-button-prev hs-slider-button"><i class="fa-solid fa-chevron-left"></i></div>
                    <div class="hs-button-next hs-slider-button"><i class="fa-solid fa-chevron-right"></i></div>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="hero-blur-container fs-wrapper">
                    <div class="hero-blur-container_item fs-wrapper">
                        <div class="bg" data-bg=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<!--container-->
<div class="container">
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            <div class="boxed-content">
                <div class="about-wrap boxed-content-item">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="about-title ab-hero">
                                <h2>{{ $about?->title }}</h2>
                                <h4>{{ $about?->subtitle }}</h4>
                            </div>
                            <p>{{ $about?->body }}</p>
                            <div class="pp-single-features">
                                <ul>
                                    <li><a href="#"><i class="fal fa-circle-check"></i> Property acquisition</a></li>
                                    <li><a href="#"><i class="fal fa-circle-check"></i> Valuation and market research</a></li>
                                    <li><a href="#"><i class="fal fa-circle-check"></i> Development and planning consultancy</a></li>
                                    <li><a href="#"><i class="fal fa-circle-check"></i> Leasing and rent reviews</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-img">
                                <img src="{{ asset('light/images/all/15.jpg') }}" class="respimg" alt="About SOMA PROPERTIES" loading="lazy" decoding="async">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--container end-->

@if($services->isNotEmpty())
<!--container-->
<div class="container">
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            <div class="listing-grid_heroheader">
                <h3>Our Services</h3>
            </div>
            <div class="contacts-cards-wrap">
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-lg-3 col-md-6">
                            <div class="contacts-card-item">
                                <i class="{{ $service->icon }}"></i>
                                <span>{{ $service->title }}</span>
                                <p>{{ $service->summary }}</p>
                                <a href="{{ route('services.show', $service) }}">Learn more <i class="fa-solid fa-caret-right"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <a href="{{ route('services') }}" class="commentssubmit csb-no-align">View More Services <i class="fa-solid fa-caret-right"></i></a>
        </div>
    </div>
</div>
<!--container end-->
@endif

<!--container-->
<div class="container">
    <!--main-content-->
    <div class="main-content ms_vir_height" id="sec1">
        <!--boxed-container-->
        <div class="boxed-container">
            <div class="listing-grid_heroheader">
                <h3>Explore Properties</h3>
                <div class="gallery-filters">
                    <a href="#" class="gallery-filter gallery-filter-active" data-filter="*">All</a>
                    <a href="#" class="gallery-filter" data-filter=".cat-land">Land</a>
                    <a href="#" class="gallery-filter" data-filter=".cat-house">Houses</a>
                    <a href="#" class="gallery-filter" data-filter=".cat-commercial">Commercial</a>
                    <a href="#" class="gallery-filter" data-filter=".cat-rent">Rentals</a>
                </div>
            </div>
            <!-- listing-grid-->
            <div class="listing-grid gisp">
                @foreach($latestListings as $listing)
                    @php
                        $catClasses = ['cat-'.$listing->type];
                        $catClasses[] = $listing->property_type === 'land' ? 'cat-land' : (in_array($listing->property_type, ['commercial', 'office', 'warehouse', 'mixed-use']) ? 'cat-commercial' : 'cat-house');
                    @endphp
                    <div class="listing-grid-item {{ implode(' ', $catClasses) }}">
                        <div class="listing-item"><x-property-card :listing="$listing" /></div>
                    </div>
                @endforeach
            </div>
            <!-- listing-grid end-->
            <a href="{{ route('listings.index') }}" class="commentssubmit csb-no-align">View All Properties <i class="fa-solid fa-caret-right"></i></a>
        </div>
        <!--boxed-container end-->
    </div>
    <!--main-content end-->
</div>
<!--container end-->

@if($communities->isNotEmpty())
<div class="dark-bg half-carousel-container">
    <div class="city-carousel-wrap">
        <div class="half-carousel-title-wrap">
            <div class="half-carousel-title">
                <h2>Featured Communities</h2>
                <p>Neighbourhoods across Greater Accra our clients search the most.</p>
                <a href="{{ route('listings.index') }}" class="commentssubmit" style="margin-top: 20px">View All Listings<i class="fa-solid fa-caret-right"></i></a>
            </div>
            <div class="abs_bg"></div>
        </div>
        <div class="city-carousel">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($communities as $community)
                        <!--city-carousel-item-->
                        <div class="swiper-slide">
                            <div class="city-carousel-item">
                                <div class="bg-wrap fs-wrapper">
                                    <div class="bg" data-bg="{{ asset($community->image_path) }}" data-swiper-parallax="10%"></div>
                                    <div class="overlay"></div>
                                </div>
                                <div class="city-carousel-content">
                                    <div class="hc-counter">{{ $community->listings_count }} Properties</div>
                                    <h3><a href="{{ route('listings.index', ['city' => $community->city]) }}">{{ $community->name }}</a></h3>
                                    <p>{{ \Illuminate\Support\Str::limit($community->description, 90) }}</p>
                                </div>
                            </div>
                        </div>
                        <!--city-carousel-item end-->
                    @endforeach
                </div>
            </div>
            <div class="sc-controls city-pag-init"></div>
        </div>
    </div>
    <div class="city-carousel_controls">
        <div class="csc-button csc-button-prev"><i class="fas fa-caret-left"></i></div>
        <div class="csc-button csc-button-next"><i class="fas fa-caret-right"></i></div>
    </div>
</div>
@endif

<!--main-content-->
<div class="main-content ms_vir_height">
    <!--container -->
    <div class="container">
        <div class="boxed-container">
            <div class="boxed-content">
                <div class="about-wrap boxed-content-item">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="about-title ab-hero">
                                <h2>{{ $whyChooseUs?->title ?? 'Why Choose SOMA PROPERTIES' }}</h2>
                                <h4>{{ $whyChooseUs?->subtitle }}</h4>
                            </div>
                            <div class="services-opions">
                                <ul>
                                    @foreach(($whyChooseUs?->metadata['items'] ?? []) as $item)
                                        <li>
                                            <i class="{{ $item['icon'] }}"></i>
                                            <h4>{{ $item['title'] }}</h4>
                                            <p>{{ $item['text'] }}</p>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="about-img">
                                <img src="{{ asset('light/images/all/15.jpg') }}" class="respimg" alt="" loading="lazy" decoding="async">
                                <div class="about-img-hotifer">
                                    <p>{{ $about?->body }}</p>
                                    <h4>Ama Mensah</h4>
                                    <h5>Principal Property Advisor</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($stats->isNotEmpty())
                <div class="row">
                    @foreach($stats as $stat)
                        <!-- inline-facts -->
                        <div class="col-lg-3">
                            <div class="inline-facts">
                                <i class="{{ $stat->icon }}"></i>
                                <div class="milestone-counter">
                                    <div class="stats animaper">
                                        <div class="num" data-content="0" data-num="{{ (int) filter_var($stat->value, FILTER_SANITIZE_NUMBER_INT) }}">0</div>{{ preg_replace('/[0-9]/', '', $stat->value) }}
                                    </div>
                                </div>
                                <h6>{{ $stat->label }}</h6>
                            </div>
                        </div>
                        <!-- inline-facts end -->
                    @endforeach
                </div>
            @endif

            @if($partnerBanks->isNotEmpty())
                <!-- clients-carousel-wrap-->
                <div class="clients-carousel-wrap">
                    <div class="clients-carousel-title">Our Trusted Partner Banks</div>
                    <div class="clients-carousel">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($partnerBanks as $bank)
                                    <!--client-item-->
                                    <div class="swiper-slide">
                                        <a href="{{ $bank->url ?? route('mortgage.create') }}" class="client-item"><img src="{{ asset($bank->logo_path) }}" alt="{{ $bank->name }}" loading="lazy" decoding="async"></a>
                                    </div>
                                    <!--client-item end-->
                                @endforeach
                            </div>
                        </div>
                        <div class="cc-button cc-button-next"><i class="fal fa-angle-right"></i></div>
                        <div class="cc-button cc-button-prev"><i class="fal fa-angle-left"></i></div>
                    </div>
                </div>
                <!-- clients-carousel-wrap end-->
            @endif
        </div>
    </div>
    <!--container end-->

    <!-- section   -->
    @if($testimonials->isNotEmpty())
        <div class="content-section">
            <div class="container">
                <div class="section-title">
                    <h4>What clients say about us</h4>
                    <h2>Testimonials and Client Results</h2>
                </div>
            </div>
            <div class="testimonilas-carousel-wrap">
                <div class="testimonilas-carousel">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach($testimonials as $testimonial)
                                <!--testi-item-->
                                <div class="swiper-slide">
                                    <div class="testi-item">
                                        <div class="testimonilas-text">
                                            <div class="testi-header">
                                                <div class="testi-avatar"><img src="{{ asset($testimonial->avatar_path) }}" alt="{{ $testimonial->client_name }}" loading="lazy" decoding="async"></div>
                                                <h3>{{ $testimonial->client_name }}</h3>
                                            </div>
                                            <div class="testimonilas-text-item">
                                                <div class="testimonilas-text-item-wrap">
                                                    <p>"{{ $testimonial->quote }}"</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="testi-footer">
                                            <span class="testi-link">{{ $testimonial->client_role }}</span>
                                            <span class="testi-number">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.</span>
                                        </div>
                                    </div>
                                </div>
                                <!--testi-item end-->
                            @endforeach
                        </div>
                    </div>
                    <div class="tc-button tc-button-next"><i class="fas fa-caret-right"></i></div>
                    <div class="tc-button tc-button-prev"><i class="fas fa-caret-left"></i></div>
                </div>
                <div class="fwc-controls_wrap">
                    <div class="solid-pagination_btns tcs-pagination_init"></div>
                </div>
            </div>
        </div>
    @endif
    <!-- section end  -->

    <!--container-->
    <div class="container">
        <div class="api-wrap">
            <div class="api-container">
                <div class="api-img">
                    <img src="{{ asset('light/images/api.png') }}" alt="" class="respimg" loading="lazy" decoding="async">
                </div>
                <div class="api-text">
                    <h3>Ready to Buy, Sell, or Invest?</h3>
                    <p>Talk to an advisor about listings, land parcels, or a valuation for your own property. Our team responds with availability, documents, and next steps.</p>
                    <div class="api-text-links">
                        <a href="{{ route('contact') }}"><span>Talk to an Advisor</span><i class="fa-solid fa-comments"></i></a>
                        <a href="{{ route('site-visits.create') }}"><span>Book a Site Visit</span><i class="fa-solid fa-calendar-check"></i></a>
                    </div>
                </div>
                <div class="api-wrap-bg" data-run="2">
                    <div class="api-wrap-bg-container">
                        <span class="api-bg-pin"></span><span class="api-bg-pin"></span>
                        <div class="abs_bg"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="to_top-btn-wrap">
            <div class="to-top to-top_btn"><span>Back to top</span> <i class="fa-solid fa-arrow-up"></i></div>
        </div>
    </div>
    <!--container end-->
</div>
<!--main-content end-->
@endsection
