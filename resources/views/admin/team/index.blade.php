@extends('layouts.admin')

@section('title', 'Admin Team - SOMA PROPERTIES')
@section('admin-title', 'Team')

@section('admin-content')
<div class="dashboard-title">
    <div class="dashboard-title-item"><span>Team Members</span></div>
    <a class="btn float-btn color-bg" href="{{ route('admin.team.create') }}" style="position: absolute; right: 30px; top: 50%; transform: translateY(-50%);">Add Member</a>
</div>
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
@endsection
