@extends('layouts.app')
@section('title')
nankov.mk | {{ $profile['title']['rendered'] }}
@endsection
@section('description')
{{ $profile['acf']['full_name'] }} | {{ $profile['acf']['address'] }}
@endsection
@section('body')
        @include('components.header')
        @include('components.counter')
        @include('components.goals')
        @include('components.profile')
        @include('components.posts')
        @include('components.projects')
        @include('components.highlights')
        @include('components.devtools')
        @include('components.footer')
@endsection
@section('js')
    <script id="dsq-count-scr" src="//nankov-mk.disqus.com/count.js" async></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.posts').slick({
                dots: true,
                arrows: false,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                    {
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
