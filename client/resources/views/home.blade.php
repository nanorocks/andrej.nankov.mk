@extends('layouts.base')
@section('seo')
    <title>nankov.mk | {{ $profile->title->rendered }}</title>
    <meta name="description" content="Personal website of Andrej Nankov about life, blogging, hobbies, IT-carrier">
    <meta name="keywords"
        content="software, profile, developer, engineer, posts, articles, blogging, projects, work, experience">
    <link rel="canonical" href="https://nankov.mk" />
    <meta name="robots" content="all">
    <meta property="og:title" content="nankov.mk" />
    <meta property="og:description" content="Personal website of Andrej Nankov" />
    <meta property="og:url" content="https://nankov.mk" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="nankov.mk" />
    <meta property="og:image" content="https://avatars.githubusercontent.com/u/18250654?v=4" />
    <style>
        .bg-dark-custom {
            background: rgb(31 41 55) !important;
        }

        .bg-dark-custom-sec {
            background: rgb(17 24 39) !important;
        }

        .grid-item-wrapper-dark:hover {
            color: white !important;
        }

        .text-grey {
            color: rgb(143 148 156) !important;
        }

        .jumbotron-dark::before {
            background-color: #343a40cf !important;
        }
    </style>
@endsection
@section('body')
    @if ($darkMode)
        @include('components.dark.header')
        @include('components.dark.profile')
        @include('components.dark.quotes')
        @include('components.dark.goals')
        @include('components.dark.posts')
        @include('components.dark.projects')
        @include('components.dark.highlights')
        @include('components.dark.devtools')
        @include('components.dark.fun')
        @include('components.dark.footer')
    @else
        @include('components.header')
        @include('components.profile')
        @include('components.quotes')
        @include('components.goals')
        @include('components.posts')
        @include('components.projects')
        @include('components.highlights')
        @include('components.devtools')
        @include('components.fun')
        @include('components.footer')
    @endif
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.posts').slick({
                dots: true,
                arrows: false,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: true
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                            initialSlide: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            })
        })
    </script>
@endsection
