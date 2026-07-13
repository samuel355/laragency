@extends('layouts.admin')

@section('title', ($parcel->exists ? 'Edit' : 'Add').' Parcel - SOMA PROPERTIES')
@section('admin-title', 'Land Parcels')

@push('styles')
<style>
    .form-section-title { color: var(--app-blue-900); font-size: 14px; font-weight: 800; letter-spacing: .02em; text-transform: uppercase; margin: 30px 0 14px; }
    .form-section-title:first-child { margin-top: 0; }
    .plot-panel { background: #fff; border: 1px solid var(--app-border); border-radius: 8px; box-shadow: 0 18px 40px rgba(15, 54, 110, .08); }
    .plot-map-panel { overflow: hidden; padding: 0; }
    .plot-map-head { align-items: center; border-bottom: 1px solid var(--app-border); display: flex; justify-content: space-between; gap: 12px; padding: 16px 18px; }
    .plot-map-head h3 { margin: 0; font-size: 15px; color: var(--app-blue-900); }
    .plot-map-head span { color: var(--app-muted); font-size: 11px; font-weight: 800; text-transform: uppercase; }
    #parcel-form-map { height: 340px; width: 100%; background: var(--app-blue-050); }
    .plot-side-note { padding: 14px 18px 18px; }
    .plot-side-note p { color: var(--app-muted); font-size: 13px; line-height: 1.6; margin: 0; }
</style>
@endpush

@section('admin-content')
<div class="list-single-main-item fl-wrap">
    <div class="list-single-main-item-title">
        <h3>{{ $parcel->exists ? 'Edit Parcel' : 'Add Parcel' }}</h3>
    </div>
    <form method="POST" action="{{ $parcel->exists ? route('admin.parcels.update', $parcel) : route('admin.parcels.store') }}" class="custom-form">
        @csrf
        @if($parcel->exists)
            @method('PUT')
        @endif

        <div class="form-section-title">Plot Details</div>
        <div class="row">
            <div class="col-lg-4">
                <div class="cs-intputwrap"><i class="fa-light fa-hashtag"></i><input name="plot_number" placeholder="Plot Number" value="{{ old('plot_number', $parcel->plot_number) }}" required></div>
            </div>
            <div class="col-lg-4">
                <div class="cs-intputwrap"><i class="fa-light fa-signature"></i><input name="title" placeholder="Title" value="{{ old('title', $parcel->title) }}" required></div>
            </div>
            <div class="col-lg-4">
                <div class="cs-intputwrap"><i class="fa-light fa-location-dot"></i><input name="location_name" placeholder="Location" value="{{ old('location_name', $parcel->location_name) }}" required></div>
            </div>
        </div>

        <div class="form-section-title">Pricing &amp; Size</div>
        <div class="row">
            <div class="col-lg-4">
                <div class="cs-intputwrap"><i class="fa-light fa-tag"></i><input name="price" type="number" step="0.01" placeholder="Price" value="{{ old('price', $parcel->price) }}" required></div>
            </div>
            <div class="col-lg-4">
                <div class="cs-intputwrap"><i class="fa-light fa-coins"></i><input name="currency" maxlength="3" placeholder="Currency" value="{{ old('currency', $parcel->currency ?: 'GHS') }}" required></div>
            </div>
            <div class="col-lg-4">
                <div class="cs-intputwrap"><i class="fa-light fa-ruler-combined"></i><input name="area_sqm" type="number" step="0.01" placeholder="Area (sqm)" value="{{ old('area_sqm', $parcel->area_sqm) }}" required></div>
            </div>
        </div>

        <div class="form-section-title">Status</div>
        <div class="row">
            <div class="col-lg-4">
                <div class="cs-intputwrap">
                    <i class="fa-light fa-list-check"></i>
                    <select name="status" data-placeholder="Status" class="chosen-select on-radius no-search-select">
                        @foreach(['available', 'reserved', 'sold', 'on_hold'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $parcel->status ?: 'available') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section-title">Boundary</div>
        <div class="row">
            <div class="col-lg-7">
                <label>GeoJSON Polygon Geometry</label>
                <textarea id="parcel-geometry-input" name="geometry" rows="12" required>{{ old('geometry', $parcel->geometry ? json_encode($parcel->geometry, JSON_PRETTY_PRINT) : "{\n  \"type\": \"Polygon\",\n  \"coordinates\": [[[ -0.1691, 5.6982 ], [ -0.1678, 5.6983 ], [ -0.1677, 5.6969 ], [ -0.1690, 5.6968 ], [ -0.1691, 5.6982 ]]]\n}") }}</textarea>
                <label>Attributes JSON</label>
                <textarea name="attributes" rows="5">{{ old('attributes', $parcel->getAttribute('attributes') ? json_encode($parcel->getAttribute('attributes'), JSON_PRETTY_PRINT) : "{\n  \"zoning\": \"Residential\",\n  \"tenure\": \"Freehold\",\n  \"road_access\": \"Titled road\"\n}") }}</textarea>
            </div>
            <div class="col-lg-5">
                <div class="plot-panel plot-map-panel">
                    <div class="plot-map-head">
                        <div>
                            <h3>Boundary Preview</h3>
                            <span>Live from geometry field</span>
                        </div>
                    </div>
                    <div id="parcel-form-map"></div>
                    <div class="plot-side-note">
                        <p>Updates automatically as you edit the GeoJSON above. Invalid JSON just leaves the last valid shape on the map.</p>
                    </div>
                </div>
            </div>
        </div>

        @if($errors->any())
            <p class="error" style="color:#c0392b;">{{ $errors->first() }}</p>
        @endif
        <button class="btn float-btn color-bg" type="submit">Save Parcel</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function parcelFormDebounce(fn, wait) {
        let timer;
        return function () {
            clearTimeout(timer);
            const args = arguments;
            timer = setTimeout(function () { fn.apply(null, args); }, wait);
        };
    }

    window.initParcelFormMap = function () {
        const textarea = document.getElementById('parcel-geometry-input');
        const map = new google.maps.Map(document.getElementById('parcel-form-map'), {
            center: { lat: 5.69, lng: -0.12 },
            zoom: 13,
            mapTypeId: 'hybrid',
            zoomControl: true,
            streetViewControl: false,
            fullscreenControl: true,
            mapTypeControl: false,
        });

        let currentPolygons = [];

        function clearPolygons() {
            currentPolygons.forEach(function (polygon) { polygon.setMap(null); });
            currentPolygons = [];
        }

        function polygonPaths(geometry) {
            const polygons = geometry.type === 'MultiPolygon' ? geometry.coordinates : [geometry.coordinates];

            return polygons.map(function (polygon) {
                return polygon.map(function (ring) {
                    return ring.map(function (coordinate) {
                        return { lat: Number(coordinate[1]), lng: Number(coordinate[0]) };
                    });
                });
            });
        }

        function render() {
            let geometry;
            try {
                geometry = JSON.parse(textarea.value);
            } catch (e) {
                return;
            }
            if (!geometry || !geometry.coordinates) {
                return;
            }

            clearPolygons();
            const bounds = new google.maps.LatLngBounds();
            polygonPaths(geometry).forEach(function (paths) {
                const polygon = new google.maps.Polygon({
                    paths,
                    map,
                    strokeColor: '#1f6feb',
                    strokeWeight: 3,
                    strokeOpacity: 1,
                    fillColor: '#1f6feb',
                    fillOpacity: 0.42,
                });

                polygon.getPaths().forEach(function (path) {
                    path.forEach(function (latLng) { bounds.extend(latLng); });
                });

                currentPolygons.push(polygon);
            });

            if (currentPolygons.length > 0 && !bounds.isEmpty()) {
                map.fitBounds(bounds, 40);
                google.maps.event.addListenerOnce(map, 'idle', function () {
                    if (map.getZoom() > 18) map.setZoom(18);
                });
            }
        }

        textarea.addEventListener('input', parcelFormDebounce(render, 400));
        render();
    };
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&callback=initParcelFormMap"></script>
@endpush
