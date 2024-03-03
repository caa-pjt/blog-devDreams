<div class="card">
    <div class="card-header">
        <div class="align-items-center d-flex flex-wrap gap-3 justify-content-between">
            <div id="bootstrap-data-table_filter" class="col-lg-6 col-md-8 col-sm-12">
                <form action="?search" method="get" class="input-group">
                    <span class="input-group-text" for="search">Filtrer</span>
                    <input wire:ignore wire:model.live.debounce.250ms="search" name="search" type="text"
                           class="form-control"
                           value="{{ $search }}"
                           placeholder="Rechercher un article"
                           id="search"
                           aria-label="Username"
                           aria-describedby="search">
                    <button type="submit" class="btn btn-primary invisible">Rechercher</button>
                </form>
            </div>
            <a href="{{route('admin.post.create')}}" class="btn btn-primary">Nouvel article</a>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
            <th>#</th>
            @include('admin.partials.table-header', ['field' => 'title', 'label' => 'Titre', 'orderField' =>
            $postField, 'orderDirection' => $orderDirection])

            <th>Image à la une</th>
            @include('admin.partials.table-header', ['field' => 'created_at', 'label' => 'Création', 'orderField' =>
            $postField, 'orderDirection' => $orderDirection])
            @include('admin.partials.table-header', ['field' => 'category_id', 'label' => 'Catégorie', 'orderField'
            => $postField, 'orderDirection' => $orderDirection])
            @include('admin.partials.table-header', ['field' => 'published', 'label' => 'Status', 'orderField' =>
            $postField, 'orderDirection' => $orderDirection])
            <th class="text-end">Actions</th>

            </thead>

            <tbody>
            @forelse ($posts as $post)
                <tr class="align-middle" wire:key='{{ $post->id }}'>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>
                        @if($post->image)
                            <img src="{{ $post->imageUrl() }}" alt="image à la une" style="width:
                                    50px">
                        @else
                            Aucune image
                        @endif
                    </td>
                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($post->category)
                            {{ $post->category->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <span @class([$post->published == 1 ? 'text-success' : 'text-danger'])>{{ $post->published == 1 ? 'Actif' : 'Inactif' }}</span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end gap-2 align-items-center">
                            <a class="btn btn-outline-secondary btn-sm"
                               href="{{ route('show', ['slug' => $post->slug, 'id' => $post->id ]) }}">
                                <i class="bi bi-eye"></i> Voir
                            </a>
                            <a class="btn btn-outline-secondary btn-sm"
                               href="{{ route('admin.post.edit', ['post' => $post, 'page' => $this->page ]) }}">
                                <i class="bi bi-pencil"></i> Editer
                            </a>
                            <button wire:click.prevent="postData({{ $post }})"
                                    type="button"
                                    class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Aucun article trouvé :(</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $posts->links() }}
    </div>
    @if(count($posts)  > 0)
        {{--@include('admin.partials.delete-modal')--}}
        <livewire:delete-confirmation-modal/>
    @endif
</div>


<script>
    function openModal() {
        // Déclencher l'événement personnalisé "open-modal"
        console.log('openModal');
        window.dispatchEvent(new Event("open-modal"));
    }
</script>