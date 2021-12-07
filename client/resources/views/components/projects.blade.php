<section id="gtco-portfolio" class="bg-white">
    <div class="container">
        <a id="projects"></a>
        <div class="section-content">
            <div class="title-wrap">
                <h2 class="section-title">{{ $projects[0]->acf->category }}</h2>
                <p class="section-sub-title">{!! $metas['Projects Area'] !!}</p>
            </div>
            <div class="row">
                <div class="col-md-12 portfolio-holder">
                    <div class="filter-button-group btn-filter d-flex justify-content-center">
                        <a tabindex="0" class="is-checked" data-filter="*">Show All</a>
                        @foreach($projectsStatus as $key => $status)
                            <a tabindex="0" data-filter=".{{ $status }}" class="text-capitalize">{{ $status }}</a>
                        @endforeach
                    </div>

                    <div class="grid-portfolio">
                        <div class="grid-sizer"></div>
                        <div class="gutter-sizer"></div>
                        @foreach($projects as $index => $project)
                            <a title="{{ $project->acf->created_at }} | {{ $project->title->rendered }}" href="{{ route('projects.slug', $project->slug) }}" class="text-dark grid-item {{ $project->acf->status }} {{ ($index === 2 || $index === 5 || $index === 8 || $index === 10 || $index === 13 || $index === 15 || $index === 18) ? 'grid-item-height' : '' }}">
                                <div class="grid-item-wrapper text-center">
                                    <img src="{{ 'https://eu.ui-avatars.com/api/?size=20&background=random&name='. $project->title->rendered ?? 'img/blog-1.jpg' }}" alt="portfolio-img"
                                         class="portfolio-item"/>
                                    {{ $project->title->rendered }}
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
