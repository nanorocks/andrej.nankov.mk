<section id="gtco-blog" class="bg-dark-custom-sec text-white">
    <a id="posts"></a>
    <div class="container">
        <div class="section-content">
            <div class="title-wrap mb-5">
                <h2 class="section-title mb-0">Posts Area</h2>
                <a href="{{ route('posts') }}" style="font-size: 20px">view all</a>
                <p class="section-sub-title">{!! $metas['Posts Area'] !!}</p>
            </div>
            <div class="row">
                <div class="col-md-12 blog-holder">
                    <div class="posts">
                        @foreach ($posts as $post)
                            {{-- {{ dd($post) }} --}}
                            <div class="m-2">
                                <div class="blog-item-wrapper">
                                    <div class="blog-item bg-dark-custom">
                                        <div class="blog-img">
                                            <a href="{{ route('posts.slug', $post->slug) }}">
                                                <img src="{{ $post->acf->photo->url ?? 'img/blog-1.jpg' }}"
                                                    alt="{{ $post->title->rendered }}"
                                                    title="{{ $post->title->rendered }}" />
                                            </a>
                                        </div>
                                        <div class="blog-text" style="min-height: 460px">
                                            <div class="blog-tag">
                                                <a href="{{ route('posts.slug', $post->slug) }}">
                                                    <h6>
                                                        {{-- <small>{{ explode(',', $post->acf->categories_names) }}</small> --}}
                                                    </h6>
                                                </a>
                                            </div>
                                            <div class="blog-title ">
                                                <a href="{{ route('posts.slug', $post->slug) }}">
                                                    <h4 class="text-white">{{ $post->title->rendered }}</h4>
                                                </a>
                                            </div>
                                            <div class="blog-meta">
                                                <p class="blog-date">{{ $post->acf->crated_at }} /
                                                <p class="blog-comment ml-1"><a
                                                        href="{{ route('posts.slug', $post->slug) }}">Post a
                                                        comment</a></p>
                                                </p>
                                            </div>
                                            <div class="blog-desc">
                                                <p>{!! $post->excerpt->rendered !!}</p>
                                            </div>
                                            <div class="blog-author">
                                                <p>by {{ $post->acf->creator }}</p>
                                            </div>
                                            <div class="blog-share-wrapper">
                                                <a class="blog-share"
                                                    href="https://www.facebook.com/sharer/sharer.php?u={{ route('posts.slug', $post->slug) }}">
                                                    <i class="bi bi-facebook"></i>
                                                </a>
                                                <a class="blog-share"
                                                    href="https://www.linkedin.com/sharing/share-offsite/?url={{ route('posts.slug', $post->slug) }}">
                                                    <i class="bi bi-linkedin"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
