<footer class="mastfoot mb-3 bg-white py-4 border-top">
    <div class="inner container">
        <div class="row">
            <a id="soc"></a>
            <div class="col-md-6 d-flex align-items-center justify-content-md-start justify-content-center">
                <p class="mb-0">{!! $metas['Footer'] !!}
                </p>
            </div>
            <div class="col-md-6">
                <nav class="nav nav-mastfoot justify-content-md-end justify-content-center">
                    @foreach($socMedias as $sm)
                        <a class="nav-link" href="{{ $sm->acf->url }}" title="{{ $sm->title->rendered }}" target="_blank">
                            <i class="{{ $sm->acf->icon }}"></i>
                        </a>
                    @endforeach
                </nav>
            </div>
        </div>
    </div>
</footer>
