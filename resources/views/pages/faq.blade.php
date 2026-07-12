@extends('layouts.app')

@section('title', 'FAQ - BlueGate Realty')

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <h2>Frequently Asked Questions</h2>
                        <h5>Verification, inspections, reservations, payment, and corporate purchase support.</h5>
                    </div>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="bg" data-bg="{{ asset('light/images/bg/8.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a> <span>FAQ</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            @foreach($faqs->groupBy('category') as $category => $categoryFaqs)
                <!-- help-item-wrap -->
                <div class="help-item-wrap">
                    <div class="help-item-title">{{ $category }}</div>
                    <div class="accordion">
                        @foreach($categoryFaqs as $faq)
                            <a class="toggle @if($loop->parent->first && $loop->first) act-accordion @endif" href="#">
                                {{ $faq->question }} <i class="fa-solid fa-caret-down"></i>
                            </a>
                            <div class="accordion-inner @if($loop->parent->first && $loop->first) visible @endif">
                                <p>{{ $faq->answer }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- help-item-wrap end-->
            @endforeach
        </div>
    </div>
</div>
@endsection
