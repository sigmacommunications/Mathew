<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/david-fav.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
        href="/css/app-wa-462d1fe84b879d730fe2180b0e0354e0.css?vsn=d">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css">
	    <link rel="stylesheet" href="{{ asset('Frontend/assets/css/style.css') }}">
	<link rel="icon" type="image/x-icon" href="https://compasssolutionsllc.co/storage/logos/fav.png" />
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-K5NT4YLTBX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-K5NT4YLTBX');
    </script>
    <title>Compass Solutions</title>
</head>

<body>
    <header class="header">
        @include('layouts.header')
    </header>
    @yield('content')
    @include('layouts.footer')
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the current URL path
        var url = window.location.pathname;

        // Get the filename from the URL path
        var filename = url.substring(url.lastIndexOf('/') + 1);

        // Remove the extension if present
        filename = filename.replace(/\.[^/.]+$/, "");

        // Get the corresponding navigation link by its ID and add 'active' class
        var link = document.getElementById(filename + "-link");
        if (link) {
            link.classList.add("active");
        }

        // If it's the home page, also activate the 'home-link'
        if (filename === "index" || filename === "") {
            var homeLink = document.getElementById("home-link");
            if (homeLink) {
                homeLink.classList.add("active");
            }
        }
    });
</script>

<script>
    $(function() {
        $('.popup-youtube').magnificPopup({
            disableOn: 700,
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    });
</script>
@yield('scripts')



</html>
