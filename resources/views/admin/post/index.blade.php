@extends('admin-base')

@section('title', 'Administration de Articles')


@section('content')

    <!-- Posts content -->
    <div class="content mt-4">
        <div class="row">
            <div class="col mb-4">
                <div class="">
                    <h1 class="fs-2">Gestion des articles</h1>
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
                            <a href="{{route('admin.post.create')}}" class="btn btn-primary">Nouvel article</a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr class="">
                                <th>#</th>
                                <th>Titre</th>
                                <th>Slug</th>
                                <th>Création</th>
                                <th>Catégorie</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->slug }}</td>
                                    <td>{{ $post->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @if($post->category)
                                            {{ $post->category->name }}
                                        @else
                                            null
                                        @endif
                                    </td>
                                    <td>
                                        <span @class([$post->published == 1 ? 'text-success' : 'text-danger'])>{{ $post->published == 1 ? 'Actif' : 'Inactif' }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2 align-items-baseline">
                                            <a class="btn btn-outline-secondary btn-sm"
                                               href="{{ route('admin.post.edit', ['post' => $post]) }}">
                                                <i class="bi bi-pencil"></i> Editer
                                            </a>
                                            <form action="{{ route('admin.post.destroy', ['post' => $post, "page" => request()->query('page')]) }}"
                                                  method="post">
                                                @csrf
                                                @method("DELETE")
                                                <button onclick="return confirm('Voulez-vous vraiment supprimer l\'article ?') "
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
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
            <!-- END Articles -->
        </div>
        <!-- End row -->
    </div>
    <!-- end Posts content -->

@endsection
