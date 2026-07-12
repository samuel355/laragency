<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ParcelController extends Controller
{
    public function index(): View
    {
        return view('parcels.index', [
            'parcels' => Parcel::query()
                ->select(['id', 'plot_number', 'title', 'location_name', 'price', 'currency', 'area_sqm', 'status', 'created_at'])
                ->whereNotNull('attributes->project_area')
                ->latest()
                ->get(),
        ]);
    }

    public function show(Parcel $parcel): View
    {
        return view('parcels.show', compact('parcel'));
    }

    public function geoJson(): JsonResponse
    {
        return response()->json(Cache::remember('parcels.geojson', now()->addMinutes(10), fn (): array => [
            'type' => 'FeatureCollection',
            'features' => Parcel::query()
                ->whereNotNull('attributes->project_area')
                ->get()
                ->map(fn (Parcel $parcel) => $parcel->toGeoJsonFeature())
                ->values()
                ->all(),
        ]))->setPublic()->setMaxAge(600)->setSharedMaxAge(600);
    }
}
