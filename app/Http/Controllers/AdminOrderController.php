<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('parcel')->latest()->get();

        return view('admin.orders.index', [
            'orders' => $orders,
            'totalPaid' => $orders->where('status', 'paid')->sum('amount'),
            'paidCount' => $orders->where('status', 'paid')->count(),
            'pendingCount' => $orders->where('status', 'pending')->count(),
        ]);
    }
}
