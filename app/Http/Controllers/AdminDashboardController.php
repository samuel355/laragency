<?php

namespace App\Http\Controllers;

use App\Models\AgencyService;
use App\Models\BlogPost;
use App\Models\Faq;
use App\Models\Parcel;
use App\Models\PropertyListing;
use App\Models\TeamMember;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'listingCount' => PropertyListing::count(),
            'publishedListingCount' => PropertyListing::where('is_published', true)->count(),
            'parcelCount' => Parcel::count(),
            'availableParcelCount' => Parcel::where('status', 'available')->count(),
            'serviceCount' => AgencyService::where('is_active', true)->count(),
            'blogPostCount' => BlogPost::where('is_published', true)->count(),
            'teamCount' => TeamMember::where('is_active', true)->count(),
            'faqCount' => Faq::where('is_active', true)->count(),
        ]);
    }
}
