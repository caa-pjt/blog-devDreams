@extends('admin.base')

@section('title', 'Administration du blog')


@section('content')

    <div class="row mt-5 mb-4">
        <h1>Administration des articles</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-info">Tous</button>
                        <button type="button" class="btn btn-outline-info ms-1">Online</button>
                        <a href="{{route('admin.post.create')}}" class="btn btn-primary ms-1">Nouveau</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Titre</th>
                            <th>Resumé</th>
                            <th>Catégorie</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <th>{{ $post->id }}</th>
                                <th>{{ $post->title }}</th>
                                <th>{{ $post->excerpt(50) }}</th>
                                <th>
                                    @if($post->category)
                                        <span class="badge bg-secondary">{{ $post->category->name }}</span>
                                    @else
                                        null
                                    @endif
                                </th>
                                <th>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                                        <label class="label" for="flexSwitchCheckDefault">Online?</label>
                                    </div>
                                </th>
                                <th>
                                    <div class="d-flex justify-content-end">
                                        <a class="btn btn-outline-secondary btn-sm" style="margin-right: 5px"
                                           href="{{ route('admin.post.edit', ['post' => $post]) }}"><i class="bi bi-pencil"></i> Editer</a>
                                        <form action="{{ route('admin.post.destroy', ['post' => $post, "page" => request()->query('page')]) }}" method="post">
                                            @csrf
                                            @method("DELETE")
                                            <button onclick="return confirm('Voulez-vous vraiment supprimer l\'article ?') " type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Supprimer</button>
                                        </form>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $posts->links() }}
                </div>
            </div>
        </div>

    </div>

@endsection
