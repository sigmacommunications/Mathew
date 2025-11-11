   <style>
       .user-avatar {
           width: 50px;
           /* Set the width of the user avatar */
           height: 50px;
           /* Set the height of the user avatar */
       }

       .user-name {
           text-decoration: none;
           /* Remove underline */
       }

       .dropdown-toggle .user-name {
           text-decoration: none;
           /* Remove underline */
           color: inherit;
           /* Maintain the color */
           font-weight: bold;
           /* Adjust the font weight as needed */
       }
   </style>
    <header class="header">
        <nav class="navbar-light navbar-expand-lg">
            <div class="container d-block">
                <div class="row align-items-center">
                    <div class="col-lg-1 col-md-6 col-6">
                        <a href="/">
                            @if ($settings && $settings->header_logo)
                                <img class="navlogo" src="{{ asset('storage/logos/' . $settings->header_logo) }}"
                                    alt="Company Logo">
                            @else
                                <img class="navlogo" src="../../Frontend/assets/images/logo.png" alt="">
                            @endif
                        </a>
                    </div>
                    <div class="col-md-9 d-none d-md-none d-lg-block px-1">
                        <div class="navbar">
                            <ul class="main-menu">
                                <li><a class="menu {{ request()->is('/') ? 'active' : '' }}"
                                        href="{{ route('home') }}">Home</a>
                                </li>
                                <li><a class="menu {{ request()->is('about-us') ? 'active' : '' }}"
                                        href="{{ route('about-us') }}">About Us</a></li>
                                <li><a class="menu {{ request()->is('blog') ? 'active' : '' }}"
                                        href="{{ route('blog') }}">Blog</a>
                                </li>
                                <li><a class="menu {{ request()->is('event') ? 'active' : '' }}"
                                        href="{{ route('event') }}">Event</a>
                                </li>
                                <li><a class="menu {{ request()->is('/StudyMaterial') ? 'active' : '' }}"
                                        href="{{ route('studymaterial') }}">Study
                                        Material</a>
                                </li>
                                <li><a class="menu {{ request()->is('contact') ? 'active' : '' }}"
                                        href="{{ route('contact-us') }}">Contact Us</a></li>
                                <li><a class="menu {{ request()->is('privacy-policy') ? 'active' : '' }}"
                                        href="{{ route('privacypolicy') }}">Privacy Policy</a></li>
                                <li><a class="menu {{ request()->is('terms-and-conditions') ? 'active' : '' }}"
                                        href="{{ route('termandcondition') }}">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 d-lg-none d-md-block d-block">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#navbarOffcanvas" aria-controls="navbarOffcanvas" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <i class="fa-solid fa-bars"></i>
                        </button>
                        <div class="offcanvas offcanvas-end bg-secondary secondary-1" id="navbarOffcanvas"
                            tabindex="-1" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <a class="navbar-brand" href="index.html"><img
                                        src="../../Frontend/assets/images/logo.png" alt="logo" class="logo"></a>
                                <button type="button" class="btn-close btn-close-black text-reset"
                                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li><a class="menu {{ request()->is('/') ? 'active' : '' }}"
                                        href="{{ route('home') }}">Home</a>
                                </li>
                                <li><a class="menu {{ request()->is('about-us') ? 'active' : '' }}"
                                        href="{{ route('about-us') }}">About Us</a></li>
                                <li><a class="menu {{ request()->is('blog') ? 'active' : '' }}"
                                        href="{{ route('blog') }}">Blog</a>
                                </li>
                                <li><a class="menu {{ request()->is('event') ? 'active' : '' }}"
                                        href="{{ route('event') }}">Event</a>
                                </li>
                                <li><a class="menu {{ request()->is('/StudyMaterial') ? 'active' : '' }}"
                                        href="{{ route('studymaterial') }}">Study
                                        Material</a>
                                </li>
                                <li><a class="menu {{ request()->is('contact') ? 'active' : '' }}"
                                        href="{{ route('contact-us') }}">Contact Us</a></li>
                                <li><a class="menu {{ request()->is('privacy-policy') ? 'active' : '' }}"
                                        href="{{ route('privacypolicy') }}">Privacy Policy</a></li>
                                <li><a class="menu {{ request()->is('terms-and-conditions') ? 'active' : '' }}"
                                        href="{{ route('termandcondition') }}">Terms & Conditions</a></li>
									@auth
                            <a class="loginbtn" href="{{ route('dashboard.redirect') }}">Dashboard</a>
                        @else
                            <a class="loginbtn" href="{{ route('login') }}">Login/Register</a>
                        @endauth
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 d-none d-md-none d-lg-block px-1">
                        @auth
                            <a class="loginbtn" href="{{ route('dashboard.redirect') }}">Dashboard</a>
                        @else
                            <a class="loginbtn" href="{{ route('login') }}">Login/Register</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
    </header>