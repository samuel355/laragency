<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\MortgageApplication;
use App\Models\Order;
use App\Models\Parcel;
use App\Models\PropertyListing;
use App\Models\SiteVisit;
use App\Models\TeamMember;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $chartWeeks = collect(range(7, 0))->map(function (int $weeksAgo) {
            $start = now()->subWeeks($weeksAgo)->startOfWeek();
            $end = now()->subWeeks($weeksAgo)->endOfWeek();

            return [
                'label' => $start->format('d M'),
                'inquiries' => Inquiry::whereBetween('created_at', [$start, $end])->count(),
                'bookings' => SiteVisit::whereBetween('created_at', [$start, $end])->count()
                    + MortgageApplication::whereBetween('created_at', [$start, $end])->count(),
            ];
        });

        $activity = collect()
            ->concat(Inquiry::with('listing')->latest()->take(5)->get()->map(fn (Inquiry $i) => [
                'icon' => 'fa-envelope', 'created_at' => $i->created_at,
                'text' => "New inquiry from {$i->name}".($i->listing ? " about {$i->listing->title}" : ''),
                'url' => route('admin.requests.index'),
            ]))
            ->concat(SiteVisit::latest()->take(5)->get()->map(fn (SiteVisit $v) => [
                'icon' => 'fa-house-building', 'created_at' => $v->created_at,
                'text' => "{$v->name} requested a site visit",
                'url' => route('admin.requests.index'),
            ]))
            ->concat(MortgageApplication::latest()->take(5)->get()->map(fn (MortgageApplication $m) => [
                'icon' => 'fa-calculator', 'created_at' => $m->created_at,
                'text' => "{$m->name} submitted a mortgage application",
                'url' => route('admin.requests.index'),
            ]))
            ->concat(Order::latest()->take(5)->get()->map(fn (Order $o) => [
                'icon' => 'fa-sack-dollar', 'created_at' => $o->created_at,
                'text' => "{$o->buyer_name} ".($o->status === 'paid' ? 'paid' : 'started checkout for')." GHS ".number_format((float) $o->amount),
                'url' => route('admin.orders.index'),
            ]))
            ->sortByDesc('created_at')
            ->take(8)
            ->values();

        return view('admin.dashboard', [
            'listingCount' => PropertyListing::count(),
            'publishedListingCount' => PropertyListing::where('is_published', true)->count(),
            'parcelCount' => Parcel::count(),
            'teamCount' => TeamMember::where('is_active', true)->count(),
            'newLeadsCount30d' => Inquiry::where('created_at', '>=', now()->subDays(30))->count()
                + SiteVisit::where('created_at', '>=', now()->subDays(30))->count()
                + MortgageApplication::where('created_at', '>=', now()->subDays(30))->count(),
            'revenue' => Order::where('status', 'paid')->sum('amount'),
            'chartWeeks' => $chartWeeks,
            'activity' => $activity,
        ]);
    }
}
