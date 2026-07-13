<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\MortgageApplication;
use App\Models\SiteVisit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class AdminRequestController extends Controller
{
    public function index(): View
    {
        $inquiries = Inquiry::with('listing')->latest()->get()->map(fn (Inquiry $inquiry) => [
            'type' => 'inquiry',
            'icon' => 'fa-envelope',
            'id' => $inquiry->id,
            'name' => $inquiry->name,
            'email' => $inquiry->email,
            'phone' => $inquiry->phone,
            'heading' => $inquiry->subject,
            'context' => $inquiry->listing?->title,
            'context_url' => $inquiry->listing ? route('listings.show', $inquiry->listing) : null,
            'image' => $inquiry->listing?->primaryImage(),
            'status' => $inquiry->status,
            'created_at' => $inquiry->created_at,
        ]);

        $siteVisits = SiteVisit::with(['listing', 'parcel'])->latest()->get()->map(fn (SiteVisit $visit) => [
            'type' => 'site_visit',
            'icon' => 'fa-house-building',
            'id' => $visit->id,
            'name' => $visit->name,
            'email' => $visit->email,
            'phone' => $visit->phone,
            'heading' => 'Site visit — '.$visit->preferred_date?->format('d M Y').' at '.$visit->preferred_time,
            'context' => $visit->listing?->title ?? $visit->parcel?->title,
            'context_url' => $visit->listing ? route('listings.show', $visit->listing) : ($visit->parcel ? route('parcels.show', $visit->parcel) : null),
            'image' => $visit->listing?->primaryImage(),
            'status' => $visit->status,
            'created_at' => $visit->created_at,
        ]);

        $mortgageApps = MortgageApplication::with('listing')->latest()->get()->map(fn (MortgageApplication $app) => [
            'type' => 'mortgage',
            'icon' => 'fa-calculator',
            'id' => $app->id,
            'name' => $app->name,
            'email' => $app->email,
            'phone' => $app->phone,
            'heading' => 'Mortgage inquiry — GHS '.number_format((float) $app->property_price),
            'context' => $app->listing?->title,
            'context_url' => $app->listing ? route('listings.show', $app->listing) : null,
            'image' => $app->listing?->primaryImage(),
            'status' => $app->status,
            'created_at' => $app->created_at,
        ]);

        /** @var Collection $requests */
        $requests = $inquiries->concat($siteVisits)->concat($mortgageApps)
            ->sortByDesc('created_at')
            ->values();

        return view('admin.requests.index', [
            'requests' => $requests,
            'counts' => [
                'inquiry' => $inquiries->count(),
                'site_visit' => $siteVisits->count(),
                'mortgage' => $mortgageApps->count(),
            ],
        ]);
    }

    public function destroy(string $type, int $id): RedirectResponse
    {
        $model = match ($type) {
            'inquiry' => Inquiry::class,
            'site_visit' => SiteVisit::class,
            'mortgage' => MortgageApplication::class,
            default => abort(404),
        };

        $model::findOrFail($id)->delete();

        return back()->with('status', 'Request removed.');
    }
}
