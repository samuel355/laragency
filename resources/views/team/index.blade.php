@extends('layouts.app')

@section('title', 'Our Team - BlueGate Realty')

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <h2>Our Team</h2>
                        <h5>Meet the people managing listings, land allocations, buyer support, and corporate mandates.</h5>
                    </div>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="bg" data-bg="{{ asset('light/images/bg/9.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a> <span>Our Team</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            <div class="row">
                @foreach($members as $member)
                    <div class="col-lg-3 col-md-6">
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
                                <a href="{{ route('team.show', $member) }}" class="post-card_link">View Profile <i class="fa-solid fa-caret-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
