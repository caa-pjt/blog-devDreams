@extends('base')

@section('title', "Dev Dreams - MAS-RAD / DAR – Frameworks - Project")

@section('content')

    @include('partiales.blog-header')

    <section class="posts container">
        <h2 class="posts-title h1 pt-5 text-center">Nos derniers articles</h2>
        <div class="row mt-5 mb-5">
            <ul class="list-inline text-center">
                <li class="list-inline-item">
                    <a href="{{ route('home') }}" @class(['btn btn btn-light btn-lg', 'active' => empty(request()->query('category'))])>Tous</a>
                </li>
                </li>
                @foreach($categories as $category)
                    <li class="list-inline-item">
                        <a href="{{ url()->current() }}?category={{ $category->name }}"
                                @class(['btn btn-light btn-lg', 'active' => $category->name === request()->query
                                ('category')])
                        >{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        @forelse($posts as $post)
            <article class="card border-0 shadow-sm overflow-hidden mb-4">
                <div class="row g-0">
                    <div class="col-sm-4 position-relative bg-repeat-0 bg-size-cover article-img"
                         style="background-image: url('{{ $post->image ? $post->imageUrl() :
                             asset('images/no-img.png') }}')">
                        <a href="{{ route("show", ["slug" => $post->slug, "id" => $post->id]) }}"
                           class="position-absolute top-0
                            start-0
                            w-100 h-100"
                           aria-label="Lire plus"></a>
                    </div>
                    <div class="col-sm-8">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                    <span class="badge text-bg-secondary">
                                        @if($post->category)
                                            {{ $post->category->name }}
                                        @else
                                            null
                                        @endif </span>
                                <span class="fs-6 text-body-secondary border-start ps-3 ms-3">
                                        {{ $post->created_at->format('d M Y') }}
                                    </span>
                            </div>
                            <h3 class="h4 mb-3">
                                <a class="text-black"
                                   href="{{ route("show", ["slug" => $post->slug, "id" => $post->id]) }}">{{ $post->title }}</a>
                            </h3>
                            <p>{{ $post->excerpt(250) }}</p>
                            <hr class="my-4">
                            <div class="d-flex align-items-center justify-content-end">

                                <div class="d-flex align-items-center text-muted">
                                    <div class="d-flex align-items-center me-3">
                                        <a class="text-black"
                                           href="{{ route("show", ["slug" => $post->slug, "id" => $post->id])
                                               }}">Lire plus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <p>Aucun article trouvé :(</p>
        @endforelse
        {{ $posts->appends(request()->query())->links() }}
    </section>

@endsection