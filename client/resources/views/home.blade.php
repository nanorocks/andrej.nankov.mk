<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $profile['acf']['full_name'] }} | {{ $profile['acf']['address'] }}</title>
    <meta name="description" content="{{ $profile['title']['rendered'] }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="vendor/bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="vendor/select2/select2.min.css" />
    <link rel="stylesheet" href="vendor/owlcarousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendor/lightcase/lightcase.css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400|Work+Sans:300,400,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css" />
    <link href="https://file.myfontastic.com/7vRKgqrN3iFEnLHuqYhYuL/icons.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.min.css" />

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
    </style>
</head>
<body>
<body data-spy="scroll" data-target="#navbar-nav-header" class="static-layout">
    <div class="boxed-page">
        @include('components.header')
        @include('components.counter')
        @include('components.goals')
        @include('components.profile')
        @include('components.posts')
        @include('components.projects')
        @include('components.highlights')
        @include('components.devtools')
        @include('components.footer')
    </div>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
    <script src="vendor/bootstrap/popper.min.js"></script>
    <script src="vendor/bootstrap/bootstrap.min.js"></script>
    <script src="vendor/select2/select2.min.js "></script>
    <script src="vendor/owlcarousel/owl.carousel.min.js"></script>
    <script src="vendor/isotope/isotope.min.js"></script>
    <script src="vendor/lightcase/lightcase.js"></script>
    <script src="vendor/waypoints/waypoint.min.js"></script>
    <script src="vendor/countTo/jquery.countTo.js"></script>
    <script src="js/app.min.js "></script>
    <script src="js/snow.js"></script>
</body>
</html>
