@extends('layouts.app')

@section('title', ($parcel->exists ? 'Edit' : 'Add').' Parcel - Rentstate')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="list-single-main-item fl-wrap">
            <div class="list-single-main-item-title">
                <h3>{{ $parcel->exists ? 'Edit Parcel' : 'Add Parcel' }}</h3>
            </div>
            <form method="POST" action="{{ $parcel->exists ? route('admin.parcels.update', $parcel) : route('admin.parcels.store') }}" class="custom-form">
                @csrf
                @if($parcel->exists)
                    @method('PUT')
                @endif
                <label>Plot number</label>
                <input name="plot_number" value="{{ old('plot_number', $parcel->plot_number) }}" required>
                <label>Title</label>
                <input name="title" value="{{ old('title', $parcel->title) }}" required>
                <label>Location</label>
                <input name="location_name" value="{{ old('location_name', $parcel->location_name) }}" required>
                <label>Price</label>
                <input name="price" type="number" step="0.01" value="{{ old('price', $parcel->price) }}" required>
                <label>Currency</label>
                <input name="currency" maxlength="3" value="{{ old('currency', $parcel->currency ?: 'GHS') }}" required>
                <label>Area sqm</label>
                <input name="area_sqm" type="number" step="0.01" value="{{ old('area_sqm', $parcel->area_sqm) }}" required>
                <label>Status</label>
                <select name="status">
                    @foreach(['available', 'reserved', 'sold', 'on_hold'] as $status)
                        <option value="{{ $status }}" @selected(old('status', $parcel->status ?: 'available') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <label>GeoJSON Polygon Geometry</label>
                <textarea name="geometry" rows="8" required>{{ old('geometry', $parcel->geometry ? json_encode($parcel->geometry, JSON_PRETTY_PRINT) : "{\n  \"type\": \"Polygon\",\n  \"coordinates\": [[[ -0.1691, 5.6982 ], [ -0.1678, 5.6983 ], [ -0.1677, 5.6969 ], [ -0.1690, 5.6968 ], [ -0.1691, 5.6982 ]]]\n}") }}</textarea>
                <label>Attributes JSON</label>
                <textarea name="attributes" rows="5">{{ old('attributes', $parcel->getAttribute('attributes') ? json_encode($parcel->getAttribute('attributes'), JSON_PRETTY_PRINT) : "{\n  \"zoning\": \"Residential\",\n  \"tenure\": \"Freehold\",\n  \"road_access\": \"Titled road\"\n}") }}</textarea>
                @if($errors->any())
                    <p class="error" style="color:#c0392b;">{{ $errors->first() }}</p>
                @endif
                <button class="btn float-btn color-bg" type="submit">Save Parcel</button>
            </form>
        </div>
    </div>
</section>
@endsection
