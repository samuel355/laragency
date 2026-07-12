@extends('layouts.app')

@section('title', ($listing->exists ? 'Edit' : 'Add').' Listing - BlueGate Realty')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="list-single-main-item fl-wrap">
            <div class="list-single-main-item-title"><h3>{{ $listing->exists ? 'Edit Listing' : 'Add Listing' }}</h3></div>
            <form method="POST" action="{{ $listing->exists ? route('admin.listings.update', $listing) : route('admin.listings.store') }}" class="custom-form" enctype="multipart/form-data">
                @csrf
                @if($listing->exists) @method('PUT') @endif
                <label>Title</label><input name="title" value="{{ old('title', $listing->title) }}" required>
                <label>Type</label>
                <select name="type">@foreach(['sale','rent','land'] as $type)<option value="{{ $type }}" @selected(old('type', $listing->type ?: 'sale') === $type)>{{ ucfirst($type) }}</option>@endforeach</select>
                <label>Status</label>
                <select name="status">@foreach(['available','reserved','sold','on_hold'] as $status)<option value="{{ $status }}" @selected(old('status', $listing->status ?: 'available') === $status)>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>@endforeach</select>
                <label>Address</label><input name="address" value="{{ old('address', $listing->address) }}" required>
                <label>City</label><input name="city" value="{{ old('city', $listing->city) }}" required>
                <label>Region</label><input name="region" value="{{ old('region', $listing->region) }}" required>
                <label>Price</label><input type="number" step="0.01" name="price" value="{{ old('price', $listing->price) }}" required>
                <label>Currency</label><input name="currency" maxlength="3" value="{{ old('currency', $listing->currency ?: 'GHS') }}" required>
                <label>Bedrooms</label><input type="number" name="bedrooms" value="{{ old('bedrooms', $listing->bedrooms ?: 0) }}" required>
                <label>Bathrooms</label><input type="number" name="bathrooms" value="{{ old('bathrooms', $listing->bathrooms ?: 0) }}" required>
                <label>Area sqm</label><input type="number" step="0.01" name="area_sqm" value="{{ old('area_sqm', $listing->area_sqm ?: 0) }}" required>
                <label>Description</label><textarea name="description" rows="7" required>{{ old('description', $listing->description) }}</textarea>
                <label>Features, one per line</label><textarea name="features" rows="5">{{ old('features', implode("\n", $listing->features ?? [])) }}</textarea>
                @if($listing->exists && !empty($listing->image_paths))
                    <label>Current photos</label>
                    <div style="display:flex; flex-wrap:wrap; gap:14px; margin-bottom:18px;">
                        @foreach($listing->image_paths as $path)
                            <label style="display:block; width:140px;">
                                <img src="{{ $path }}" alt="" style="width:140px; height:100px; object-fit:cover; border-radius:8px; border:1px solid var(--app-border); display:block; margin-bottom:6px;">
                                <span style="display:flex; align-items:center; gap:6px; font-weight:400;">
                                    <input type="checkbox" name="remove_images[]" value="{{ $path }}" style="width:auto;"> Remove
                                </span>
                            </label>
                        @endforeach
                    </div>
                @endif
                <label>Add photos</label>
                <div class="fuzone">
                    <div class="fu-text">
                        <span><i class="fa-light fa-cloud-arrow-up"></i> Click here or drop files to upload</span>
                        <div class="photoUpload-files fl-wrap"></div>
                    </div>
                    <input type="file" class="upload" name="images[]" accept="image/*" multiple>
                </div>
                <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $listing->is_featured))> Featured</label>
                <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $listing->exists ? $listing->is_published : true))> Published</label>
                @if($errors->any())<p class="error" style="color:#c0392b;">{{ $errors->first() }}</p>@endif
                <button class="btn float-btn color-bg" type="submit">Save Listing</button>
            </form>
        </div>
    </div>
</section>
@endsection
