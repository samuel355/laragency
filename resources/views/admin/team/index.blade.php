@extends('layouts.app')

@section('title', 'Admin Team - BlueGate Realty')

@section('content')
<section class="gray-bg small-padding app-screen" style="padding-top: 130px;">
    <div class="container">
        <div class="dashboard-title fl-wrap">
            <h3>Team Members</h3>
            <a class="btn float-btn color-bg" href="{{ route('admin.team.create') }}">Add Member</a>
        </div>
        @if(session('status'))<p>{{ session('status') }}</p>@endif
        <div class="dasboard-widget-box fl-wrap">
            <table class="app-table">
                <thead><tr><th>Name</th><th>Role</th><th>Email</th><th>Order</th><th>Active</th><th></th></tr></thead>
                <tbody>
                    @foreach($members as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->role }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->sort_order }}</td>
                            <td>{{ $member->is_active ? 'Yes' : 'No' }}</td>
                            <td><a href="{{ route('admin.team.edit', $member) }}">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
