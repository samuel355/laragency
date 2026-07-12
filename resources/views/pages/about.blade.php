@extends('layouts.app')

@section('title', 'About - BlueGate Realty')

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <h2>About BlueGate Realty</h2>
                        <h5>{{ $content?->subtitle }}</h5>
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
                <div class="bg" data-bg="{{ asset($content?->image_path ?? '/light/images/bg/10.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<!--container-->
<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a> <span>About</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <!--main-content-->
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            <div class="boxed-content">
                <div class="about-wrap boxed-content-item">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="about-title ab-hero">
                                <h2>{{ $content?->title }}</h2>
                                <h4>{{ $content?->subtitle }}</h4>
                            </div>
                            <p>{{ $content?->body }}</p>
                            <div class="pp-single-features">
                                <ul>
                                    <li><a href="#"><i class="fal fa-circle-check"></i> Document review</a></li>
                                    <li><a href="#"><i class="fal fa-circle-check"></i> Inspection coordination</a></li>
                                    <li><a href="#"><i class="fal fa-circle-check"></i> Buyer support</a></li>
                                    <li><a href="#"><i class="fal fa-circle-check"></i> Payment tracking</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-img">
                                <img src="{{ asset('light/images/all/15.jpg') }}" class="respimg" alt="About BlueGate Realty" loading="lazy" decoding="async">
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

            <div class="agent-bg-section">
                <div class="fw_car_title-wrap">
                    <div class="fw_car_title">
                        <h3>Meet Our Team</h3>
                        <p>Advisors, land specialists, and client managers behind every BlueGate transaction.</p>
                    </div>
                </div>
                <div class="agnet-carousel-wrap">
                    <div class="agnet-carousel">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($team as $member)
                                    <!--agent-card-item-->
                                    <div class="swiper-slide">
                                        <div class="agent-card-item">
                                            <div class="agent-card-item_media">
                                                <div class="agent-card-item_media-wrap">
                                                    <img src="{{ asset($member->image_path) }}" alt="{{ $member->name }}" class="respimg" loading="lazy" decoding="async">
                                                    <div class="overlay"></div>
                                                </div>
                                            </div>
                                            <div class="agent-card-item_text">
                                                <div class="agent-card-item_text-item">
                                                    <h4><a href="{{ route('team.show', $member) }}">{{ $member->name }}</a></h4>
                                                    <p>{{ $member->role }}</p>
                                                </div>
                                            </div>
                                            <div class="agent-card-item_footer sh-links">
                                                <a href="{{ route('team.show', $member) }}" class="post-card_link">View Details <i class="fa-solid fa-caret-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--agent-card-item end-->
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--main-content end-->
</div>
<!--container end-->
@endsection
