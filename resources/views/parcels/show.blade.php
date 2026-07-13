@extends('layouts.app')

@section('title', $parcel->plot_number.' - '.$parcel->title.' - SOMA PROPERTIES')

@push('styles')
<style>
    .plot-detail-page { background: #f5f7fb; padding-bottom: 54px; }
    .plot-hero { padding: 132px 0 34px; background: linear-gradient(135deg, #071f49 0%, #0f4c81 54%, #ffffff 54%, #eef4fb 100%); }
    .plot-hero-grid { align-items: stretch; display: grid; gap: 22px; grid-template-columns: minmax(0, 1fr) 360px; }
    .plot-hero-main { color: #fff; display: flex; flex-direction: column; justify-content: flex-end; min-height: 260px; padding: 8px 0 8px; }
    .plot-eyebrow { align-items: center; display: inline-flex; gap: 9px; font-size: 12px; font-weight: 900; letter-spacing: 0; margin-bottom: 16px; text-transform: uppercase; }
    .plot-eyebrow span { background: rgba(255, 255, 255, .16); border: 1px solid rgba(255, 255, 255, .22); border-radius: 999px; padding: 8px 12px; }
    .plot-hero h1 { color: #fff; font-size: clamp(34px, 5vw, 62px); line-height: 1.02; margin: 0 0 16px; max-width: 820px; }
    .plot-hero p { color: rgba(255, 255, 255, .82); font-size: 17px; line-height: 1.7; margin: 0; max-width: 720px; }
    .plot-summary-panel { background: #fff; border: 1px solid rgba(7, 31, 73, .08); border-radius: 8px; box-shadow: 0 24px 58px rgba(7, 31, 73, .18); padding: 22px; }
    .plot-status-line { align-items: center; display: flex; justify-content: space-between; gap: 14px; margin-bottom: 20px; }
    .plot-price { color: var(--app-blue-900); font-size: 30px; font-weight: 900; line-height: 1.15; }
    .plot-price span { color: var(--app-muted); display: block; font-size: 12px; font-weight: 800; margin-bottom: 4px; text-transform: uppercase; }
    .plot-actions { display: grid; gap: 10px; margin-top: 22px; }
    .plot-action { align-items: center; border-radius: 8px; display: inline-flex; font-size: 13px; font-weight: 900; gap: 9px; height: 48px; justify-content: center; letter-spacing: 0; padding: 0 16px; text-transform: uppercase; }
    .plot-action-primary { background: var(--app-blue-700); color: #fff; }
    .plot-action-secondary { background: #eef5ff; border: 1px solid #cfe0f7; color: var(--app-blue-900); }
    .plot-action-ghost { background: #fff; border: 1px solid var(--app-border); color: var(--app-blue-900); }
    .plot-action.is-disabled { cursor: not-allowed; opacity: .48; pointer-events: none; }
    .plot-facts { display: grid; gap: 10px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-top: 20px; }
    .plot-fact { background: #f7faff; border: 1px solid #e1e9f5; border-radius: 8px; padding: 13px; }
    .plot-fact span { color: var(--app-muted); display: block; font-size: 11px; font-weight: 900; margin-bottom: 5px; text-transform: uppercase; }
    .plot-fact strong { color: var(--app-blue-900); display: block; font-size: 15px; line-height: 1.35; }
    .status-dot { border-radius: 50%; display: inline-block; height: 10px; width: 10px; }
    .plot-content-grid { display: grid; gap: 22px; grid-template-columns: minmax(0, 1fr) 380px; margin-top: 24px; }
    .plot-panel { background: #fff; border: 1px solid var(--app-border); border-radius: 8px; box-shadow: 0 18px 40px rgba(15, 54, 110, .08); padding: 24px; }
    .plot-panel h2, .plot-panel h3 { color: var(--app-blue-900); margin: 0 0 12px; }
    .plot-panel h2 { font-size: 26px; }
    .plot-panel h3 { font-size: 19px; }
    .plot-panel p { color: #53637a; font-size: 15px; line-height: 1.75; margin: 0 0 16px; }
    .plot-info-list { display: grid; gap: 12px; grid-template-columns: repeat(2, minmax(0, 1fr)); margin-top: 18px; }
    .plot-info-item { border-top: 1px solid #e7edf6; padding-top: 12px; }
    .plot-info-item span { color: var(--app-muted); display: block; font-size: 11px; font-weight: 900; margin-bottom: 5px; text-transform: uppercase; }
    .plot-info-item strong { color: var(--app-blue-900); font-size: 15px; line-height: 1.4; }
    .plot-map-panel { overflow: hidden; padding: 0; position: sticky; top: 104px; }
    .plot-map-head { align-items: center; border-bottom: 1px solid var(--app-border); display: flex; justify-content: space-between; gap: 12px; padding: 18px 20px; }
    .plot-map-head h3 { margin: 0; }
    .plot-map-head span { color: var(--app-muted); font-size: 12px; font-weight: 800; text-transform: uppercase; }
    #plot-detail-map { height: 420px; min-height: 420px; width: 100%; }
    .plot-side-note { padding: 18px 20px 20px; }
    .plot-side-note p { font-size: 14px; margin-bottom: 0; }
    .plot-breadcrumb-wrap { margin-top: -18px; position: relative; z-index: 3; }
    @media (max-width: 1020px) {
        .plot-hero-grid, .plot-content-grid { grid-template-columns: 1fr; }
        .plot-map-panel { position: relative; top: auto; }
        .plot-summary-panel { max-width: none; }
    }
    @media (max-width: 640px) {
        .plot-hero { padding-top: 116px; }
        .plot-facts, .plot-info-list { grid-template-columns: 1fr; }
        .plot-panel { padding: 20px; }
    }
</style>
@endpush

@section('content')
@php
    $attrs = $parcel->parcelAttributes();
    $priceText = (float) $parcel->price > 0
        ? $parcel->currency.' '.number_format((float) $parcel->price, 2)
        : 'Price on request';
    $isAvailable = $parcel->status === 'available';
    $buyUrl = route('parcels.checkout.show', $parcel);
    $reserveUrl = route('parcels.checkout.show', ['parcel' => $parcel, 'intent' => 'reserve']);
    $interestSubject = 'Interest in '.$parcel->plot_number.' - '.$parcel->title;
    $interestUrl = route('contact', ['subject' => $interestSubject]);
@endphp

<section class="plot-detail-page app-screen">
    <div class="plot-hero">
        <div class="container">
            <div class="plot-hero-grid">
                <div class="plot-hero-main">
                    <div class="plot-eyebrow">
                        <span>Verified land parcel</span>
                        <span>{{ $parcel->statusLabel() }}</span>
                    </div>
                    <h1>{{ $parcel->plot_number }} - {{ $parcel->title }}</h1>
                    <p>Review the plot position, dimensions, documentation notes, and next step options before you reserve or purchase this parcel.</p>
                </div>
                <aside class="plot-summary-panel" aria-label="Plot purchase summary">
                    <div class="plot-status-line">
                        <div class="status-pill"><span class="status-dot" style="background: {{ $parcel->statusColor() }}"></span>{{ $parcel->statusLabel() }}</div>
                        <strong>{{ number_format((float) $parcel->area_sqm) }} sqm</strong>
                    </div>
                    <div class="plot-price"><span>Asking price</span>{{ $priceText }}</div>
                    @if($isAvailable)
                        <div class="plot-actions">
                            <a class="plot-action plot-action-primary" href="{{ $buyUrl }}"><i class="fa-light fa-bag-shopping"></i> Buy Plot</a>
                            <a class="plot-action plot-action-secondary" href="{{ $reserveUrl }}"><i class="fa-light fa-bookmark"></i> Reserve</a>
                            <a class="plot-action plot-action-ghost" href="{{ $interestUrl }}"><i class="fa-light fa-message-lines"></i> Express Interest</a>
                        </div>
                    @endif
                    <div class="plot-facts">
                        @if($isAvailable)
                            <div class="plot-fact"><span>Location</span><strong>{{ $parcel->location_name }}</strong></div>
                            <div class="plot-fact"><span>Plot no.</span><strong>{{ $parcel->plot_number }}</strong></div>
                            <div class="plot-fact"><span>Zoning</span><strong>{{ $attrs['zoning'] ?? $attrs['Zoning'] ?? 'Residential use' }}</strong></div>
                            <div class="plot-fact"><span>Tenure</span><strong>{{ $attrs['tenure'] ?? $attrs['Tenure'] ?? 'Documentation available' }}</strong></div>
                        @else
                            <div class="plot-fact"><span>Details</span><strong>{{ $parcel->statusLabel() }}</strong></div>
                            <div class="plot-fact"><span>Size</span><strong>{{ number_format((float) $parcel->area_sqm) }} sqm</strong></div>
                            <div class="plot-fact"><span>Plot number</span><strong>{{ $parcel->plot_number }}</strong></div>
                            <div class="plot-fact"><span>Street name</span><strong>{{ $attrs['Street_Nam'] ?? $attrs['street_name'] ?? 'Street name unavailable' }}</strong></div>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="plot-breadcrumb-wrap">
            <div class="breadcrumbs-list bl_flat">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('parcels.index') }}">Buy Land</a>
                <span>{{ $parcel->plot_number }}</span>
                <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
            </div>
        </div>

        <div class="plot-content-grid">
            <div>
                <section class="plot-panel">
                    <h2>Plot Overview</h2>
                    <p>{{ $parcel->plot_number }} is part of the currently available demarcated parcel area at {{ $parcel->location_name }}. The plot has a mapped boundary, a clear status, and a purchase flow that keeps buyer details tied to the selected plot.</p>
                    <p>Use the map preview to confirm the shape and position, then choose to buy, reserve, or send an interest request for the SOMA PROPERTIES team to follow up.</p>
                    <div class="plot-info-list">
                        <div class="plot-info-item"><span>Parcel area</span><strong>{{ $attrs['project_area'] ?? $parcel->location_name }}</strong></div>
                        <div class="plot-info-item"><span>Street</span><strong>{{ $attrs['Street_Nam'] ?? $attrs['street_name'] ?? 'Access road available' }}</strong></div>
                        <div class="plot-info-item"><span>Survey area</span><strong>{{ $attrs['Area'] ?? number_format((float) $parcel->area_sqm).' sqm' }}</strong></div>
                        <div class="plot-info-item"><span>Availability</span><strong>{{ $parcel->statusLabel() }}</strong></div>
                    </div>
                </section>

                <section class="plot-panel" style="margin-top: 22px;">
                    <h3>Documentation And Buyer Support</h3>
                    <p>SOMA PROPERTIES can support title checks, registration guidance, site visit coordination, and payment processing for this plot. Reservation and purchase requests are reviewed against the live parcel status before confirmation.</p>
                    <div class="plot-info-list">
                        <div class="plot-info-item"><span>Registration</span><strong>{{ $attrs['registration'] ?? 'Available on request' }}</strong></div>
                        <div class="plot-info-item"><span>Site visit</span><strong>Can be arranged</strong></div>
                        <div class="plot-info-item"><span>Payment</span><strong>Secure checkout for available plots</strong></div>
                        <div class="plot-info-item"><span>Response</span><strong>Team follow-up after inquiry</strong></div>
                    </div>
                </section>
            </div>

            <aside class="plot-panel plot-map-panel">
                <div class="plot-map-head">
                    <div>
                        <h3>Mapped Boundary</h3>
                        <span>{{ $parcel->plot_number }}</span>
                    </div>
                    <div class="status-pill"><span class="status-dot" style="background: {{ $parcel->statusColor() }}"></span>{{ $parcel->statusLabel() }}</div>
                </div>
                <div id="plot-detail-map" aria-label="{{ $parcel->plot_number }} boundary map"></div>
                <div class="plot-side-note">
                    <p>The highlighted shape represents the stored parcel boundary. A site visit is recommended before final payment.</p>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
window.initPlotDetailMap = function () {
    const geometry = @json($parcel->geometry);
    const map = new google.maps.Map(document.getElementById('plot-detail-map'), {
        center: { lat: 5.69, lng: -0.12 },
        zoom: 15,
        mapTypeId: 'hybrid',
        zoomControl: true,
        streetViewControl: true,
        fullscreenControl: true,
        mapTypeControl: true,
        scaleControl: true,
        rotateControl: true,
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

    if (!geometry) return;

    const polygonPaths = function (sourceGeometry) {
        const polygons = sourceGeometry.type === 'MultiPolygon'
            ? sourceGeometry.coordinates
            : [sourceGeometry.coordinates];

        return polygons.map(function (polygon) {
            return polygon.map(function (ring) {
                return ring.map(function (coordinate) {
                    return { lat: Number(coordinate[1]), lng: Number(coordinate[0]) };
                });
            });
        });
    };

    const bounds = new google.maps.LatLngBounds();
    const polygons = polygonPaths(geometry).map(function (paths) {
        const polygon = new google.maps.Polygon({
            paths,
            map,
            strokeColor: '{{ $parcel->statusColor() }}',
            strokeWeight: 3,
            strokeOpacity: 1,
            fillColor: '{{ $parcel->statusColor() }}',
            fillOpacity: 0.58,
        });

        polygon.getPaths().forEach(function (path) {
            path.forEach(function (latLng) {
                bounds.extend(latLng);
            });
        });

        return polygon;
    });

    if (polygons.length > 0 && !bounds.isEmpty()) {
        map.fitBounds(bounds, 34);
        google.maps.event.addListenerOnce(map, 'idle', function () {
            if (map.getZoom() > 18) {
                map.setZoom(18);
            }
        });
    }
};
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initPlotDetailMap"></script>
@endpush
