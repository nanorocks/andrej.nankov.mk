@extends('layouts.base')
@section('seo')
    <title>nankov.mk | {{ $post->title->rendered }}</title>
    <meta name="description" content="{{ $post->acf->meta_description }}">
    {{-- <meta name="keywords" content="{{ implode(',', $post->tags_names) }},{{ $post->acf->crated_at }}"> --}}
    <link rel="canonical" href="https://nankov.mk" />
    <meta name="author" content="Andrej Nankov | nanorocks">
    <meta property="published_date" content="{{ $post->acf->crated_at }}" />

    <meta name="robots" content="all">
    <meta property="og:title" content="nankov.mk | {{ $post->title->rendered }}" />
    <meta property="og:description" content="{{ $post->acf->meta_description }}" />
    <meta property="og:authon" content="Andrej Nankov | nanorocks" />
    <meta property="og:url" content="https://nankov.mk" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="nankov.mk" />
    <meta property="og:image" content="{{ asset($post->acf->photo->url) }}" />

    <meta property="article:published_time" content="{{ $post->acf->crated_at }}" />
    {{-- <meta property="article:tags" content="{{ implode(',', $post->tags_names) }}" /> --}}
@endsection
@section('body')
    @include('components.dark.nav')
    <div class="jumbotron d-flex align-items-center" style="background-image: url({{ asset($post->acf->photo->url) }})">
        <div class="container text-center">
            <h1 class="display-1 mb-4 single-blog-title text-light font-weight-light"></h1>
        </div>
    </div>
    <section id="gtco-single-content" class="bg-dark-custom-sec text-white">
        <div class="container">
            <div class="section-content blog-content pt-3">
                <div class="row">
                    <div class="col-12">
                        <h1 class="text-center pt-5 mt-3">{{ $post->title->rendered }}</h1>

                        <p class="m-0 p-0 text-center"><small class="ml-1 text-muted" style="font-size: 1.4rem">Created
                                on: {{ $post->acf->crated_at }}</small>

                        </p>
                        <p class="text-justify pt-4 mt-4">
                            {!! $post->content->rendered !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('components.dark.footer')
@endsection
@section('js')
@endsection
