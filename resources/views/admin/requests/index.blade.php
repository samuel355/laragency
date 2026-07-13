@extends('layouts.admin')

@section('title', 'Requests - SOMA PROPERTIES')
@section('admin-title', 'Requests')

@section('admin-content')
<div class="dashboard-title">
    <div class="dashboard-title-item">
        <span>Requests</span>
        <strong>{{ $requests->count() }}</strong>
    </div>
</div>

<div class="app-stat-grid" style="margin-bottom: 20px;">
    <div class="app-stat"><span>Inquiries</span><strong>{{ $counts['inquiry'] }}</strong></div>
    <div class="app-stat"><span>Site Visits</span><strong>{{ $counts['site_visit'] }}</strong></div>
    <div class="app-stat"><span>Mortgage Applications</span><strong>{{ $counts['mortgage'] }}</strong></div>
</div>

<div class="row">
    @forelse($requests as $item)
        <div class="col-lg-6">
            <div class="bookings-item">
                <div class="bookings-item-header">
                    @if($item['image'])
                        <img src="{{ asset($item['image']) }}" alt="">
                    @endif
                    <h4>
                        {{ $item['heading'] }}
                        @if($item['context'])
                            @if($item['context_url'])
                                &mdash; <a href="{{ $item['context_url'] }}" target="_blank">{{ $item['context'] }}</a>
                            @else
                                &mdash; {{ $item['context'] }}
                            @endif
                        @endif
                    </h4>
                    <span class="new-bookmark">{{ ucfirst(str_replace('_', ' ', $item['status'])) }}</span>
                </div>
                <div class="bookings-item-content">
                    <ul>
                        <li>Name: <span>{{ $item['name'] }}</span></li>
                        <li>Email: <span>{{ $item['email'] }}</span></li>
                        <li>Phone: <span>{{ $item['phone'] ?? '—' }}</span></li>
                        <li>Type: <span>{{ ucfirst(str_replace('_', ' ', $item['type'])) }}</span></li>
                    </ul>
                </div>
                <div class="bookings-item-footer">
                    <span class="message-date"><i class="fa-regular fa-calendar"></i> {{ $item['created_at']->format('d M Y') }}</span>
                    <ul>
                        @if($item['phone'])
                            <li>
                                <a href="tel:{{ $item['phone'] }}" class="tolt" data-microtip-position="left" data-tooltip="Call">
                                    <i class="fa-regular fa-phone"></i>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="mailto:{{ $item['email'] }}" class="tolt" data-microtip-position="left" data-tooltip="Email">
                                <i class="fa-regular fa-envelope"></i>
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('admin.requests.destroy', [$item['type'], $item['id']]) }}" onsubmit="return confirm('Remove this request?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="tolt" data-microtip-position="left" data-tooltip="Delete" style="all: unset; cursor: pointer;">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @empty
        <div class="col-lg-12">
            <div class="dashboard-list">
                <div class="dashboard-message">
                    <div class="main-dashboard-message-text"><p>No requests yet.</p></div>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
