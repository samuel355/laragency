@extends('layouts.app')

@section('title', 'Mortgage Inquiry - SOMA PROPERTIES')

@section('content')
<!--section-->
<div class="section hero-section hero-section_sin">
    <div class="hero-section-wrap">
        <div class="hero-section-wrap-item">
            <div class="container">
                <div class="hero-section-container">
                    <div class="hero-section-title">
                        <h2>Mortgage Inquiry</h2>
                        <h5>Estimate a monthly repayment, then send your details to a relationship officer at GCB, Ecobank, Stanbic, CalBank, or Fidelity.</h5>
                    </div>
                </div>
            </div>
            <div class="bg-wrap bg-hero bg-parallax-wrap-gradien fs-wrapper">
                <div class="bg" data-bg="{{ asset('light/images/bg/10.jpg') }}"></div>
            </div>
        </div>
    </div>
</div>
<!--section-end-->

<div class="container">
    <div class="breadcrumbs-list bl_flat">
        <a href="{{ route('home') }}">Home</a> <span>Mortgage Inquiry</span>
        <div class="breadcrumbs-list_dec"><i class="fa-thin fa-arrow-up"></i></div>
    </div>
    <div class="main-content ms_vir_height">
        <div class="boxed-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="boxed-content">
                        <div class="boxed-content-title"><h3>Affordability Calculator</h3></div>
                        <div class="boxed-content-item">
                            <div class="custom-form">
                                <div class="row">
                                    <div class="col-sm-6"><div class="cs-intputwrap"><i class="fa-light fa-sack-dollar"></i><input type="number" id="calc-price" value="1000000" min="0" placeholder="Property price (GHS)"></div></div>
                                    <div class="col-sm-6"><div class="cs-intputwrap"><i class="fa-light fa-coins"></i><input type="number" id="calc-down" value="200000" min="0" placeholder="Down payment (GHS)"></div></div>
                                    <div class="col-sm-6"><div class="cs-intputwrap"><i class="fa-light fa-percent"></i><input type="number" id="calc-rate" value="21" min="0" step="0.1" placeholder="Interest rate (% / year)"></div></div>
                                    <div class="col-sm-6"><div class="cs-intputwrap"><i class="fa-light fa-calendar-days"></i><input type="number" id="calc-term" value="15" min="1" max="30" placeholder="Loan term (years)"></div></div>
                                </div>
                            </div>
                            <div class="property-single-header-price" style="margin-top: 16px;">
                                <strong>Estimated Monthly Repayment:</strong>
                                <span class="pshp_item">GHS <span id="calc-result">0</span></span>
                            </div>
                        </div>
                    </div>

                    <div class="boxed-content">
                        <div class="boxed-content-title"><h3>Send Inquiry to a Partner Bank</h3></div>
                        <div class="boxed-content-item">
                            @if(session('status'))<p style="color: var(--app-blue-700); font-weight: 800;">{{ session('status') }}</p>@endif
                            <form method="POST" action="{{ route('mortgage.store') }}" class="custom-form">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6"><div class="cs-intputwrap"><i class="fa-light fa-user"></i><input name="name" placeholder="Full Name" value="{{ old('name') }}" required></div></div>
                                    <div class="col-sm-6"><div class="cs-intputwrap"><i class="fa-light fa-envelope"></i><input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required></div></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6"><div class="cs-intputwrap"><i class="fa-light fa-phone"></i><input name="phone" placeholder="Phone" value="{{ old('phone') }}" required></div></div>
                                    <div class="col-sm-6">
                                        <div class="cs-intputwrap">
                                            <i class="fa-light fa-building-columns"></i>
                                            <select data-placeholder="Preferred Bank" class="chosen-select on-radius no-search-select" name="partner_bank_id">
                                                <option value="">No preference</option>
                                                @foreach($banks as $bank)
                                                    <option value="{{ $bank->id }}" @selected(old('partner_bank_id') == $bank->id)>{{ $bank->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="cs-intputwrap">
                                            <i class="fa-light fa-house"></i>
                                            <select data-placeholder="Select a Listing" class="chosen-select on-radius no-search-select" name="property_listing_id">
                                                <option value="">Select a listing (optional)</option>
                                                @foreach($listings as $listing)
                                                    <option value="{{ $listing->id }}" @selected(old('property_listing_id', $selectedListing) == $listing->id)>{{ $listing->title }} — {{ $listing->formattedPrice() }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><div class="cs-intputwrap"><i class="fa-light fa-sack-dollar"></i><input type="number" name="property_price" id="form-price" placeholder="Property price" value="{{ old('property_price') }}"></div></div>
                                    <div class="col-sm-4"><div class="cs-intputwrap"><i class="fa-light fa-coins"></i><input type="number" name="down_payment" id="form-down" placeholder="Down payment" value="{{ old('down_payment') }}"></div></div>
                                    <div class="col-sm-4"><div class="cs-intputwrap"><i class="fa-light fa-wallet"></i><input type="number" name="monthly_income" placeholder="Monthly income" value="{{ old('monthly_income') }}"></div></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6"><div class="cs-intputwrap"><i class="fa-light fa-calendar"></i><input type="number" name="loan_term_years" id="form-term" placeholder="Loan term (years)" value="{{ old('loan_term_years', 15) }}" min="1" max="30"></div></div>
                                    <div class="col-sm-6"><div class="cs-intputwrap"><i class="fa-light fa-briefcase"></i><input name="employment_status" placeholder="Employment status" value="{{ old('employment_status') }}"></div></div>
                                </div>
                                <textarea name="notes" placeholder="Notes (optional)">{{ old('notes') }}</textarea>
                                <button class="commentssubmit commentssubmit_fw" type="submit" style="margin-top: 20px;">Send Mortgage Inquiry</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="boxed-content">
                        <div class="boxed-content-title"><h3>Our Partner Banks</h3></div>
                        <div class="boxed-content-item">
                            @foreach($banks as $bank)
                                <div class="property-contacts_profile" style="margin-bottom: 14px;">
                                    <img src="{{ asset($bank->logo_path) }}" alt="{{ $bank->name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px; vertical-align: middle;">
                                    <strong style="color: var(--app-navy-900);">{{ $bank->name }}</strong>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function bgrCalcMortgage() {
        const price = parseFloat(document.getElementById('calc-price').value) || 0;
        const down = parseFloat(document.getElementById('calc-down').value) || 0;
        const rate = (parseFloat(document.getElementById('calc-rate').value) || 0) / 100 / 12;
        const term = (parseFloat(document.getElementById('calc-term').value) || 1) * 12;
        const principal = Math.max(price - down, 0);
        let payment = 0;
        if (rate > 0) {
            payment = principal * (rate * Math.pow(1 + rate, term)) / (Math.pow(1 + rate, term) - 1);
        } else {
            payment = principal / term;
        }
        document.getElementById('calc-result').textContent = payment.toLocaleString(undefined, {maximumFractionDigits: 0});
        document.getElementById('form-price').value = price || '';
        document.getElementById('form-down').value = down || '';
        document.getElementById('form-term').value = document.getElementById('calc-term').value;
    }
    ['calc-price', 'calc-down', 'calc-rate', 'calc-term'].forEach(function (id) {
        document.getElementById(id).addEventListener('input', bgrCalcMortgage);
    });
    bgrCalcMortgage();
</script>
@endpush
@endsection
