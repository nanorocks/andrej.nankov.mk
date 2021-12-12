<nav id="gtco-header-navbar" class="navbar navbar-expand-lg py-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            nankov.mk
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-nav-header" aria-controls="navbar-nav-header" aria-expanded="false" aria-label="Toggle navigation">
            <span class="lnr lnr-menu"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-nav-header">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#introduction">Introduction</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#goals">Goals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#posts">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#projects">Projects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#highlights">Highlights</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="#tpl">Tpl</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="#fun">Fun</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#soc">Soc.</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron d-flex align-items-center" style="background-image: url('{{ asset('img/header/header-' . rand(1, 6) . '.png') }}')">
    <div class="container text-center">
        <h1 class="display-2 mb-4 pt-5"> {{ $profile->title->rendered }}</h1>
        <p>
            {{ $profile->acf->address }} | <a href="mailto:{{ $profile->acf->email }}" class="font-weight-bold text-danger">{{ $profile->acf->email }}</a> | {{ $profile->acf->phone }}
        </p>
    </div>
</div>
