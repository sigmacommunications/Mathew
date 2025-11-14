<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-duotone-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/sharp-light.css">

    <!-- ✅ jQuery (Compatible with FullCalendar v3) -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <!-- ✅ Moment.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <!-- ✅ FullCalendar v3.9.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

    <!-- ✅ Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <link rel="stylesheet" href="{{ asset('Frontend/assets/css/style.css') }}">
    <link rel="icon" type="image/x-icon" href="https://compasssolutionsllc.co/storage/logos/fav.png" />
    <title>@yield('title') | {{ $settings->site_name ?? 'Compass Solutions' }}</title>

    @stack('styles')

</head>

<body>
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


    <main>
        @yield('content') <!-- The main content will go here -->
    </main>




    <footer>
        <div class="container">
            <div class="row align-items-start">
                <div class="col-md-12">
                    <div class="footlogo">
                        @if ($settings && $settings->footer_logo)
                            <img class="navlogo" src="{{ asset('storage/logos/' . $settings->footer_logo) }}"
                                alt="">
                        @else
                            <img class="navlogo" src="../../Frontend/assets/images/logo.png" alt="">
                        @endif
                        <p>{{ $settings->description }}</p>
                    </div>
                </div>
                <div class="col-md-2 col-lg-4">
                    <ul class="footul">
                        <h6>Helpful Links</h6>
                        <li><a href="{{ route('about-us') }}">About Us</a></li>
                        <li><a href="{{ route('blog') }}">Blog</a></li>
                        <li><a href="{{ route('event') }}">Event</a></li>
                        <li><a href="{{ route('studymaterial') }}">Study Material</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-lg-4">
                    <ul class="footul">
                        <h6>Support</h6>
                        <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                        <li><a href="{{ route('privacypolicy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('termandcondition') }}">Terms & Conditions</a></li>
                    </ul>
                </div>
                @php
                    $num = $settings->contact_no ?? null;
                    $formatted = '(' . substr($num, 0, 3) . ') ' . substr($num, 3, 3) . ' ' . substr($num, 6);
                @endphp
                <div class="col-md-5 col-lg-4">
                    <ul class="footul">
                        <h6>Get in Touch</h6>
                        <li>Our Email<a class="blutxt"
                                href="{{ route('contact-us') }}/#contact">{{ $settings->email ?? null }}</a></li>
                        <li>Phone Number<a class="blutxt" href="#">{{ $formatted ?? null }}</a></li>
                        <li>Office Address<a class="blutxt" href="#">Compass Solutions LLC 9169 W State St#1366
                                Garden City, ID 83714</a></li>
                    </ul>
                </div>
            </div>
            <div class="cr">
                <div class="cr-div d-none d-md-block d-lg-block">
                    <a href="./privacy-policy">Privacy Policy</a>
                    <a href="./terms-and-conditions">Terms and Conditions</a>
                </div>
                <p>Fax: {{ $formatted }}</p>
                <p>{{ $settings->copyright ?? null }} © 2025. All Rights Reserved</p>
            </div>
        </div>
    </footer>
    @stack('scripts')
    <!-- Scripts -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            // Toastr configuration
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000"
            };

            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif

            // Owl Carousel Initialization
            $('.banner').owlCarousel({
                navText: [" ", " "],
                loop: true,
                margin: 10,
                nav: true,
                dots: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });

            $('.testi').owlCarousel({
                navText: ["<i class='fa-solid fa-chevron-left'></i>",
                    "<i class='fa-solid fa-chevron-right'></i>"
                ],
                loop: true,
                margin: 10,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    1000: {
                        items: 4
                    }
                }
            });
        });
    </script>

</html>
