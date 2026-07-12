@extends('layouts.app')

@section('title', 'Services - BlueGate Realty')

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <h2>Our Services</h2>
                        <h5>Corporate-grade support across acquisition, sales, land reservations, and investment decisions.</h5>
                    </div>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="bg" data-bg="{{ asset('light/images/bg/10.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a> <span>Services</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            <div class="contacts-cards-wrap">
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-lg-6">
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
        </div>
    </div>
</div>
@endsection
