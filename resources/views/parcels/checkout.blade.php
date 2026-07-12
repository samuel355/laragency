@extends('layouts.app')

@section('title', 'Checkout - '.$parcel->plot_number)

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="list-single-main-item fl-wrap">
                    <div class="list-single-main-item-title"><h3>Buyer Details</h3></div>
                    <form method="POST" action="{{ route('parcels.checkout.store', $parcel) }}" class="custom-form">
                        @csrf
                        <label>Name</label>
                        <input type="text" name="buyer_name" value="{{ old('buyer_name') }}" required>
                        <label>Email</label>
                        <input type="email" name="buyer_email" value="{{ old('buyer_email') }}" required>
                        <label>Phone</label>
                        <input type="text" name="buyer_phone" value="{{ old('buyer_phone') }}" required>
                        @if($errors->any())
                            <p class="error" style="color:#c0392b;">{{ $errors->first() }}</p>
                        @endif
                        <button class="btn float-btn color-bg" type="submit">Pay with Paystack</button>
                    </form>
                </div>
            </div>
            <div class="col-md-5">
                <div class="box-widget fl-wrap">
                    <div class="box-widget-title fl-wrap">Parcel</div>
                    <div class="box-widget-content fl-wrap">
                        <h3>{{ $parcel->plot_number }}</h3>
                        <p>{{ $parcel->title }}</p>
                        <p>{{ $parcel->location_name }}</p>
                        <h3>{{ $parcel->currency }} {{ number_format((float) $parcel->price, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
