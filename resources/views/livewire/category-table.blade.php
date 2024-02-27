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
                <th>Nom de la catégorie</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($categories as $category)
                <tr class="align-middle">
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <div class="d-flex justify-content-end gap-2 align-items-baseline">
                            <a class="btn btn-outline-secondary btn-sm"
                               href="{{ route('admin.category.edit', ['category' => $category]) }}"><i
                                        class="bi bi-pencil"></i> Editer</a>
                            <form action="{{ route('admin.category.destroy', ['category' => $category, "page" => request()->query('page')]) }}"
                                  method="post">
                                @csrf
                                @method("DELETE")
                                <button onclick="return confirm('Voulez-vous vraiment supprimer la catégorie ?') "
                                        type="submit" class="btn btn-outline-danger btn-sm"><i
                                            class="bi bi-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
</div>