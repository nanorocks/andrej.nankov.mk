<!DOCTYPE html>
<html lang="en">

<head>
    @yield('seo')
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/owlcarousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/lightcase/lightcase.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400|Work+Sans:300,400,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css" />
    <link href="https://file.myfontastic.com/7vRKgqrN3iFEnLHuqYhYuL/icons.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.min.css') }}" />
    <style>
        .active {
            font-weight: 900 !important;
        }

        .shadow-custom-in {
            box-shadow: 2px 3px 27px 3px rgba(0, 0, 0, 0.63) inset !important;
            -webkit-box-shadow: 2px 3px 27px 3px rgba(0, 0, 0, 0.63) inset !important;
            ;
            -moz-box-shadow: 2px 3px 27px 3px rgba(0, 0, 0, 0.63) inset !important;
        }

        .section-title-devtools b {
            font-weight: 900;
        }

        .blog-desc .more-link {
            display: none !important;
        }

        #version div:hover>ul {
            visibility: visible;
        }

        .bg-dark-custom {
            background: rgb(31 41 55) !important;
        }

        .bg-dark-custom-sec {
            background: rgb(17 24 39) !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <!-- Hotjar Tracking Code for https://nankov.mk -->
    <script>
        (function(h, o, t, j, a, r) {
            h.hj = h.hj || function() {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {
                hjid: 2738086,
                hjsv: 6
            };
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3DK991WXTL"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-3DK991WXTL');
    </script>
</head>

<body data-spy="scroll" data-target="#navbar-nav-header" class="static-layout">

    <div class="boxed-page">
        @yield('body')
    </div>
    <ul id="version"
        style="display:inline-flex; position: relative; bottom: 30px; left: 15px; font-size: x-small; list-style-type: none; z-index: 1000; margin: 0; padding: 5px; background-color: #c94ca5; color: white; border-radius: 5px; box-shadow: 0px 0px 5px rgba(0,0,0,0.2);">
        <li style="display: inline; margin-right: 10px;">PHP: {{ phpversion() }}</li>
        <li style="display: inline;">Laravel: {{ app()->version() }}</li>
    </ul>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
    <script src="{{ asset('vendor/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/isotope/isotope.min.js') }}"></script>
    <script src="{{ asset('vendor/lightcase/lightcase.js') }}"></script>
    <script src="{{ asset('vendor/waypoints/waypoint.min.js') }}"></script>
    <script src="{{ asset('vendor/countTo/jquery.countTo.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    @yield('js')
</body>

</html>
