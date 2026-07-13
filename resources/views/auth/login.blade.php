@extends('layouts.app')

@section('title', 'Admin Login - SOMA PROPERTIES')

@push('styles')
<style>
    /* Adapts the template's login/register modal into a static page: the base
       .main-register-container is a JS-toggled fixed overlay (display:none by
       default); .login-page beats it on specificity at every breakpoint the
       template already defines, so mobile stays responsive instead of relying
       on a fixed inline style. */
    .login-page.main-register-container {
        display: flex;
        position: relative;
        width: 100%;
        height: auto;
        padding: 160px 15px 80px;
        background: var(--app-blue-050);
    }
    .login-page .main-register {
        padding-top: 46px;
    }
    /* .main-register_box has no explicit width, so inside a flex container its
       width is intrinsic/ambiguous — .main-register-holder's `width: min(100% -
       25px, 950px)` then resolves against that ambiguous size instead of the
       page, collapsing the whole card at intermediate viewport widths. Pin it. */
    .login-page .main-register_box {
        width: 100%;
    }
    .login-page .mr_title h4 i {
        color: rgba(255, 255, 255, 0.75);
        font-size: 0.7em;
        margin-right: 10px;
    }
    @media (max-width: 991px) {
        .login-page.main-register-container {
            padding: 120px 15px 50px;
        }
    }
    @media (max-width: 480px) {
        .login-page.main-register-container {
            padding: 108px 12px 40px;
        }
    }
</style>
@endpush

@section('content')
<div class="main-register-container login-page">
    <div class="main-register_box">
        <div class="main-register-holder">
            <div class="main-register-wrap vis_mr">
                <div class="main-register_bg">
                    <div class="mr_title">
                        <h4><i class="fa-light fa-lock-keyhole"></i>Welcome to SOMA</h4>
                        <h5>Property operations</h5>
                    </div>
                    <div class="main-register_contacts-wrap">
                        <h4>Have a question?</h4>
                        <a href="{{ route('contact') }}">Get in Touch</a>
                    </div>
                    <div class="main-register_bg-dec"></div>
                </div>
                <div class="main-register fl-wrap">
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
