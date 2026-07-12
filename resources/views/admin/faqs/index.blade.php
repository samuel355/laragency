@extends('layouts.app')

@section('title', 'Admin FAQ - BlueGate Realty')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="dashboard-title fl-wrap">
            <h3>FAQ</h3>
            <a class="btn float-btn color-bg" href="{{ route('admin.faqs.create') }}">Add FAQ</a>
        </div>
        @if(session('status'))<p>{{ session('status') }}</p>@endif
        <div class="dasboard-widget-box fl-wrap">
            <table class="app-table">
                <thead><tr><th>Question</th><th>Category</th><th>Order</th><th>Active</th><th></th></tr></thead>
                <tbody>
                    @foreach($faqs as $faq)
                        <tr>
                            <td>{{ $faq->question }}</td>
                            <td>{{ $faq->category }}</td>
                            <td>{{ $faq->sort_order }}</td>
                            <td>{{ $faq->is_active ? 'Yes' : 'No' }}</td>
                            <td><a href="{{ route('admin.faqs.edit', $faq) }}">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
