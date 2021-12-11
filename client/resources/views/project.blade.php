@extends('layouts.app')
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
                        <a class="nav-link" href="/">Back to Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="jumbotron d-flex align-items-center" style="background-image: url({{ asset('img/blog-5.jpg')  }})">
        <div class="container text-center">
            <h1 class="display-1 mb-4 single-blog-title text-light font-weight-light">{{ $project->title->rendered }}</h1>
        </div>
    </div>
    <section id="gtco-single-content" class="bg-white">
        <div class="container">
            <div class="section-content blog-content">
                <div class="row">
                    <div class="col-md-3 offset-md-2 pt-5">
                        <img class="mx-auto d-block shadow-lg border" width="320px" src="{{ asset($project->acf->photo->url) }}" alt="{{ $project->title->rendered }}" style="border-radius: 15px;">
                    </div>
                    <div class="col-md-5 mt-4">
                        <h4><span>{{ $project->title->rendered }}</span></h4>
                        <p>{!! $project->content->rendered !!}</p>

                        <p><strong>Link:</strong><br /><a href="{{ $project->acf->link }}" target="_blank" title="{{ $project->title->rendered }}">{{ $project->acf->link }}</a></p>
                        <p><strong>Created:</strong><br /> {{ $project->acf->created_at }}</p>
                        <p><strong>Related to:</strong><br /> {{ $project->acf->related_to }}</p>
                        <p><strong>Other Contributors:</strong><br /> {!! $project->acf->contributors !!}</p>
                        <p><strong>Status:</strong><br /> <span class="text-capitalize">{{ $project->acf->status }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('components.footer')
@endsection
