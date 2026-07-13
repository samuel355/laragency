@extends('layouts.app')

@section('title', $service->title.' - SOMA PROPERTIES')

@section('content')
<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a><a href="{{ route('services') }}">Services</a><span>{{ $service->title }}</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="boxed-content service-detail-panel">
                        <div class="boxed-content-title"><h3><i class="{{ $service->icon }}"></i> {{ $service->title }}</h3></div>
                        <div class="boxed-content-item">
                            <p class="service-lede">{{ $service->summary }}</p>
                            <p>{{ $service->body }}</p>
                        </div>
                    </div>

                    @if(!empty($service->process))
                        <div class="boxed-content service-detail-panel">
                            <div class="boxed-content-title"><h3>How It Works</h3></div>
                            <div class="boxed-content-item">
                                <div class="service-process-list">
                                    <ol>
                                        @foreach($service->process as $step)
                                            <li>
                                                <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                                <p>{{ $step }}</p>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(!empty($service->benefits))
                        <div class="boxed-content service-detail-panel">
                            <div class="boxed-content-title"><h3>What You Receive</h3></div>
                            <div class="boxed-content-item">
                                <div class="service-outcome-grid">
                                    @foreach($service->benefits as $benefit)
                                        <div class="service-outcome-item">
                                            <i class="fal fa-circle-check"></i>
                                            <p>{{ $benefit }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="col-lg-4">
                    <div class="fixed-form-wrap">
                        <div class="fixed-form">
                            <div class="boxed-content">
                                <div class="boxed-content-title"><h3>Talk to an Advisor</h3></div>
                                <div class="boxed-content-item">
                                    <p>Our team can walk you through pricing, timelines, and documentation for {{ strtolower($service->title) }}.</p>
                                    <a class="commentssubmit commentssubmit_fw" href="{{ route('contact') }}">Request a Callback</a>
                                    <a class="commentssubmit commentssubmit_fw" style="margin-top: 10px; background: transparent; border: 1px solid var(--app-blue-600); color: var(--app-blue-700);" href="{{ route('site-visits.create') }}">Book a Site Visit</a>
                                </div>
                            </div>
                            @if($otherServices->isNotEmpty())
                                <div class="boxed-content" style="margin-top: 20px;">
                                    <div class="boxed-content-title"><h3>Other Services</h3></div>
                                    <div class="boxed-content-item">
                                        <div class="other-services-list">
                                            <ul>
                                                @foreach($otherServices as $other)
                                                    <li>
                                                        <a href="{{ route('services.show', $other) }}">
                                                            <span>{{ $other->title }}</span>
                                                            <i class="fa-solid fa-caret-right"></i>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="limit-box"></div>
        </div>
    </div>
</div>
@endsection
