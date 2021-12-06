<section id="gtco-pricing" class="bg-grey">
    <a id="highlights"></a>
    <div class="container">
        <div class="section-content">
            <div class="title-wrap">
                <h2 class="section-title">{!! $highlights->title->rendered !!}</h2>
                <p class="section-sub-title">{!! $metas['Highlights'] !!}</p>
            </div>

            <div class="mb-3 col-md-6 offset-md-3">
                {!! $highlights->content->rendered !!}
            </div>
        </div>
    </div>
</section>
