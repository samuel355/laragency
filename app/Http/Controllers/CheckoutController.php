<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Parcel;
use App\Services\PaystackService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(Parcel $parcel): View
    {
        return view('parcels.checkout', compact('parcel'));
    }

    public function store(Request $request, Parcel $parcel, PaystackService $paystack): RedirectResponse
    {
        abort_if($parcel->status !== 'available', 409, 'This parcel is not available.');

        $data = $request->validate([
            'buyer_name' => ['required', 'string', 'max:120'],
            'buyer_email' => ['required', 'email', 'max:160'],
            'buyer_phone' => ['required', 'string', 'max:40'],
        ]);

        $order = Order::create([
            ...$data,
            'parcel_id' => $parcel->id,
            'amount' => $parcel->price,
            'currency' => $parcel->currency,
            'paystack_reference' => $paystack->reference(),
        ]);

        $result = $paystack->initialize([
            'email' => $order->buyer_email,
            'amount' => (int) round(((float) $order->amount) * 100),
            'currency' => $order->currency,
            'reference' => $order->paystack_reference,
            'callback_url' => URL::route('payments.callback'),
            'metadata' => [
                'order_id' => $order->id,
                'parcel_id' => $parcel->id,
                'plot_number' => $parcel->plot_number,
                'buyer_phone' => $order->buyer_phone,
            ],
        ]);

        $order->update([
            'paystack_access_code' => data_get($result, 'data.access_code'),
            'payment_payload' => $result,
        ]);

        return redirect()->away(data_get($result, 'data.authorization_url'));
    }
}
