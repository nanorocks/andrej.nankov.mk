<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .active{
            font-weight: 900 !important;
        }
        .shadow-custom-in{
            box-shadow: 2px 3px 27px 3px rgba(0,0,0,0.63) inset !important;
            -webkit-box-shadow: 2px 3px 27px 3px rgba(0,0,0,0.63) inset !important;;
            -moz-box-shadow: 2px 3px 27px 3px rgba(0,0,0,0.63) inset !important;
        }
        .section-title-devtools b{
            font-weight: 900;
        }
        .blog-desc .more-link{
            display: none !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
</head>
<body data-spy="scroll" data-target="#navbar-nav-header" class="static-layout">
<div class="boxed-page">
    @yield('body')
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
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