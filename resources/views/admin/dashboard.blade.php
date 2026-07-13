@extends('layouts.admin')

@section('title', 'Admin Dashboard - SOMA PROPERTIES')
@section('admin-title', 'Dashboard')

@push('scripts')
<script src="{{ asset('light/js/charts.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var config = {
            type: 'bar',
            data: {
                labels: @json($chartWeeks->pluck('label')),
                datasets: [
                    {
                        label: 'Inquiries',
                        fill: true,
                        animation: false,
                        backgroundColor: '#1f6feb',
                        borderColor: '#1f6feb',
                        data: @json($chartWeeks->pluck('inquiries')),
                    },
                    {
                        label: 'Bookings',
                        fill: true,
                        animation: false,
                        backgroundColor: '#94bdfb',
                        borderColor: '#94bdfb',
                        data: @json($chartWeeks->pluck('bookings')),
                    },
                ],
            },
            options: {
                legend: { display: false },
                hover: {
                    onHover: function (e) {
                        var point = this.getElementAtEvent(e);
                        e.target.style.cursor = point.length ? 'pointer' : 'default';
                    },
                },
                scales: {
                    yAxes: [{
                        ticks: { fontColor: 'rgba(255,255,255,0.8)', fontStyle: 'bold', beginAtZero: true, padding: 20, precision: 0 },
                        gridLines: { display: true, zeroLineColor: 'rgba(255,255,255,0.2)' },
                    }],
                    xAxes: [{
                        gridLines: { display: true, zeroLineColor: 'rgba(255,255,255,0.2)' },
                        ticks: { padding: 20, fontColor: 'rgba(255,255,255,0.8)', fontStyle: 'bold' },
                    }],
                },
                tooltips: { backgroundColor: '#292929', titleMarginBottom: 10, footerMarginTop: 6, xPadding: 22, yPadding: 12 },
            },
        };

        var ctx = document.getElementById('canvas-chart');
        var myLegendContainer = document.getElementById('myChartLegend');
        if (ctx && window.Chart) {
            var myChart = new Chart(ctx, config);
            myLegendContainer.innerHTML = myChart.generateLegend();
            var legendItems = myLegendContainer.getElementsByTagName('li');
            for (var i = 0; i < legendItems.length; i += 1) {
                legendItems[i].addEventListener('click', legendClickCallback, false);
            }
        }
    });
</script>
@endpush

@section('admin-content')
<div class="dashboard-title">
    <div class="dashboard-title-item">
        <span>Overview</span>
    </div>
    <div class="tfp-det-container">
        <div class="db-date"><i class="fa-regular fa-calendar"></i><strong></strong></div>
    </div>
</div>

<div class="db-container">
    <div class="db-single-facts-container">
        <div class="row">
            <div class="col-lg-4">
                <div class="db-single-facts-wrap">
                    <div class="db-single-facts">
                        <i class="fa-light fa-house-building"></i>
                        <h6>Total Listings</h6>
                        <div class="num">{{ number_format($listingCount) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="db-single-facts-wrap">
                    <div class="db-single-facts">
                        <i class="fa-light fa-circle-check"></i>
                        <h6>Published Listings</h6>
                        <div class="num">{{ number_format($publishedListingCount) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="db-single-facts-wrap">
                    <div class="db-single-facts">
                        <i class="fa-light fa-map"></i>
                        <h6>Land Parcels</h6>
                        <div class="num">{{ number_format($parcelCount) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-4">
                <div class="db-single-facts-wrap">
                    <div class="db-single-facts">
                        <i class="fa-light fa-inbox"></i>
                        <h6>New Leads (30 days)</h6>
                        <div class="num">{{ number_format($newLeadsCount30d) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="db-single-facts-wrap">
                    <div class="db-single-facts">
                        <i class="fa-light fa-sack-dollar"></i>
                        <h6>Revenue Collected</h6>
                        <div class="num" style="font-size: 2.2em;">GHS {{ number_format($revenue) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="db-single-facts-wrap">
                    <div class="db-single-facts">
                        <i class="fa-light fa-users"></i>
                        <h6>Team Members</h6>
                        <div class="num">{{ number_format($teamCount) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dasboard-content">
        <div class="chart-wrap">
            <div class="chart-header">
                <div class="dashboard-widget-title">Leads over the last 8 weeks</div>
                <div id="myChartLegend"></div>
            </div>
            <canvas id="canvas-chart"></canvas>
        </div>
    </div>

    <div class="dasboard-content">
        <div class="row">
            <div class="col-lg-8">
                <div class="dashboard-widget-title-single">Recent Activity</div>
                <div class="dashboard-list-box">
                    @forelse($activity as $item)
                        <div class="dashboard-list">
                            <div class="dashboard-message">
                                <div class="main-dashboard-message-icon">
                                    <i class="fa-regular {{ $item['icon'] }}"></i>
                                </div>
                                <div class="main-dashboard-message-text">
                                    <p><a href="{{ $item['url'] }}">{{ $item['text'] }}</a></p>
                                </div>
                                <div class="main-dashboard-message-time">
                                    <i class="fa-regular fa-calendar"></i> {{ $item['created_at']->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="dashboard-list">
                            <div class="dashboard-message">
                                <div class="main-dashboard-message-text"><p>No activity yet.</p></div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-4">
                <div class="dashboard-widget-title-single">Manage Site</div>
                <div class="dashboard-list-box">
                    <div class="dashboard-list" style="padding: 20px;">
                        <ul style="margin: 0; padding: 0; list-style: none; display: grid; gap: 10px;">
                            <li><a href="{{ route('admin.listings.create') }}" class="hum_log-out_btn" style="margin-top: 0;"><i class="fa-light fa-plus"></i> Add Listing</a></li>
                            <li><a href="{{ route('admin.requests.index') }}" class="hum_log-out_btn" style="margin-top: 0;"><i class="fa-light fa-inbox"></i> View Requests</a></li>
                            <li><a href="{{ route('admin.orders.index') }}" class="hum_log-out_btn" style="margin-top: 0;"><i class="fa-light fa-sack-dollar"></i> View Payments</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
