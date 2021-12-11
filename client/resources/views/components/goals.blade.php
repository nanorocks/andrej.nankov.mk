<section id="gtco-features" class="bg-white">
    <a id="goals"></a>
    <div class="container">
        <div class="section-content">
            <div class="title-wrap">
                <h2 class="section-title" style="margin-bottom: 0 !important;">
                    Goals
                </h2>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <p class="section-sub-title mb-3">{!! $metas['Goals'] !!}</p>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-md-12 features-holder">
                    <div class="row">
                        @foreach($goals as $goal)
                        <div class="col-md-4 col-sm-6 feature-item item mb-3 mb-3 text-center">
                            <div class="my-4">
                                <i class="{{ $goal->acf->icon }} fs-40" style="color: purple"></i>
                            </div>
                            <h4>{{ $goal->acf->heading }}</h4>
                            <p class="text-justify">{{ $goal->acf->subheading }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
