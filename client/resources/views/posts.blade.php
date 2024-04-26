@extends('layouts.base')
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
    @include('components.dark.nav')
    <div class="jumbotron d-flex align-items-center"
        style="background: url(https://wpadmin.nankov.mk/wp-content/uploads/2022/07/blogger.png)">
        <div class="container text-center">
            <h1 class="display-1 mb-4 single-blog-title text-dark bg-white rounded d-inline-block font-weight-light">Posts
                area</h1>
        </div>
    </div>
    <section id="gtco-single-content" class="bg-dark-custom-sec pt-5">
        <div class="container pt-5 mt-5">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-6 blog-holder">
                        <div class="blog-item-wrapper">
                            <div class="blog-item bg-dark-custom">
                                <div class="blog-img">
                                    <a href="{{ route('posts.slug', $post->slug) }}">
                                        <img src="{{ $post->acf->photo->url ?? 'img/blog-1.jpg' }}"
                                            alt="{{ $post->title->rendered }}" title="{{ $post->title->rendered }}" />
                                    </a>
                                </div>
                                <div class="blog-text" style="min-height: 460px">
                                    <div class="blog-tag">
                                        <a href="{{ route('posts.slug', $post->slug) }}">
                                            <h6>
                                                {{-- <small>{{ explode(',', $post->acf->categories_names) }}</small> --}}
                                            </h6>
                                        </a>
                                    </div>
                                    <div class="blog-title ">
                                        <a href="{{ route('posts.slug', $post->slug) }}">
                                            <h4 class="text-white">{{ $post->title->rendered }}</h4>
                                        </a>
                                    </div>
                                    <div class="blog-meta">
                                        <p class="blog-date">{{ $post->acf->crated_at }} /
                                        <p class="blog-comment ml-1"><a href="{{ route('posts.slug', $post->slug) }}">Post a
                                                comment</a></p>
                                        </p>
                                    </div>
                                    <div class="blog-desc text-white">
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
                @endforeach
            </div>
        </div>
    </section>
    @include('components.dark.footer')
@endsection
@section('js')
@endsection
