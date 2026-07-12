<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BlueGate Realty')</title>
    <link rel="stylesheet" href="{{ asset('light/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('light/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('light/css/app-blue.css') }}">
    @stack('styles')
</head>
<body>
<!--loader-->
<div class="loader-wrap">
    <div class="loader-inner">
        <svg>
            <defs>
                <filter id="goo">
                    <fegaussianblur in="SourceGraphic" stdDeviation="2" result="blur"></fegaussianblur>
                    <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 5 -2" result="gooey"></fecolormatrix>
                    <fecomposite in="SourceGraphic" in2="gooey" operator="atop"></fecomposite>
                </filter>
            </defs>
        </svg>
    </div>
</div>
<!--loader end-->
<!--  main   -->
<div id="main">
    <!--header-->
    <header class="main-header">
        <div class="container">
            <div class="header-inner">
                <a href="{{ route('home') }}" class="logo-holder">BlueGate <span>Realty</span></a>
                <!--  navigation -->
                <div class="nav-holder main-menu">
                    <nav>
                        <ul class="no-list-style">
                            <li><a href="{{ route('home') }}" @class(['act-link' => request()->routeIs('home')])>Home</a></li>
                            <li><a href="{{ route('parcels.index') }}" @class(['act-link' => request()->routeIs('parcels.*')])>Buy Land</a></li>
                            <li><a href="{{ route('services') }}" @class(['act-link' => request()->routeIs('services*')])>Services</a></li>
                            <li>
                                <a href="{{ route('about') }}">Company <i class="fa-solid fa-caret-down"></i></a>
                                <ul>
                                    <li><a href="{{ route('about') }}">About</a></li>
                                    <li><a href="{{ route('team.index') }}">Our Team</a></li>
                                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('blog.index') }}">Resources <i class="fa-solid fa-caret-down"></i></a>
                                <ul>
                                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                                    <li><a href="{{ route('mortgage.create') }}">Mortgage Inquiry</a></li>
                                    <li><a href="{{ route('site-visits.create') }}">Book a Site Visit</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- navigation  end -->
                <!-- nav-button-wrap-->
                <div class="nav-button-wrap">
                    <div class="nav-button"><span></span><span></span><span></span></div>
                </div>
                <!-- nav-button-wrap end-->
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="show-reg-form">
                        @csrf
                        <button type="submit" style="all: unset; display: flex; align-items: center; gap: 6px; cursor: pointer;"><i class="fa-thin fa-arrow-right-from-bracket"></i><span>Logout</span></button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="show-reg-form"><i class="fa-thin fa-user"></i><span>Sign In</span></a>
                @endauth
                <a href="{{ route('listings.index') }}" class="header-btn"><span>Explore Properties</span></a>
            </div>
        </div>
    </header>
    <!--header-end-->
    <!--warpper-->
    <div class="wrapper">
        <div class="content">
            @yield('content')
        </div>
        <!--content  end-->
        <!--main-footer-->
        <div class="height-emulator"></div>
        <footer class="main-footer">
            <div class="container">
                <div class="footer-inner">
                    <div class="row">
                        <!-- footer-widget -->
                        <div class="col-lg-4">
                            <div class="footer-widget">
                                <div class="footer-widget-title">BlueGate Realty</div>
                                <div class="footer-widget-content">
                                    <p>Corporate-grade property sales, land acquisition, and investment advisory across Greater Accra, Ghana.</p>
                                    <div class="api-links-wrap">
                                        <a href="https://wa.me/233300000000" target="_blank" rel="noopener" class="footer-widget-content-link"><span>WhatsApp Us</span><i class="fa-brands fa-whatsapp"></i></a>
                                        <a href="tel:+233300000000" class="footer-widget-content-link"><span>Call Us</span><i class="fa-solid fa-phone"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- footer-widget  end-->
                        <!-- footer-widget -->
                        <div class="col-lg-2">
                            <div class="footer-widget">
                                <div class="footer-widget-title">Helpful links</div>
                                <div class="footer-widget-content">
                                    <div class="footer-list footer-box">
                                        <ul>
                                            <li><a href="{{ route('listings.index') }}">Property Listings</a></li>
                                            <li><a href="{{ route('listings.index', ['is_investment' => 1]) }}">Investment Opportunities</a></li>
                                            <li><a href="{{ route('parcels.index') }}">Land Parcels</a></li>
                                            <li><a href="{{ route('blog.index') }}">Our latest News</a></li>
                                            <li><a href="{{ route('faq') }}">FAQ</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- footer-widget  end-->
                        <!-- footer-widget -->
                        <div class="col-lg-2">
                            <div class="footer-widget">
                                <div class="footer-widget-title">Our Contacts</div>
                                <div class="footer-widget-content">
                                    <div class="footer-list footer-box">
                                        <ul class="footer-contacts">
                                            <li><span>Mail :</span><a href="mailto:hello@bluegaterealty.test" target="_blank">hello@bluegaterealty.test</a></li>
                                            <li><span>Adress :</span><a href="{{ route('contact') }}">East Legon, Accra</a></li>
                                            <li><span>Phone :</span><a href="tel:+233300000000">+233 30 000 0000</a></li>
                                        </ul>
                                        <a href="{{ route('contact') }}" class="footer-widget-content-link"><span>Get in Touch</span><i class="fa-solid fa-caret-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- footer-widget  end-->
                        <!-- footer-widget -->
                        <div class="col-lg-4">
                            <div class="footer-widget">
                                <div class="footer-widget-title">Get Started</div>
                                <div class="footer-widget-content">
                                    <p>Book a site visit, run a mortgage inquiry, or talk to an advisor about a property.</p>
                                    <div class="footer-list footer-box">
                                        <ul>
                                            <li><a href="{{ route('site-visits.create') }}">Book a site visit</a></li>
                                            <li><a href="{{ route('mortgage.create') }}">Mortgage inquiry</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- footer-widget  end-->
                    </div>
                    <!-- footer-widget-wrap end-->
                </div>
                <div class="footer-bottom">
                    <a href="{{ route('home') }}" class="footer-home_link"><i class="fa-regular fa-house"></i></a>
                    <div class="copyright">
                        <span>&#169;BlueGate Realty {{ now()->year }}</span> . All rights reserved.
                    </div>
                    <div class="footer-social">
                        <span class="footer-social-title">Follow Us</span>
                        <div class="footer-social-wrap">
                            <a href="#" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--main-footer end-->
    </div>
    <!--warpper end-->
</div>

<script src="{{ asset('light/js/jquery.min.js') }}"></script>
<script src="{{ asset('light/js/plugins.js') }}"></script>
<script src="{{ asset('light/js/scripts.js') }}"></script>
@stack('scripts')
</body>
</html>
