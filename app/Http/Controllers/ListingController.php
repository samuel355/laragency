<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\PropertyListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function index(Request $request): View
    {
        $query = PropertyListing::query()
            ->select(PropertyListing::CARD_COLUMNS)
            ->with('agent:id,name,slug,image_path')
            ->where('is_published', true);

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        if ($request->filled('property_type')) {
            $query->where('property_type', $request->string('property_type'));
        }

        if ($request->filled('city')) {
            $query->where('city', 'ilike', '%'.$request->string('city').'%');
        }

        if ($request->filled('price_range') && str_contains((string) $request->string('price_range'), ';')) {
            [$minPrice, $maxPrice] = explode(';', (string) $request->string('price_range'), 2);
            $query->whereBetween('price', [(float) $minPrice, (float) $maxPrice]);
        } else {
            if ($request->filled('min_price')) {
                $query->where('price', '>=', $request->float('min_price'));
            }

            if ($request->filled('max_price')) {
                $query->where('price', '<=', $request->float('max_price'));
            }
        }

        if ($request->integer('bedrooms') > 0) {
            $query->where('bedrooms', '>=', $request->integer('bedrooms'));
        }

        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->integer('bathrooms'));
        }

        if ($request->filled('min_area')) {
            $query->where('area_sqm', '>=', $request->float('min_area'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        if ($request->boolean('is_investment')) {
            $query->where('is_investment', true);
        }

        if ($request->boolean('new')) {
            $query->where('is_new', true);
        }

        $sort = $request->string('sort', 'latest');
        match ((string) $sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        return view('listings.index', [
            'listings' => $query->paginate(12)->withQueryString(),
            'propertyTypes' => PropertyListing::propertyTypeOptions(),
            'view' => $request->string('view', 'grid'),
        ]);
    }

    public function show(PropertyListing $listing): View
    {
        abort_unless($listing->is_published, 404);

        $listing->load('agent:id,name,slug,image_path,email,phone,bio,social_links');

        return view('listings.show', [
            'listing' => $listing,
            'related' => PropertyListing::query()
                ->select(PropertyListing::CARD_COLUMNS)
                ->with('agent:id,name,slug,image_path')
                ->where('is_published', true)
                ->where('id', '!=', $listing->id)
                ->latest()
                ->limit(3)
                ->get(),
        ]);
    }

    public function inquire(Request $request, PropertyListing $listing): RedirectResponse
    {
        Inquiry::create($request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'message' => ['required', 'string', 'max:3000'],
        ]) + [
            'source' => 'listing',
            'subject' => 'Inquiry for '.$listing->title,
            'property_listing_id' => $listing->id,
        ]);

        return back()->with('status', 'Your property inquiry has been sent.');
    }
}
