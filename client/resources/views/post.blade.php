@extends('layouts.app')
@section('seo')
    <title>nankov.mk | {{ $post->title->rendered }}</title>
    <meta name="description" content="post: {{ $post->title->rendered }}">
    <meta name="keywords" content="{{ implode(',', $post->tags_names) }},{{ $post->acf->crated_at }}">
    <link rel="canonical" href="https://nankov.mk" />
    <meta name="robots" content="all">
    <meta property="og:title" content="nankov.mk" />
    <meta property="og:description" content="{{ $post->title->rendered }}" />
    <meta property="og:url" content="https://nankov.mk" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="nankov.mk" />
    <meta property="og:image" content="{{ asset($post->acf->photo->url) }}" />
@endsection
@section('body')
    <nav id="gtco-header-navbar" class="navbar navbar-expand-lg py-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                nankov.mk
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-nav-header"
                aria-controls="navbar-nav-header" aria-expanded="false" aria-label="Toggle navigation">
                <span class="lnr lnr-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-nav-header">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Back to Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="jumbotron d-flex align-items-center" style="background-image: url({{ asset($post->acf->photo->url) }})">
        <div class="container text-center">
            <h1 class="display-1 mb-4 single-blog-title text-light font-weight-light"></h1>
        </div>
    </div>
    <section id="gtco-single-content" class="bg-white">
        <div class="container">
            <div class="section-content blog-content">
                <div class="row">
                    <div class="col-12 mt-4">
                        <h1 class="text-center">{{ $post->title->rendered }}</h1>
                        <p class="m-0 p-0 text-center"><span
                                class="badge badge-dark rounded-0 p-2 mr-1">{{ implode(',', $post->tags_names) }}</span>|<small
                                class="ml-1 text-muted" style="font-size: 1.4rem">Created
                                on: {{ $post->acf->crated_at }}</small></p>
                        <p class="text-justify pt-4 mt-4">
                            {!! $post->content->rendered !!}
                        </p>
                    </div>
                    <div class="col-12">
                        <div id="disqus_thread"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('components.footer')
@endsection
@section('js')
    <script>
        @if (env('APP_ENV') !== 'local')
            var disqus_config = function () {
            this.page.url = "{{ route('posts.slug', $post->slug) }}";
            this.page.identifier = "{{ $post->slug }}";
            }
        @endif
            (function() { // DON'T EDIT BELOW THIS LINE
                var d = document,
                    s = d.createElement('script');
                s.src = 'https://nankov-mk.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
            })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
            Disqus.</a></noscript>
@endsection
