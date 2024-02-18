<div id="top" class="banner banner-blog">
    <div class="banner-content">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-xs-12">
                    <div class="header-wrap">
                        <h1 class="post-title text-uppercase mb-2" title="{{ $post->title }}">{{ $post->title }}</h1>
                        <div class="banner-info fw-lighter d-flex align-items-center gap-3">
                            <p class="fs-5">Mis à jour le <span>{{ $post->updated_at->format('d M Y') }}</span></p>
                            <p class="badge text-bg-secondary p-3 text-uppercase">{{ $post->category->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bnr-strp"></div>
</div>