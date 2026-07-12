<?php

namespace App\Http\Controllers;

use App\Models\PropertyListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminListingController extends Controller
{
    public function index(): View
    {
        return view('admin.listings.index', ['listings' => PropertyListing::latest()->get()]);
    }

    public function create(): View
    {
        return view('admin.listings.form', ['listing' => new PropertyListing()]);
    }

    public function store(Request $request): RedirectResponse
    {
        PropertyListing::create($this->validated($request, new PropertyListing()));

        return redirect()->route('admin.listings.index')->with('status', 'Listing created.');
    }

    public function edit(PropertyListing $listing): View
    {
        return view('admin.listings.form', compact('listing'));
    }

    public function update(Request $request, PropertyListing $listing): RedirectResponse
    {
        $listing->update($this->validated($request, $listing));

        return redirect()->route('admin.listings.index')->with('status', 'Listing updated.');
    }

    private function validated(Request $request, PropertyListing $listing): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'type' => ['required', 'in:sale,rent,land'],
            'status' => ['required', 'in:available,reserved,sold,on_hold'],
            'address' => ['required', 'string', 'max:180'],
            'city' => ['required', 'string', 'max:120'],
            'region' => ['required', 'string', 'max:120'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'bathrooms' => ['required', 'integer', 'min:0'],
            'area_sqm' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string'],
            'features' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:8192'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['string'],
            'is_featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['features'] = array_values(array_filter(array_map('trim', explode("\n", $data['features'] ?? ''))));

        $remaining = array_values(array_diff($listing->image_paths ?? [], $data['remove_images'] ?? []));
        $uploaded = array_map(
            fn ($file) => Storage::disk('r2')->url($file->store('listings', 'r2')),
            $request->file('images', []),
        );
        $data['image_paths'] = array_merge($remaining, $uploaded);
        unset($data['images'], $data['remove_images']);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
}
