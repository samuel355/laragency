@extends('layouts.admin')

@section('title', 'Admin FAQ - SOMA PROPERTIES')
@section('admin-title', 'FAQs')

@section('admin-content')
<div class="dashboard-title">
    <div class="dashboard-title-item"><span>FAQ</span></div>
    <a class="btn float-btn color-bg" href="{{ route('admin.faqs.create') }}" style="position: absolute; right: 30px; top: 50%; transform: translateY(-50%);">Add FAQ</a>
</div>
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
@endsection
