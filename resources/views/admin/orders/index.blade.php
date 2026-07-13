@extends('layouts.admin')

@section('title', 'Payments - SOMA PROPERTIES')
@section('admin-title', 'Payments')

@section('admin-content')
<div class="dashboard-title">
    <div class="dashboard-title-item">
        <span>Payments</span>
        <strong>{{ $orders->count() }}</strong>
    </div>
</div>

<div class="app-stat-grid" style="margin-bottom: 20px;">
    <div class="app-stat"><span>Collected</span><strong>GHS {{ number_format($totalPaid) }}</strong></div>
    <div class="app-stat"><span>Paid</span><strong>{{ $paidCount }}</strong></div>
    <div class="app-stat"><span>Pending</span><strong>{{ $pendingCount }}</strong></div>
</div>

<div class="dasboard-widget-box fl-wrap">
    <table class="app-table">
        <thead>
            <tr>
                <th>Buyer</th>
                <th>Parcel</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Reference</th>
                <th>Paid At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>
                        {{ $order->buyer_name }}<br>
                        <small>{{ $order->buyer_email }}</small>
                    </td>
                    <td>{{ $order->parcel?->title ?? '—' }}</td>
                    <td>{{ $order->currency }} {{ number_format((float) $order->amount, 2) }}</td>
                    <td>{{ ucfirst($order->status) }}</td>
                    <td>{{ $order->paystack_reference }}</td>
                    <td>{{ $order->paid_at?->format('d M Y, g:i A') ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="6">No payments yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
