@extends('admin-base')

@section('title', 'Administration des catégories')


@section('content')

    <!-- Posts content -->
    <div class="content mt-4">
        <div class="row">
            <div class="col mb-4">
                <div class="">
                    <h1 class="fs-2">Gestion des Catégories</h1>
                </div>
            </div>

            <!--Articles -->
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <div class="align-items-center d-flex flex-wrap gap-3 justify-content-between">
                            <div id="bootstrap-data-table_filter" class="col-lg-2 col-md-6 col-sm-12">
                                <label class="visually-hidden" for="inlineFormInputGroupUsername">Rechercher</label>
                                <div class="input-group">
                                    <div class="input-group-text">Search</div>
                                    <input
                                            type="text"
                                            name="q"
                                            class="form-control"
                                            id="inlineFormInputGroupUsername"
                                            placeholder="Filtrer...."/>
                                </div>
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
            </div>
            <!-- END Articles -->
        </div>
        <!-- End row -->
    </div>
    <!-- end Categories content -->

@endsection
