<?php

namespace App\Http\Controllers;

use App\Models\AgencyService;
use App\Models\Community;
use App\Models\CompanyStat;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\PartnerBank;
use App\Models\PropertyListing;
use App\Models\SiteContent;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        $publishedListings = PropertyListing::query()
            ->select(PropertyListing::CARD_COLUMNS)
            ->with('agent:id,name,slug,image_path')
            ->where('is_published', true);

        return view('pages.home', [
            'hero' => SiteContent::where('key', 'home_hero')->first(),
            'about' => SiteContent::where('key', 'about')->first(),
            'whyChooseUs' => SiteContent::where('key', 'why_choose_us')->first(),
            'services' => AgencyService::where('is_active', true)->orderBy('sort_order')->limit(4)->get(),
            'latestListings' => (clone $publishedListings)->latest()->limit(3)->get(),
            'communities' => Community::where('is_active', true)->withCount('listings')->orderBy('sort_order')->get(),
            'stats' => CompanyStat::where('is_active', true)->orderBy('sort_order')->get(),
            'testimonials' => Testimonial::where('is_active', true)->orderBy('sort_order')->get(),
            'partnerBanks' => PartnerBank::where('is_active', true)->orderBy('sort_order')->get(),
            'propertyTypes' => PropertyListing::propertyTypeOptions(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about', [
            'content' => SiteContent::where('key', 'about')->first(),
            'mission' => SiteContent::where('key', 'mission')->first(),
            'vision' => SiteContent::where('key', 'vision')->first(),
            'stats' => CompanyStat::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function services(): View
    {
        return view('pages.services', [
            'services' => AgencyService::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function faq(): View
    {
        return view('pages.faq', [
            'faqs' => Faq::where('is_active', true)->orderBy('category')->orderBy('sort_order')->get(),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact', [
            'content' => SiteContent::where('key', 'contact')->first(),
        ]);
    }

    public function storeContact(Request $request): RedirectResponse
    {
        Inquiry::create($request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:3000'],
        ]) + ['source' => 'contact']);

        return back()->with('status', 'Your request has been sent.');
    }
}
