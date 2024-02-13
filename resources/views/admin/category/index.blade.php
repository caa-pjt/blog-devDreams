@extends('base')

@section('title', 'Administration des catégories')


@section('content')

    <div class="row mt-5 mb-4">
        <h1>Administration des catégories</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                        <a href="{{route('admin.category.create')}}" class="btn btn-primary ms-1">Nouvelle catégorie</a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nom de la catégorie</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <th>{{ $category->id }}</th>
                                <th>{{ $category->name }}</th>
                                <th>
                                    <div class="d-flex justify-content-end">
                                        <a class="btn btn-outline-secondary btn-sm" style="margin-right: 5px"
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
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection
