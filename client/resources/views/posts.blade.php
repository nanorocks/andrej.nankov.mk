@extends('layouts.app')
@section('seo')
    <title>nankov.mk | Blog area</title>
    <link rel="canonical" href="https://nankov.mk" />
    <meta name="robots" content="all">
    <meta property="og:title" content="nankov.mk/posts" />
    <meta property="og:url" content="https://nankov.mk" />
    <meta property="og:type" content="articles" />
    <meta property="og:site_name" content="nankov.mk" />
@endsection
@section('body')
    <nav id="gtco-header-navbar" class="navbar navbar-expand-lg py-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center bg-white rounded" href="{{ route('home') }}">
                nankov.mk
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-nav-header"
                aria-controls="navbar-nav-header" aria-expanded="false" aria-label="Toggle navigation">
                <span class="lnr lnr-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-nav-header">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item bg-white rounded">
                        <a class="nav-link" href="{{ route('home') }}">Back to Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="jumbotron d-flex align-items-center" style="background: url(https://wpadmin.nankov.mk/wp-content/uploads/2022/07/blogger.png)">
        <div class="container text-center">
            <h1 class="display-1 mb-4 single-blog-title text-dark bg-white rounded d-inline-block font-weight-light">Blogging area</h1>
        </div>
    </div>
    <section id="gtco-single-content" class="bg-white pt-5">
        <div class="container pt-5 mt-5">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-6 blog-holder">
                        <div class="posts">
                            <div class="m-2">
                                <div class="blog-item-wrapper">
                                    <div class="blog-item">
                                        <div class="blog-img">
                                            <a href="{{ route('posts.slug', $post->slug) }}">
                                                <img src="{{ $post->acf->photo->url ?? 'img/blog-1.jpg' }}"
                                                    alt="{{ $post->title->rendered }}"
                                                    title="{{ $post->title->rendered }}" />
                                            </a>
                                        </div>
                                        <div class="blog-text" style="min-height: 460px">
                                            <div class="blog-tag">
                                                <a href="{{ route('posts.slug', $post->slug) }}">
                                                    <h6>
                                                        <small>{{ implode(',', $post->categories_names) }}</small>
                                                    </h6>
                                                </a>
                                            </div>
                                            <div class="blog-title">
                                                <a href="{{ route('posts.slug', $post->slug) }}">
                                                    <h4>{{ $post->title->rendered }}</h4>
                                                </a>
                                            </div>
                                            <div class="blog-meta">
                                                <p class="blog-date">{{ $post->acf->crated_at }} /
                                                <p class="blog-comment ml-1"><a
                                                        href="{{ route('posts.slug', $post->slug) }}#disqus_thread">Post
                                                        a comment</a></p>
                                                </p>
                                            </div>
                                            <div class="blog-desc">
                                                <p>{!! $post->excerpt->rendered !!}</p>
                                            </div>
                                            <div class="blog-author">
                                                <p>by {{ $post->acf->creator }}</p>
                                            </div>
                                            <div class="blog-share-wrapper">
                                                <a class="blog-share"
                                                    href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.slug', $post->slug) }}">
                                                    <i class="bi bi-facebook"></i>
                                                </a>
                                                <a class="blog-share"
                                                    href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('posts.slug', $post->slug) }}">
                                                    <i class="bi bi-linkedin"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @include('components.footer')
@endsection
@section('js')
@endsection
