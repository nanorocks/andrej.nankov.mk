@extends('layouts.base')
@section('seo')
    <title>nankov.mk | {{ $project->title->rendered }}</title>
    <meta name="description" content="project: {{ $project->title->rendered }}">
    <meta name="keywords"
        content="{{ $project->acf->related_to }}, {{ $project->acf->status }}, {{ $project->acf->created_at }}">
    <link rel="canonical" href="https://nankov.mk" />
    <meta name="robots" content="all">
    <meta property="og:title" content="nankov.mk" />
    <meta property="og:description" content="{{ $project->title->rendered }}" />
    <meta property="og:url" content="https://nankov.mk" />
    <meta property="og:type" content="article" />
    <meta property="og:site_name" content="nankov.mk" />
    <meta property="og:image" content="{{ asset($project->acf->photo->url) }}" />
@endsection
@section('body')
    @include('components.dark.nav')


    <div class="jumbotron d-flex align-items-center" style="background-image: url({{ asset('img/blog-5.jpg') }})">
        <div class="container text-center">
            <h1 class="display-1 mb-4 single-blog-title text-light font-weight-light">{{ $project->title->rendered }}</h1>
        </div>
    </div>
    <section id="gtco-single-content" style="background: #101827" class="text-white">
        <div class="container">
            <div class="section-content blog-content">
                <div class="row">
                    <div class="col-md-3 offset-md-2 pt-5">
                        <img class="mx-auto d-block shadow-lg border" width="320px"
                            src="{{ asset($project->acf->photo->url) }}" alt="{{ $project->title->rendered }}"
                            style="border-radius: 15px;">
                    </div>
                    <div class="col-md-5 mt-4">
                        <h4><span>{{ $project->title->rendered }}</span></h4>
                        <p>{!! $project->content->rendered !!}</p>

                        <p><strong>Link:</strong><br /><a href="{{ $project->acf->link }}" target="_blank"
                                title="{{ $project->title->rendered }}">{{ $project->acf->link }}</a></p>
                        <p><strong>Created:</strong><br /> {{ $project->acf->created_at }}</p>
                        <p><strong>Related to:</strong><br /> {{ $project->acf->related_to }}</p>
                        <p><strong>Contributors:</strong><br /> {!! $project->acf->contributors !!}</p>
                        <p><strong>Status:</strong><br /> <span class="text-capitalize">{{ $project->acf->status }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('components.dark.footer')
@endsection
