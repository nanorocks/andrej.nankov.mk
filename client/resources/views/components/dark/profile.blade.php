<section id="gtco-section-featurettes" class="featurettes bg-dark-custom text-white">
    <a id="introduction"></a>
    <div class="container">
        <div class="section-content">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="title-wrap">
                        <h2 class="section-title">
                            Introduction
                        </h2>
                        <p class="section-sub-title">
                            {!! $metas['Introduction'] !!}
                        </p>
                    </div>
                    <div class="featurettes-wrap text-left mb-4">
                        <div class="row featurettes-item">
                            <div class="col-md-3 offset-md-2 col-sm-6 text-center">
                                <img class="my-5" style="border-radius: 50%" src="{{ $profile->acf->photo->url }}"
                                    alt="{{ $profile->acf->full_name }}" />
                            </div>
                            <div class="col-md-5 offset-md-right-2 col-sm-6 text-justify pt-5">
                                {!! $profile->content->rendered !!}
                            </div>
                        </div>

                    </div>

                    <div class="featurettes-wrap text-left">

                        <div class="row featurettes-item">
                            <div class="col-md-8 offset-md-2 col-sm-12 mb-5 text-justify">
                                <h4 class="mb-4">Education </h4>
                                {!! $profile->acf->education !!}
                            </div>
                        </div>
                    </div>

                    <div class="featurettes-wrap text-left">
                        <div class="row featurettes-item">
                            <div class="col-md-8 offset-md-2 col-sm-12 offset-sm-0">
                                <h4 class="mb-4">Area of work</h4>
                                <p>{!! $profile->acf->area_of_work !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
