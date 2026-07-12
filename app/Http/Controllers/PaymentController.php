<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ArkeselSmsService;
use App\Services\PaystackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function callback(Request $request, PaystackService $paystack, ArkeselSmsService $sms): View|RedirectResponse
    {
        $reference = (string) $request->query('reference');
        $order = Order::where('paystack_reference', $reference)->firstOrFail();
        $result = $paystack->verify($reference);

        if (data_get($result, 'data.status') === 'success') {
            $this->markPaid($order, $result, $sms);
        }

        return view('payments.callback', compact('order'));
    }

    public function webhook(Request $request, PaystackService $paystack, ArkeselSmsService $sms): JsonResponse
    {
        if (! $paystack->verifyWebhookSignature($request->getContent(), $request->header('x-paystack-signature'))) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        if ($request->input('event') === 'charge.success') {
            $reference = (string) $request->input('data.reference');
            $order = Order::where('paystack_reference', $reference)->first();

            if ($order !== null) {
                $this->markPaid($order, $request->all(), $sms);
            }
        }

        return response()->json(['message' => 'ok']);
    }

    private function markPaid(Order $order, array $payload, ArkeselSmsService $sms): void
    {
        if ($order->status === 'paid') {
            return;
        }

        $order->update([
            'status' => 'paid',
            'paid_at' => Carbon::now(),
            'payment_payload' => $payload,
        ]);

        $order->parcel->update(['status' => 'reserved']);

        $sms->send(
            $order->buyer_phone,
            "Payment received for {$order->parcel->plot_number}. Your parcel reservation is confirmed."
        );
    }
}
