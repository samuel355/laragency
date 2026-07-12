@props(['listing'])

<div class="geodir-category-listing">
    <div class="geodir-category-img">
        <a href="{{ route('listings.show', $listing) }}" class="geodir-category-img_item">
            <div class="bg" data-bg="{{ $listing->primaryImage() }}"></div>
            <div class="overlay"></div>
        </a>
        @if($listing->latitude && $listing->longitude)
            <div class="geodir-category-location">
                <a href="#" class="map-item tolt single-map-item" data-newlatitude="{{ $listing->latitude }}" data-newlongitude="{{ $listing->longitude }}" data-microtip-position="top" data-tooltip="On the map">
                    <i class="fas fa-map-marker-alt"></i> {{ $listing->city }}, {{ $listing->region }}
                </a>
            </div>
        @endif
        <ul class="list-single-opt_header_cat">
            <li><a href="#" class="cat-opt">{{ ucfirst($listing->type) }}</a></li>
            <li><a href="#" class="cat-opt">{{ \App\Models\PropertyListing::propertyTypeOptions()[$listing->property_type] ?? ucfirst($listing->property_type) }}</a></li>
            @if($listing->status === 'sold')
                <li><a href="#" class="cat-opt">Sold</a></li>
            @elseif($listing->is_investment)
                <li><a href="#" class="cat-opt">Investment</a></li>
            @elseif($listing->is_new)
                <li><a href="#" class="cat-opt">New</a></li>
            @endif
        </ul>
        <a href="#" class="geodir_save-btn tolt" data-microtip-position="left" data-tooltip="Save"><span><i class="fal fa-heart"></i></span></a>
        <div class="geodir-category-listing_media-list">
            <span><i class="fas fa-camera"></i> {{ count($listing->image_paths ?? []) }}</span>
        </div>
    </div>
    <div class="geodir-category-content">
        <h3><a href="{{ route('listings.show', $listing) }}">{{ $listing->title }}</a></h3>
        <div class="geodir-category-content_price">{{ $listing->formattedPrice() }}@if($listing->type === 'rent') / per month @endif</div>
        <p>{{ \Illuminate\Support\Str::limit($listing->description, 120) }}</p>
        @unless($listing->property_type === 'land')
            <div class="geodir-category-content-details">
                <ul>
                    <li><i class="fa-light fa-bed"></i><span>{{ $listing->bedrooms }}</span></li>
                    <li><i class="fa-light fa-bath"></i><span>{{ $listing->bathrooms }}</span></li>
                    <li><i class="fa-light fa-chart-area"></i><span>{{ number_format((float) $listing->area_sqm) }} sqm</span></li>
                </ul>
            </div>
        @else
            <div class="geodir-category-content-details">
                <ul>
                    <li><i class="fa-light fa-chart-area"></i><span>{{ number_format((float) $listing->area_sqm) }} sqm</span></li>
                </ul>
            </div>
        @endunless
    </div>
    <div class="geodir-category-footer">
        @if($listing->agent)
            <a href="{{ route('team.show', $listing->agent) }}" class="gcf-company"><img src="{{ asset($listing->agent->image_path) }}" alt="{{ $listing->agent->name }}" loading="lazy" decoding="async"><span>By {{ $listing->agent->name }}</span></a>
        @else
            <span></span>
        @endif
        <a href="{{ route('listings.show', $listing) }}" class="gid_link"><span>View Details</span> <i class="fa-solid fa-caret-right"></i></a>
    </div>
</div>
