<?php

namespace App\Http\Controllers;

use App\Models\MortgageApplication;
use App\Models\PartnerBank;
use App\Models\PropertyListing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MortgageController extends Controller
{
    public function create(Request $request): View
    {
        return view('mortgage.create', [
            'banks' => PartnerBank::where('is_active', true)->orderBy('sort_order')->get(),
            'listings' => PropertyListing::where('is_published', true)->where('type', 'sale')->orderBy('title')->get(),
            'selectedListing' => $request->integer('property_listing_id') ?: null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['required', 'string', 'max:40'],
            'property_listing_id' => ['nullable', 'exists:property_listings,id'],
            'partner_bank_id' => ['nullable', 'exists:partner_banks,id'],
            'property_price' => ['nullable', 'numeric', 'min:0'],
            'down_payment' => ['nullable', 'numeric', 'min:0'],
            'monthly_income' => ['nullable', 'numeric', 'min:0'],
            'loan_term_years' => ['required', 'integer', 'min:1', 'max:30'],
            'employment_status' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        MortgageApplication::create($data + ['status' => 'new']);

        return back()->with('status', 'Your mortgage inquiry has been sent. A partner bank relationship officer will follow up.');
    }
}
