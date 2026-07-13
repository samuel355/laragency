@extends('layouts.app')

@section('title', 'Contact - SOMA PROPERTIES')

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <h2>{{ $content?->title }}</h2>
                        <h5>{{ $content?->subtitle }}</h5>
                    </div>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="bg" data-bg="{{ asset($content?->image_path ?? '/light/images/bg/8.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a> <span>Contact</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            <!-- contacts-cards-wrap  -->
            <div class="contacts-cards-wrap">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="contacts-card-item">
                            <i class="fa-regular fa-location-dot"></i>
                            <span>Our Office</span>
                            <p>{{ $content?->body }}</p>
                            <a href="#">East Legon, Accra, Ghana</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contacts-card-item">
                            <i class="fa-regular fa-phone-rotary"></i>
                            <span>Our Phone</span>
                            <p>Speak directly with a property advisor Monday to Friday.</p>
                            <a href="tel:{{ $content?->metadata['phone'] ?? '+233300000000' }}">{{ $content?->metadata['phone'] ?? '+233 30 000 0000' }}</a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="contacts-card-item">
                            <i class="fa-regular fa-mailbox"></i>
                            <span>Our Mail</span>
                            <p>Send documents, inquiries, or scheduling requests by email.</p>
                            <a href="mailto:{{ $content?->metadata['email'] ?? 'hello@somaproperties.test' }}">{{ $content?->metadata['email'] ?? 'hello@somaproperties.test' }}</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- contacts-cards-wrap end   -->

            <div class="row">
                <div class="col-lg-7">
                    <div class="contacts-opt-wrap">
                        <div class="contact-wh_title">Working Hours</div>
                        <div class="contact-wh">
                            <div class="contact-wh-item">Monday - Friday:<strong> 8:30am - 5:30pm</strong></div>
                            <div class="contact-wh-item">Saturday:<strong> 9am - 1pm</strong></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="contacts-opt-wrap">
                        <div class="contact-social">
                            <span class="cs-title">Find us on: </span>
                            <div class="contact-social-container">
                                <a href="#" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                <a href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                                <a href="https://wa.me/233300000000" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contacts-form-wrap">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="boxed-content">
                            <div class="boxed-content-title"><h3>Get In Touch</h3></div>
                            <div class="boxed-content-item">
                                <div class="comment-form custom-form contactform-wrap">
                                    @if(session('status'))<p style="color: var(--app-blue-700); font-weight: 800;">{{ session('status') }}</p>@endif
                                    <form class="comment-form" method="POST" action="{{ route('contact.store') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="cs-intputwrap"><i class="fa-light fa-user"></i><input name="name" type="text" placeholder="Your name" value="{{ old('name') }}" required></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="cs-intputwrap"><i class="fa-light fa-envelope"></i><input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="cs-intputwrap"><i class="fa-light fa-phone"></i><input name="phone" type="text" placeholder="Phone (optional)" value="{{ old('phone') }}"></div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="cs-intputwrap"><i class="fa-light fa-tag"></i><input name="subject" type="text" placeholder="Subject (optional)" value="{{ old('subject', request('subject')) }}"></div>
                                            </div>
                                        </div>
                                        <textarea name="message" cols="40" rows="3" placeholder="Your Message" required>{{ old('message') }}</textarea>
                                        <button type="submit" class="commentssubmit" style="margin-top: 20px;">Send Message</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="map-container mapC_vis3">
                            <div id="contact-map" style="height: 100%; min-height: 340px; border-radius: 10px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.initContactMap = function () {
            var position = { lat: 5.6401, lng: -0.1537 };
            var contactMap = new google.maps.Map(document.getElementById('contact-map'), {
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
                map: contactMap,
                title: 'SOMA PROPERTIES - East Legon, Accra',
            });
            var infoWindow = new google.maps.InfoWindow({
                content: 'SOMA PROPERTIES - East Legon, Accra',
            });

            marker.addListener('click', function () {
                infoWindow.open(contactMap, marker);
            });
        };
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initContactMap"></script>
@endpush
@endsection
