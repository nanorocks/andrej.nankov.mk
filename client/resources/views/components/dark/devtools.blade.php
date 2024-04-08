<section id="gtco-client" class="bg-dark-custom text-white">
    <div class="container">
        <a id="tpl"></a>
        <div class="section-content">
            <div class="title-wrap">
                <h2 class="section-title section-title-devtools">
                    <b>T</b>ools and <b>p</b>rogramming <b>l</b>anguages
                    <p class="section-sub-title">{!! $metas['Tools and programming languages'] !!}</p>
                </h2>
            </div>
            <div class="row">
                @foreach ($devTools as $dt)
                    <div class="col-12 col-sm-6 col-md-2 p-4 text-center">
                        <div class="client-item m-1">
                            <img class="img-responsive shadow" src="{{ $dt->acf->photo->url ?? '#' }}"
                                alt="{{ $dt->title->rendered }}" style="border-radius: 15%" data-toggle="tooltip"
                                data-placement="top" title="{{ $dt->title->rendered }}" />
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
