@extends('base')

@section('title', "Dev Dreams - " . $post->title )

@section('content')

    @include('partiales.blog-header-single')

    <section class="post-container container">

        <div class="row d-flex justify-content-center">
            <div class="col-md-10">

                <!-- POST -->
                <article class="post">
                    <div class="position-relative bg-repeat-0 bg-size-cover post-preview mb-5"
                         style="background-image: url('{{ $post->image ? $post->imageUrl() :
                             asset('images/no-img.png') }}')">
                    </div>
                    <div class="text-body-tertiary">
                        <div class="post-header">
                            <ul class="post-meta list-inline fw-bold">
                                <li class="list-inline-item">Publié le {{ $post->created_at->format('d M Y') }}</li>
                                @if($post->category !== null)
                                    <li class="list-inline-item">Dans la catégorie / <span
                                                class="text-capitalize">{{ $post->category->getName() }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <div class="post-content mt-4">
                            {{ $post->content }}
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>
    <section class="related-posts container">
        <div class="row mt-5">
            <div class="col-md-12 text-center mb-5">
                <h2 class="fs-1">Articles relationnels</h2>
                <p class="text-body-tertiary fw-bold">Les articles suivants pourraient aussi vous intéresser.</p>
            </div>
            @foreach($relatedPosts as $relatedPost)
                <div class="col-md-3 post-item">
                    <!-- Post-->
                    <article class="post">
                        <div class="post-preview"><a href="{{ route("show", ["slug" => $relatedPost->slug, "id" => $relatedPost->id])
                                       }}"><img class="img-fluid" src="{{ $relatedPost->image ? $relatedPost->imageUrl() :
                         asset('images/no-img.png') }}" alt="Image à la une"></a></div>
                        <div class="post-wrapper">
                            <div class="post-header pt-3">
                                <h2 class="post-title fs-5"><a class="text-black text-decoration-none" href="{{ route("show", ["slug" => $relatedPost->slug, "id" => $relatedPost->id])
                                       }}">{{ $relatedPost->getTitle() }}</a></h2>
                            </div>
                            <div class="post-content">
                                <p>{{ $relatedPost->excerpt() }}</p>
                                <p><a class="text-decoration-none" href="{{ route("show", ["slug" => $relatedPost->slug, "id" => $relatedPost->id])
                                       }}">Lire plus</a></p>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach

        </div>
    </section>

@endsection