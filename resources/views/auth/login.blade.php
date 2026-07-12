@extends('layouts.app')

@section('title', 'Admin Login - BlueGate Realty')

@section('content')
<div class="main-register-container" style="position: relative; display: flex; width: 100%; height: auto; padding: 150px 15px 70px; background: var(--app-blue-050);">
    <div class="main-register_box">
        <div class="main-register-holder">
            <div class="main-register-wrap vis_mr">
                <div class="main-register_bg">
                    <div class="mr_title">
                        <h4>Welcome to BlueGate</h4>
                        <h5>Realty operations</h5>
                    </div>
                    <div class="main-register_contacts-wrap">
                        <h4>Have a question?</h4>
                        <a href="{{ route('contact') }}">Get in Touch</a>
                    </div>
                    <div class="main-register_bg-dec"></div>
                </div>
                <div class="main-register fl-wrap" style="padding-top: 44px;">
                    <div class="custom-form">
                        @if($errors->any())
                            <p class="error" style="color:#c0392b;">{{ $errors->first() }}</p>
                        @endif
                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf
                            <div class="cs-intputwrap">
                                <i class="fa-light fa-envelope"></i>
                                <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" autocomplete="email" required autofocus>
                            </div>
                            <div class="cs-intputwrap pass-input-wrap">
                                <i class="fa-light fa-lock"></i>
                                <input type="password" name="password" class="pass-input" placeholder="Password" autocomplete="current-password" required>
                                <div class="view-pass"></div>
                            </div>
                            <div class="filter-tags">
                                <input id="remember" type="checkbox" name="remember" value="1">
                                <label for="remember">Remember me</label>
                            </div>
                            <div class="clearfix"></div>
                            <button type="submit" class="commentssubmit">Log In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
