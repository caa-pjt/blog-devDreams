<div id="posts">
    <div class="row mt-5 mb-5">
        <ul class="list-inline text-center" id="category">
            <li class="list-inline-item">
                <a wire:click.prevent="filterByCategory('')" href="{{ route('home') }}"
                        @class(['btn btn-light btn-lg', 'active' => empty($cat) ])>Tous</a>
            </li>
            @foreach($categories as $category)
                <li class="list-inline-item">
                    <a wire:click.prevent="filterByCategory('{{ $category }}')"
                       href="{{ route('home', ['cat' => $category]) }}"
                            @class(['btn btn-light btn-lg text-capitalize', 'active' => $cat === $category ])>
                        {{ $category }}
                    </a>
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
                    <a wire:click.prevent="redirectToPost('{{ $post->slug }}', {{ $post->id }})"
                       href="{{ route("show", ["slug" => $post->slug, "id" => $post->id]) }}"
                       class="position-absolute top-0 start-0 w-100 h-100"
                       aria-label="Lire plus"></a>
                </div>
                <div class="col-sm-8">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3 gap-2">
                            @if($post->category)
                                <span class="badge text-bg-secondary">
                                    {{ $post->category->getName() }}
                                </span>
                            @endif
                            <span class="text-body-secondary">
                                {{ $post->created_at->format('d M Y') }}
                            </span>
                        </div>
                        <h3 class="h4 mb-3">
                            <a class="text-black"
                               href="{{ route("show", ["slug" => $post->slug, "id" => $post->id]) }}"
                               wire:click.prevent="redirectToPost('{{ $post->slug }}', {{ $post->id }})">{{
                               $post->getTitle() }}</a>
                        </h3>
                        <p>{{ $post->excerpt(250) }}</p>
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <p>Par : {{ $post->user->getName() }}</p>
                            <a class="text-black"
                               wire:click.prevent="redirectToPost('{{ $post->slug }}', {{ $post->id }})"
                               href="{{ route("show", ["slug" => $post->slug, "id" => $post->id]) }}">
                                Lire plus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    @empty
        <p>Aucun article trouvé :(</p>
    @endforelse

    {{ $posts->links(data: ['scrollTo' => '#posts']) }}
</div>