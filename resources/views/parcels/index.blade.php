@extends('layouts.app')

@section('title', 'Buy Land - SOMA PROPERTIES')

@push('styles')
<style>
    .parcel-page { padding: 0 0 44px; min-height: 100vh; background: #f6f8fc; }
    .parcel-hero-stats { display: grid; grid-template-columns: repeat(4, minmax(82px, 1fr)); gap: 10px; margin: 0 0 22px; }
    .parcel-stat { background: #fff; border: 1px solid var(--app-border); border-radius: 8px; padding: 13px 14px; box-shadow: 0 12px 26px rgba(15, 54, 110, .08); }
    .parcel-stat span { color: var(--app-muted); display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; }
    .parcel-stat strong { color: var(--app-blue-900); display: block; font-size: 24px; line-height: 1.1; margin-top: 6px; }
    .parcel-shell { --parcel-workspace-height: clamp(620px, calc(100vh - 194px), 820px); display: grid; grid-template-columns: minmax(360px, 430px) minmax(0, 1fr); gap: 20px; align-items: start; position: sticky; top: 104px; z-index: 5; }
    .parcel-side { background: #fff; border: 1px solid var(--app-border); border-radius: 8px; box-shadow: 0 18px 44px rgba(15, 54, 110, .11); display: flex; flex-direction: column; height: var(--parcel-workspace-height); overflow: hidden; }
    .parcel-panel-head { padding: 18px 18px 14px; border-bottom: 1px solid var(--app-border); }
    .parcel-panel-head h3 { color: var(--app-blue-900); font-size: 20px; margin: 0 0 6px; }
    .parcel-panel-head p { color: var(--app-muted); font-size: 13px; line-height: 1.5; margin: 0; }
    .parcel-filter-row { display: flex; gap: 8px; margin-top: 12px; overflow-x: auto; padding-bottom: 2px; }
    .parcel-filter { background: #fff; border: 1px solid var(--app-border); border-radius: 999px; color: var(--app-blue-900); cursor: pointer; flex: 0 0 auto; font-size: 12px; font-weight: 800; height: 34px; padding: 0 12px; }
    .parcel-filter.is-active { background: var(--app-blue-700); border-color: var(--app-blue-700); color: #fff; }
    .parcel-list-meta { align-items: center; color: var(--app-muted); display: flex; font-size: 12px; font-weight: 800; justify-content: space-between; padding: 13px 18px; text-transform: uppercase; }
    .parcel-list { display: grid; flex: 1 1 auto; gap: 12px; min-height: 0; overflow-y: auto; padding: 0 12px 16px 18px; }
    .parcel-list::-webkit-scrollbar { width: 8px; }
    .parcel-list::-webkit-scrollbar-thumb { background: #c9d6ea; border-radius: 999px; }
    .parcel-item { background: #fff; border: 1px solid var(--app-border); border-radius: 8px; cursor: pointer; padding: 15px; position: relative; text-align: left; transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease; width: 100%; }
    .parcel-item:hover, .parcel-item.is-active { border-color: var(--app-blue-600); box-shadow: 0 14px 30px rgba(15, 54, 110, .14); transform: translateY(-1px); }
    .parcel-item.is-active:before { background: var(--app-blue-600); border-radius: 999px; bottom: 14px; content: ""; left: -5px; position: absolute; top: 14px; width: 4px; }
    .parcel-item h4 { color: var(--app-blue-900); font-size: 16px; line-height: 1.35; margin: 0 0 8px; }
    .parcel-meta { color: var(--app-muted); font-size: 13px; line-height: 1.6; }
    .parcel-card-row { align-items: center; display: flex; justify-content: space-between; gap: 12px; margin-top: 12px; }
    .parcel-price { color: var(--app-blue-700); font-size: 16px; font-weight: 900; }
    .parcel-item .small-btn { height: 36px; line-height: 36px; padding: 0 14px; pointer-events: auto; }
    .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
    .parcel-status { align-items: center; display: inline-flex; gap: 7px; font-size: 11px; font-weight: 900; letter-spacing: 0; margin: 0; text-transform: uppercase; }
    .parcel-map-wrap { background: #0d1b2d; border: 1px solid rgba(13, 27, 45, .12); border-radius: 8px; box-shadow: 0 22px 52px rgba(15, 54, 110, .18); overflow: hidden; }
    .parcel-map-bar { align-items: center; background: #fff; border-bottom: 1px solid var(--app-border); display: flex; justify-content: space-between; gap: 16px; padding: 14px 16px; }
    .parcel-map-title { color: var(--app-blue-900); font-weight: 900; }
    .parcel-map-title span { color: var(--app-muted); display: block; font-size: 12px; font-weight: 700; margin-top: 2px; }
    .parcel-map-tools { display: flex; gap: 8px; }
    .parcel-map-tools button { align-items: center; background: var(--app-blue-050); border: 1px solid var(--app-border); border-radius: 8px; color: var(--app-blue-900); cursor: pointer; display: inline-flex; font-weight: 800; gap: 8px; height: 38px; padding: 0 12px; }
    #parcel-map { height: var(--parcel-workspace-height); min-height: 620px; overflow: hidden; }
    .map-popup { min-width: 280px; }
    .map-popup h4 { color: var(--app-blue-900); margin: 0 0 8px; font-size: 16px; }
    .map-popup p { margin: 5px 0; }
    .map-popup-actions { display: grid; gap: 7px; grid-template-columns: repeat(3, minmax(0, 1fr)); margin-top: 12px; }
    .map-popup-action { align-items: center; border-radius: 7px; display: inline-flex; font-size: 11px; font-weight: 900; justify-content: center; min-height: 34px; padding: 8px 9px; text-align: center; text-transform: uppercase; }
    .map-popup-action-primary { background: var(--app-blue-700); color: #fff; }
    .map-popup-action-secondary { background: #eef5ff; border: 1px solid #cfe0f7; color: var(--app-blue-900); }
    .map-popup-action-ghost { background: #fff; border: 1px solid var(--app-border); color: var(--app-blue-900); }
    .map-popup-action.is-disabled { cursor: not-allowed; opacity: .5; pointer-events: none; }
    .parcel-empty { color: var(--app-muted); display: none; font-size: 14px; padding: 18px; }
    .parcel-empty.is-visible { display: block; }
    @media (max-width: 1100px) { .parcel-shell { grid-template-columns: 380px minmax(0, 1fr); } }
    @media (max-width: 980px) { .parcel-shell { grid-template-columns: 1fr; position: relative; top: auto; z-index: auto; } .parcel-side { height: auto; } .parcel-map-wrap { order: -1; } #parcel-map { height: 520px; min-height: 520px; } .parcel-list { max-height: none; min-height: 0; overflow: visible; padding-right: 18px; } }
    @media (max-width: 640px) { .parcel-hero-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); } .parcel-map-bar { align-items: flex-start; flex-direction: column; } }
</style>
@endpush

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <div class="hero-section-title_sub">Interactive land marketplace</div>
                        <h2>Buy verified land parcels with map-first clarity</h2>
                        <h5>Open the demarcated parcel area, inspect its individual plots, and review availability from one focused workspace.</h5>
                    </div>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="bg" data-bg="{{ asset('light/images/bg/12.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<section class="parcel-page app-screen">
    <div class="container">
        @php
            $statusCounts = $parcels->groupBy('status')->map->count();
        @endphp
        <div class="breadcrumbs-list bl_flat">
            <a href="{{ route('home') }}">Home</a> <span>Buy Land</span>
            <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
        </div>
        <div class="parcel-hero-stats">
            <div class="parcel-stat"><span>Total</span><strong>{{ number_format($parcels->count()) }}</strong></div>
            <div class="parcel-stat"><span>Available</span><strong>{{ number_format($statusCounts->get('available', 0)) }}</strong></div>
            <div class="parcel-stat"><span>Reserved</span><strong>{{ number_format($statusCounts->get('reserved', 0)) }}</strong></div>
            <div class="parcel-stat"><span>Sold</span><strong>{{ number_format($statusCounts->get('sold', 0)) }}</strong></div>
        </div>
        <div class="parcel-shell">
            <aside class="parcel-side">
                <div class="parcel-panel-head">
                    <h3>Parcel Areas</h3>
                    <p>Select a demarcated parcel area to zoom the map to that cluster, then inspect the plots inside it.</p>
                    <div class="parcel-filter-row" aria-label="Filter parcels by status">
                        <button type="button" class="parcel-filter is-active" data-status="all">All</button>
                        <button type="button" class="parcel-filter" data-status="available">Available</button>
                        <button type="button" class="parcel-filter" data-status="reserved">Reserved</button>
                        <button type="button" class="parcel-filter" data-status="sold">Sold</button>
                        <button type="button" class="parcel-filter" data-status="on_hold">On hold</button>
                    </div>
                </div>
                <div class="parcel-list-meta">
                    <span id="parcel-result-count">{{ number_format($parcels->count()) }} plots</span>
                    <span id="parcel-area-label">All areas</span>
                </div>
                <div class="parcel-list">
                    @foreach($parcels as $parcel)
                        <div
                            class="parcel-item"
                            data-parcel-id="{{ $parcel->id }}"
                            data-status="{{ $parcel->status }}"
                            data-location="{{ $parcel->location_name }}"
                            data-search="{{ strtolower($parcel->plot_number.' '.$parcel->title.' '.$parcel->location_name.' '.$parcel->statusLabel()) }}"
                            role="button"
                            tabindex="0"
                        >
                            <div class="parcel-status status-pill"><span class="status-dot" style="background: {{ $parcel->statusColor() }}"></span>{{ $parcel->statusLabel() }}</div>
                            <h4>{{ $parcel->plot_number }} - {{ $parcel->title }}</h4>
                            <div class="parcel-meta">{{ $parcel->location_name }}<br>{{ number_format((float) $parcel->area_sqm) }} sqm</div>
                            <div class="parcel-card-row">
                                @if((float) $parcel->price > 0)
                                    <div class="parcel-price">{{ $parcel->currency }} {{ number_format((float) $parcel->price, 2) }}</div>
                                @else
                                    <div class="parcel-price">Price on request</div>
                                @endif
                                <a class="btn small-btn float-btn color-bg" href="{{ route('parcels.show', $parcel) }}" onclick="event.stopPropagation()">Details</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="parcel-empty" id="parcel-empty">No plots match the selected filters.</div>
            </aside>
            <div class="parcel-map-wrap">
                <div class="parcel-map-bar">
                    <div class="parcel-map-title">
                        Parcel Map
                    <span id="parcel-map-caption">Showing all plots in all areas</span>
                    </div>
                    <div class="parcel-map-tools">
                        <button type="button" id="parcel-fit-map"><i class="fa-light fa-expand"></i>Fit map</button>
                    </div>
                </div>
                <div id="parcel-map" aria-label="Available land parcels map"></div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
window.initParcelMap = async function () {
    const map = new google.maps.Map(document.getElementById('parcel-map'), {
        center: { lat: 5.69, lng: -0.12 },
        zoom: 11,
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
    const parcelLayers = new Map();
    const infoWindow = new google.maps.InfoWindow();
    const resultCount = document.getElementById('parcel-result-count');
    const emptyState = document.getElementById('parcel-empty');
    const mapCaption = document.getElementById('parcel-map-caption');
    const fitMapButton = document.getElementById('parcel-fit-map');
    const areaLabel = document.getElementById('parcel-area-label');
    const contactUrl = @json(route('contact'));
    let selectedLayer = null;
    let activeStatus = 'all';
    let activeLocation = 'all';

    const baseStyle = function (feature) {
        const color = feature.properties.status_color || '#3270fc';
        return { strokeColor: color, strokeWeight: 1.5, strokeOpacity: 1, fillColor: color, fillOpacity: 0.58, zIndex: 1 };
    };

    const selectedStyle = function (feature) {
        const color = feature.properties.status_color || '#3270fc';
        return { strokeColor: color, strokeWeight: 4, strokeOpacity: 1, fillColor: color, fillOpacity: 0.82, zIndex: 10 };
    };

    const dimStyle = function (feature) {
        return { ...baseStyle(feature), strokeWeight: 1, strokeOpacity: 0.22, fillOpacity: 0.12, zIndex: 0 };
    };

    const escapeHtml = function (value) {
        return String(value ?? '').replace(/[&<>"']/g, function (char) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[char];
        });
    };

    const polygonPaths = function (geometry) {
        if (!geometry?.coordinates) return [];
        const polygons = geometry.type === 'MultiPolygon' ? geometry.coordinates : [geometry.coordinates];

        return polygons.map(function (polygon) {
            return polygon.map(function (ring) {
                return ring.map(function (coordinate) {
                    return { lat: Number(coordinate[1]), lng: Number(coordinate[0]) };
                });
            });
        });
    };

    const boundsForPolygons = function (polygons) {
        const bounds = new google.maps.LatLngBounds();
        polygons.forEach(function (polygon) {
            polygon.getPaths().forEach(function (path) {
                path.forEach(function (latLng) {
                    bounds.extend(latLng);
                });
            });
        });

        return bounds;
    };

    const fitBounds = function (bounds, maxZoom = 17, padding = 52) {
        if (bounds.isEmpty()) return;
        map.fitBounds(bounds, padding);
        google.maps.event.addListenerOnce(map, 'idle', function () {
            if (map.getZoom() > maxZoom) {
                map.setZoom(maxZoom);
            }
        });
    };

    const firstCoordinate = function (geometry) {
        let coordinates = geometry?.coordinates;

        while (Array.isArray(coordinates?.[0])) {
            coordinates = coordinates[0];
        }

        return Array.isArray(coordinates) && coordinates.length >= 2 ? coordinates : null;
    };

    const isLayerVisible = function (layer) {
        const statusMatches = activeStatus === 'all' || layer.feature.properties.status === activeStatus;
        const locationMatches = activeLocation === 'all' || layer.feature.properties.location_name === activeLocation;

        return statusMatches && locationMatches;
    };

    const fitVisibleParcels = function () {
        const visibleLayers = Array.from(parcelLayers.values()).filter(isLayerVisible);
        const bounds = new google.maps.LatLngBounds();

        visibleLayers.forEach(function (layer) {
            const layerBounds = layer.getBounds();
            bounds.extend(layerBounds.getNorthEast());
            bounds.extend(layerBounds.getSouthWest());
        });

        fitBounds(bounds, 17, 52);
    };

    const setActiveParcel = function (parcelId, options = {}) {
        const layer = parcelLayers.get(Number(parcelId));
        if (!layer) return;

        if (selectedLayer) {
            selectedLayer.setStyle(baseStyle(selectedLayer.feature));
        }

        selectedLayer = layer;
        selectedLayer.setStyle(selectedStyle(selectedLayer.feature));

        document.querySelectorAll('.parcel-item').forEach(function (item) {
            item.classList.toggle('is-active', Number(item.dataset.parcelId) === Number(parcelId));
        });

        if (options.scrollList) {
            document.querySelector(`.parcel-item[data-parcel-id="${parcelId}"]`)?.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }

        fitBounds(layer.getBounds(), 18, 80);
        infoWindow.setContent(layer.popupContent);
        infoWindow.setPosition(layer.getBounds().getCenter());
        infoWindow.open(map);
    };

    const applyFilters = function () {
        let visibleCount = 0;

        document.querySelectorAll('.parcel-item').forEach(function (item) {
            const statusMatches = activeStatus === 'all' || item.dataset.status === activeStatus;
            const locationMatches = activeLocation === 'all' || item.dataset.location === activeLocation;
            const isVisible = statusMatches && locationMatches;

            item.hidden = !isVisible;
            if (isVisible) visibleCount += 1;
        });

        parcelLayers.forEach(function (layer) {
            layer.setStyle(isLayerVisible(layer) ? baseStyle(layer.feature) : dimStyle(layer.feature));
        });

        if (selectedLayer) {
            selectedLayer.setStyle(selectedStyle(selectedLayer.feature));
        }

        resultCount.textContent = `${visibleCount.toLocaleString()} ${visibleCount === 1 ? 'plot' : 'plots'}`;
        emptyState.classList.toggle('is-visible', visibleCount === 0);
        mapCaption.textContent = activeStatus === 'all'
            ? `Showing all plots in ${activeLocation === 'all' ? 'all areas' : activeLocation}`
            : `Showing ${activeStatus.replace('_', ' ')} plots in ${activeLocation === 'all' ? 'all areas' : activeLocation}`;
        areaLabel.textContent = activeLocation === 'all' ? 'All areas' : activeLocation;
    };

    const response = await fetch('{{ route('api.parcels.geojson') }}');
    const parcels = await response.json();

    parcels.features.forEach(function (feature) {
        const p = feature.properties;
        const attrs = p.attributes || {};
        const interestUrl = `${contactUrl}?subject=${encodeURIComponent(`Interest in ${p.plot_number} - ${p.title}`)}`;
        const streetName = attrs.Street_Nam || attrs.street_name || 'Street name unavailable';
        const actionButtons = p.status === 'available'
            ? `<div class="map-popup-actions">
                    <a class="map-popup-action map-popup-action-primary js-plot-sale-soon" href="#">Buy</a>
                    <a class="map-popup-action map-popup-action-secondary js-plot-sale-soon" href="#">Reserve</a>
                    <a class="map-popup-action map-popup-action-ghost" href="${escapeHtml(interestUrl)}">Express Interest</a>
                </div>`
            : '';
        const price = Number(p.price) > 0
            ? `<p><strong>${escapeHtml(p.currency)} ${Number(p.price).toLocaleString()}</strong></p>`
            : '';
        const popupContent = `
            <div class="map-popup">
                <h4>${escapeHtml(p.plot_number)} - ${escapeHtml(p.title)}</h4>
                <p>${escapeHtml(p.location_name)}</p>
                <p><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:${escapeHtml(p.status_color)};margin-right:6px"></span>${escapeHtml(p.status_label)}</p>
                ${price}
                <p><strong>Size:</strong> ${Number(p.area_sqm).toLocaleString()} ${attrs.Area ? 'acres' : 'sqm'}</p>
                <p><strong>Plot:</strong> ${escapeHtml(p.plot_number)}</p>
                <p><strong>Street:</strong> ${escapeHtml(streetName)}</p>
                ${actionButtons}
                <div class="map-popup-actions" style="grid-template-columns:1fr;margin-top:7px;">
                    <a class="map-popup-action map-popup-action-ghost js-plot-sale-soon" href="#">View plot details</a>
                </div>
            </div>
        `;
        const polygons = polygonPaths(feature.geometry).map(function (paths) {
            const polygon = new google.maps.Polygon({ paths, map, ...baseStyle(feature) });
            polygon.addListener('click', function () {
                setActiveParcel(p.id, { scrollList: true });
            });

            return polygon;
        });

        if (polygons.length === 0) return;

        parcelLayers.set(Number(p.id), {
            feature,
            popupContent,
            polygons,
            setStyle(style) {
                this.polygons.forEach(function (polygon) {
                    polygon.setOptions(style);
                });
            },
            getBounds() {
                return boundsForPolygons(this.polygons);
            },
        });
    });

    const initialFeature = parcels.features.find(function (feature) {
        return feature.properties.status === 'available';
    }) || parcels.features[0];
    const initialCoordinate = firstCoordinate(initialFeature?.geometry);

    if (initialCoordinate) {
        map.setCenter({ lat: Number(initialCoordinate[1]), lng: Number(initialCoordinate[0]) });
        map.setZoom(17);
    }

    fitMapButton?.addEventListener('click', fitVisibleParcels);

    document.querySelectorAll('.parcel-filter').forEach(function (button) {
        button.addEventListener('click', function () {
            activeStatus = button.dataset.status;
            document.querySelectorAll('.parcel-filter').forEach(function (item) {
                item.classList.toggle('is-active', item === button);
            });
            applyFilters();
            fitVisibleParcels();
        });
    });

    document.querySelectorAll('.parcel-item').forEach(function (item) {
        item.addEventListener('click', function () {
            setActiveParcel(item.dataset.parcelId);
        });
        item.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                setActiveParcel(item.dataset.parcelId);
            }
        });
    });

    document.getElementById('parcel-map')?.addEventListener('click', function (event) {
        if (!event.target.closest('.js-plot-sale-soon')) return;

        event.preventDefault();
        alert('Plot will be on sale soon.');
    });

    applyFilters();
};
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initParcelMap"></script>
@endpush
