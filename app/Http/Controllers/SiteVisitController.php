<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use App\Models\PropertyListing;
use App\Models\SiteVisit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteVisitController extends Controller
{
    public function create(Request $request): View
    {
        return view('site-visits.create', [
            'listings' => PropertyListing::where('is_published', true)->orderBy('title')->get(),
            'parcels' => Parcel::where('status', 'available')->orderBy('title')->get(),
            'selectedListing' => $request->integer('property_listing_id') ?: null,
            'selectedParcel' => $request->integer('parcel_id') ?: null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:40'],
            'property_listing_id' => ['nullable', 'exists:property_listings,id'],
            'parcel_id' => ['nullable', 'exists:parcels,id'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['nullable', 'string', 'max:40'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        SiteVisit::create($data + ['status' => 'requested']);

        return back()->with('status', 'Your site visit request has been received. Our team will confirm timing shortly.');
    }
}
