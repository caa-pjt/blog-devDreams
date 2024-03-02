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
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary">Nouvelle
                catégorie</a>
        </div>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-hover">
            <thead>
            <tr class="align-middle">
                <th>#</th>
                @include('admin.partials.table-header', ['field' => 'name', 'label' => 'Nom de la catégorie', 'orderField'  => $field, 'orderDirection' => $orderDirection])
                @include('admin.partials.table-header', ['field' => 'created_at', 'label' => 'Création', 'orderField' => $field, 'orderDirection' => $orderDirection])
                <th class="text-end">Actions</th>
            </tr>
            </thead>

            <tbody>
            @forelse($categories as $category)
                <tr class="align-middle">
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->getName() }}</td>
                    <td>{{ $category->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="d-flex justify-content-end gap-2 align-items-baseline">
                            <a class="btn btn-outline-secondary btn-sm"
                               href="{{ route('admin.category.edit',  ['category' => $category, 'page' =>
                               request()->get('page'), 'field' => $field, 'orderDirection' => $orderDirection]) }}">
                                <i class="bi bi-pencil"></i> Editer
                            </a>

                            <button wire:click.prevent="postData({{ $category }})"
                                    type="button"
                                    class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Aucune catégorie trouvée :(</td>
                </tr>

            @endforelse
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
    @if(count($categories)  > 0)
        <livewire:delete-confirmation-modal/>

    @endif
</div>