@extends('layouts.app')

@section('title', 'Payment Status - Rentstate')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="list-single-main-item fl-wrap">
            <div class="list-single-main-item-title">
                <h3>Payment {{ ucfirst($order->status) }}</h3>
            </div>
            <p>Reference: {{ $order->paystack_reference }}</p>
            <p>Parcel: {{ $order->parcel->plot_number }} - {{ $order->parcel->title }}</p>
            <p>Amount: {{ $order->currency }} {{ number_format((float) $order->amount, 2) }}</p>
            <a class="btn float-btn color-bg" href="{{ route('parcels.index') }}">Back to parcels</a>
        </div>
    </div>
</section>
@endsection
